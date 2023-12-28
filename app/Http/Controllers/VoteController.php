<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Member;
use App\Models\AVoteResult;
use App\Models\AVoteL;
use App\Models\DeptBase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function index()
    {
        $data = Vote::orderBy('VOTE_DATE','desc')->get();

        return view('vote.index', ['voteData' => $data]);
    }
        
    public function voteResult_index(Request $request)
    {
        $voteTitle_auto = $this->voteTitle();
        $voteTitle = $request->input('voteTitle');

        $voteId = ($voteTitle == null) ? vote::max('VOTE_ID') : $voteTitle;

        $data = DB::table('A_VOTE_RESULT_TEST as R')
            ->select(
                'R.VOTE_RESULT_ID',
                'D.DEPT_NAME AS VOTE_DEPT_NAME',
                'E.EMP_NAME AS VOTE_EMP_NAME',
                'H.TITLE',
                'R.VOTE_USER',
                'R.VOTE_DEPT_CODE',
                'L.VOTE_TITLE'
            )
            ->leftJoin('A_VOTE_L_TEST as L', function ($join) {
                $join->on('R.VOTE_ID', '=', 'L.VOTE_ID')
                    ->on('R.VOTE_LINE_NO', '=', 'L.LINE_NO');
            })
            ->leftJoin('DEPT_BASE_TEST as D', function ($join) {
                $join->on('R.VOTE_DEPT_CODE', '=', 'D.DEPT_CODE')
                    ->where('D.STATUS_FLAG', '!=', 'D');
            })
            ->leftJoin('EMP_BASE_TEST as E', 'R.VOTE_USER', '=', 'E.EMP_CODE')
            ->leftJoin('A_VOTE_H_TEST as H', 'R.VOTE_ID', '=', 'H.VOTE_ID')
            ->where('L.VOTE_ID', $voteId)
            ->get();

        return view('vote.result.index', [
            'voteData' => $data,
            'voteTitle_auto' => $voteTitle_auto
        ]);
    }

    // voteTitle建議選項
    public function voteTitle(){        
        $data = Vote::select(DB::raw("CONCAT(VOTE_ID, ' - ', TITLE) as TITLE"), 'VOTE_ID')
                    ->get();

        return $data;
    }

    public function store(Request $request){

        $VOTE_DATE = $request->input('VOTE_DATE');
        $CREATE_BY = Auth::user()->USER_ID;
        $START_DATE = $request->input('START_DATE');
        $END_DATE = $request->input('END_DATE');
        $USE_GROUP = $request->input('deptcodesCodeInput');        
        $TITLE = $request->input('TITLE');
        $TITLE_DESC = $request->input('TITLE_DESC');
        $VOTE_INFO = $request->input('VOTE_INFO');

        date_default_timezone_set('Asia/Taipei');
        $CREATE_DATE = date('Y/m/d H:i:s');
        
        $VOTE_DATE = str_replace('-', '/', $VOTE_DATE);
        $START_DATE = str_replace('-', '/', $START_DATE);
        $END_DATE = str_replace('-', '/', $END_DATE);

        // $lastId = Vote::max('VOTE_ID') + 1;

        // insert進投票資料表
        Vote::insert([
            // 'VOTE_ID' => $lastId,
            'VOTE_DATE' => $VOTE_DATE,
            'TITLE' => $TITLE,
            'TITLE_DESC' => $TITLE_DESC,
            'USE_GROUP' => $USE_GROUP,
            'START_DATE' => $START_DATE,
            'END_DATE' => $END_DATE,
            'MODIFY_FLAG' => 'A',
            'CREATE_BY' => $CREATE_BY,
            'CREATE_DATE' => $CREATE_DATE,
            'LAST_UPDATE_BY' => $CREATE_BY,
            'LAST_UPDATE_DATE' => $CREATE_DATE,
            'ACHIEVE_QTY' => '0',
            'VOTE_USER' => '0'
        ]);

        $this->insertVoteInfo($VOTE_INFO);

        return redirect()->route('vote.index')->with('notice', '投票資料已成功新增！');
    }

    public function insertVoteInfo($VOTE_INFO){

        $vote_line_count = count($VOTE_INFO);
        
        $lastId = AVoteL::max('VOTE_LINE_ID') + 1;
        $VOTE_ID = Vote::max('VOTE_ID');

        date_default_timezone_set('Asia/Taipei');
        $CREATE_DATE = date('Y/m/d H:i:s');

        $USER_ID = Auth::user()->USER_ID;
        $LINE_NO = 1;

        foreach ($VOTE_INFO as $info) {           

            AVoteL::insert([
                'VOTE_LINE_ID' => $lastId,
                'VOTE_ID' => $VOTE_ID,
                'LINE_NO' => $LINE_NO,            
                'VOTE_TITLE' => $info['TITLE'],
                'VOTE_TITLE_DESC' => $info['TITLE_DESC'],
                'MODIFY_FLAG' => 'A',
                'CREATE_BY' => $USER_ID,
                'CREATE_DATE' => $CREATE_DATE,
                'LAST_UPDATE_BY' => $USER_ID,
                'LAST_UPDATE_DATE' => $CREATE_DATE
            ]);

            $LINE_NO++;  
        }
    }

    public function create(){

        // 傳入新增頁面的部門選項
        $allDept = DeptBase::select('DEPT_NAME', 'DEPT_CODE')
                ->distinct()
                ->get();

        return view("vote.create", [
                    'allDept' => $allDept
        ]);
    }

    public function edit($VOTE_ID){  

        $allDept = DeptBase::select('DEPT_NAME', 'DEPT_CODE')
                            ->where('STATUS_FLAG', '<>', 'D')
                            ->distinct()
                            ->get();

        $vote = vote::find($VOTE_ID);           
        
        $CREATE_BY = member::select('USER_NAME')
                            ->where('USER_ID', $vote->CREATE_BY)
                            ->first();

        // 投票部門        
        $USE_GROUP_array = explode(',',($vote->USE_GROUP));

        $USE_GROUP = [];

        foreach ($USE_GROUP_array as $group) {
                
            $groupName = DB::table('DEPT_BASE_TEST')
                        ->select("DEPT_NAME")
                        ->where('STATUS_FLAG', '!=', 'D')
                        ->where('DEPT_CODE', $group)
                        ->first();

            if ($groupName) {
                array_push($USE_GROUP, $groupName->DEPT_NAME);
            }
        }

        $USE_GROUP_FINAL = implode(', ', $USE_GROUP);
        
        // 已投票人員                
        $VOTER_array = explode(',',(AVoteResult::where('VOTE_ID', $VOTE_ID)->pluck('CREATE_BY')->implode(',')));

        $VOTER = [];

        foreach ($VOTER_array as $voter) {
                
            $voterName = DB::table('EMP_BASE_TEST')
                        ->select("EMP_NAME")
                        ->where('EMP_CODE', $voter)
                        ->first();

            if ($voterName) {
                array_push($VOTER, $voterName->EMP_NAME);
            }
        }

        $VOTER_FINAL = implode(', ', $VOTER);
        
        // 投票明細           
        $vote_info = DB::table('A_VOTE_L_TEST')
                    ->where('VOTE_ID', $VOTE_ID)
                    ->get();

        return view("vote.edit",[
            'vote' => $vote,
            'CREATE_BY' => $CREATE_BY,
            'USE_GROUP_FINAL' => $USE_GROUP_FINAL,
            'USE_GROUP_CODE' => $vote->USE_GROUP,            
            'VOTER_FINAL' => $VOTER_FINAL,
            'VOTE_INFO' => $vote_info,
            'allDept' => $allDept
        ]);
    }

    public function update(Request $request, $VOTE_ID){  

        $VOTE_DATE = $request->input('VOTE_DATE');
        $CREATE_BY = Auth::user()->USER_ID;
        $START_DATE = $request->input('START_DATE');
        $END_DATE = $request->input('END_DATE');
        $USE_GROUP = $request->input('deptcodesCodeInput');        
        $TITLE = $request->input('TITLE');
        $TITLE_DESC = $request->input('TITLE_DESC');
        $VOTE_INFO = $request->input('VOTE_INFO');

        date_default_timezone_set('Asia/Taipei');
        $CREATE_DATE = date('Y/m/d H:i:s');
        
        $VOTE_DATE = str_replace('-', '/', $VOTE_DATE);
        $START_DATE = str_replace('-', '/', $START_DATE);
        $END_DATE = str_replace('-', '/', $END_DATE);       

        $updateData = [
            'VOTE_DATE' => $VOTE_DATE,
            'TITLE' => $TITLE,
            'TITLE_DESC' => $TITLE_DESC,
            'USE_GROUP' => $USE_GROUP,
            'START_DATE' => $START_DATE,
            'END_DATE' => $END_DATE,
            'MODIFY_FLAG' => 'A',
            'LAST_UPDATE_BY' => $CREATE_BY,
            'LAST_UPDATE_DATE' => $CREATE_DATE,
            'ACHIEVE_QTY' => '0',
            'VOTE_USER' => '0'
        ];

        Vote::where('VOTE_ID', $VOTE_ID)->update($updateData);
        
        $this->saveVoteData($VOTE_ID, $VOTE_INFO);

        return redirect()->back()->with('notice', '投票資料已成功編輯！');     
    }    

    public function saveVoteData($VOTE_ID, $VOTE_INFO)
    {
        if (Auth::check()) {
   
            // 先刪除目前有的投票明細
            AVOTEL::where('VOTE_ID', $VOTE_ID)->delete();

            $vote_line_count = count($VOTE_INFO);
        
            $lastId = AVoteL::max('VOTE_LINE_ID') + 1;
    
            date_default_timezone_set('Asia/Taipei');
            $CREATE_DATE = date('Y/m/d H:i:s');
    
            $USER_ID = Auth::user()->USER_ID;
            $LINE_NO = 1;
    
            foreach ($VOTE_INFO as $info) {           
    
                AVoteL::insert([
                    'VOTE_LINE_ID' => $lastId,
                    'VOTE_ID' => $VOTE_ID,
                    'LINE_NO' => $LINE_NO,            
                    'VOTE_TITLE' => $info['TITLE'],
                    'VOTE_TITLE_DESC' => $info['TITLE_DESC'],
                    'MODIFY_FLAG' => 'A',
                    'CREATE_BY' => $USER_ID,
                    'CREATE_DATE' => $CREATE_DATE,
                    'LAST_UPDATE_BY' => $USER_ID,
                    'LAST_UPDATE_DATE' => $CREATE_DATE
                ]);

                

                // dd($info);
    
                $LINE_NO++;  
            }
        } 
        else {
            dd($user_id);
        }
    }
    
    public function bulkDestroy(Request $request) {
        $ids = explode(',', $request->input('deleteIds'));
        
        // 刪除所選中的項目 
        $deletedCount = Vote::whereIn('VOTE_ID', $ids)->delete();

        if ($deletedCount > 0) {
            return redirect()->route('vote.index')->with('notice', '選取項目已成功刪除！');
        } 
        else {
            return redirect()->route('vote.index')->with('error', '刪除失敗！');
        }
    }
}
