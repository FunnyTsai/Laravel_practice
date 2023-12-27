<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VoteStation;
use App\Models\Vote;
use App\Models\Member;
use App\Models\AVoteResult;
use App\Models\EmpBase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VoteStationController extends Controller
{
    public function index()
    {
        $data = VoteStation::orderBy('VOTE_DATE','desc')->get();

        return view('vote.station.index', ['voteData' => $data]);
    }

    public function create(){
        return view("vote.station.create");
    }

    public function edit($VOTE_ID){
        $vote = vote::find($VOTE_ID);   

        $USER_ID = Auth::user()->USER_ID;
        $VOTE_LINE_NO = null; 

        $voteBefore = AVoteResult::select("VOTE_LINE_NO")
                                ->where('VOTE_ID', $VOTE_ID)
                                ->where('VOTE_USER', $USER_ID)
                                ->value("VOTE_LINE_NO");

        if ($voteBefore) {
            $VOTE_LINE_NO = $voteBefore;
        }   
        
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
        $VOTER_array = explode(',',($vote->VOTE_USER));

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

        return view("vote.station.edit",[
            'vote' => $vote,
            'CREATE_BY' => $CREATE_BY,
            'USE_GROUP_FINAL' => $USE_GROUP_FINAL,
            'VOTER_FINAL' => $VOTER_FINAL,
            'VOTE_INFO' => $vote_info,
            'VOTE_RESULTS' => null,
            'VOTE_LINE_NO' => $VOTE_LINE_NO,
        ]);
    }
    
    public function update(Request $request, $VOTE_ID){  
        
        // 取得投票明細編號
        $VOTE_LINE_NO = substr($request->input('selectedValue'), -1);

        date_default_timezone_set('Asia/Taipei');
        $last_update_date = date('Y/m/d H:i:s');

        $user = Auth::user();
        $USER_ID = $user->USER_ID;
        
        $lastId = AVoteResult::max('VOTE_RESULT_ID') + 1;

        $VOTE_DEPT_CODE = EmpBase::select("EMP_DEPT_CODE")
                        ->where("EMP_CODE", $USER_ID)
                        ->value("EMP_DEPT_CODE");

        // dd($VOTE_DEPT_CODE);

        $voteBefore = AVoteResult::where('VOTE_ID', $VOTE_ID)
                                ->where('VOTE_USER', $USER_ID)
                                ->first();

        if ($voteBefore !== null) {

            return redirect()->back()->with('error', '投票失敗，您已經投過了喔！');    
        } 
        else {

            AVoteResult::insert([
                'VOTE_RESULT_ID' => $lastId,
                'VOTE_ID' => $VOTE_ID,
                'VOTE_LINE_NO' => $VOTE_LINE_NO,
                'VOTE_USER' => $USER_ID,
                'VOTE_DEPT_CODE' => $VOTE_DEPT_CODE,
                'MODIFY_FLAG' => 'A',
                'CREATE_BY' => $USER_ID,
                'CREATE_DATE' => $last_update_date,
                'LAST_UPDATE_BY' => $USER_ID,
                'LAST_UPDATE_DATE' => $last_update_date
            ]);
            
            return redirect()->back()->with('notice', '已完成投票！');    
        }                              
    }
    

    public function show($VOTE_ID){
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
        $VOTER_array = explode(',',($vote->VOTE_USER));

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

        // // 各選項投票數量
        $vote_results = DB::table('A_VOTE_L_TEST')
                            ->select('vln.LINE_NO', DB::raw('COUNT(avrt.VOTE_LINE_NO) AS COUNT'))
                            ->from('A_VOTE_L_TEST AS vln')
                            ->leftJoin('A_VOTE_RESULT_TEST AS avrt', function ($join) use ($VOTE_ID) {
                                $join->on('vln.LINE_NO', '=', 'avrt.VOTE_LINE_NO')
                                    ->where('avrt.VOTE_ID', '=', $VOTE_ID);
                            })
                            ->where('vln.VOTE_ID', $VOTE_ID)
                            ->groupBy('vln.LINE_NO')
                            ->get();

        return view("vote.station.result",[
            'vote' => $vote,
            'CREATE_BY' => $CREATE_BY,
            'USE_GROUP_FINAL' => $USE_GROUP_FINAL,
            'VOTER_FINAL' => $VOTER_FINAL,
            'VOTE_INFO' => $vote_info,
            'VOTE_RESULTS' => $vote_results,
            'VOTE_LINE_NO' => null,
        ]);
    }
}
