<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Member;
use App\Models\AVoteResult;
use Illuminate\Support\Facades\DB;

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

    // 會接收前端post過來的參數
    public function store(Request $request){

        $VOTE_DATE = $request->input('VOTE_DATE');
        // $CREATE_BY = $request->input('CREATE_BY');
        $CREATE_BY = '1120904';
        $START_DATE = $request->input('START_DATE');
        $END_DATE = $request->input('END_DATE');
        $USE_GROUP = $request->input('USE_GROUP');
        $TITLE = $request->input('TITLE');
        $TITLE_DESC = $request->input('TITLE_DESC');

        date_default_timezone_set('Asia/Taipei');
        $CREATE_DATE = date('Y/m/d H:i:s');
        
        $VOTE_DATE = str_replace('-', '/', $VOTE_DATE);
        $START_DATE = str_replace('-', '/', $START_DATE);
        $END_DATE = str_replace('-', '/', $END_DATE);

        // $lastId = Vote::max('VOTE_ID') + 1;

        // insert進資料表
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

        return redirect()->route('vote.index')->with('notice', '投票資料已成功新增！');
    }

    // // boss建議選項
    // public function boss(){        
    //     $data = DB::table('USERS_TEST')
    //                 ->select(DB::raw("CONCAT(USER_ID, ' ', USER_NAME) AS BOSS"))
    //                 // ->select('USER_NAME')
    //                 ->where('USER_ROLE', 'E')
    //                 ->get();

    //     return $data;
    // }

    // // team建議選項
    // public function team(){        
    //     $data = DB::table('USERS_TEST')
    //                 ->select('TEAM')
    //                 ->distinct()
    //                 ->get();

    //     return $data;
    // }

    // // 原廠建議選項
    // public function fac(){        
    //     $data = DB::table('FACTORY_TEST')
    //                 ->select(DB::raw("CONCAT(Fac_Code, ' ', Fac_Name) AS Fac"))
    //                 ->distinct()
    //                 ->get();

    //     return $data;
    // }

    // // 差勤員工編號建議選項
    // public function attribute1(){        

    //     // $data = Member::select('USER_ID','USER_NAME')
    //     $data = Member::select(DB::raw("CONCAT(USER_ID, ' ', USER_NAME) AS USER_INFO"))
    //             ->where('ORG_ID', '84')
    //             ->distinct()
    //             ->get();

    //     return $data;
    // }

    // // 群組建議選項
    // public function group(){        
    //     $data = DB::table('PHRASE_TEST')
    //             ->select('PHR_NAME')
    //             ->where('PHR_KIND', '01')
    //             ->where('MODIFY_FLAG', '<>', 'D')
    //             ->get();

    //     return $data;
    // }

    public function create(){
        return view("vote.create");
    }

    public function edit($VOTE_ID){  

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

        return view("vote.edit",[
            'vote' => $vote,
            'CREATE_BY' => $CREATE_BY,
            'USE_GROUP_FINAL' => $USE_GROUP_FINAL,
            'VOTER_FINAL' => $VOTER_FINAL,
            'VOTE_INFO' => $vote_info,
        ]);
    }

    public function update(Request $request, $VOTE_ID){  
        
    //     $user_name = $request->input('user_name');
    //     $user_group = $request->input('user_group');
    //     $user_zone = $request->input('user_zone');
    //     $user_boss = $request->input('user_boss');
    //     $user_role = $request->input('user_role');
    //     $team = $request->input('team');
    //     $attribute1 = $request->input('attribute1');
    //     $user_mail = $request->input('user_mail');
    //     $orig_vendor = $request->input('orig_vendor');
    //     $mail = $request->input('mail');
    //     $salesrep_id = $request->input('salesrep_id');
    //     $collector_id = $request->input('collector_id');
    //     $ord_amt = $request->input('ord_amt');
    //     $ord_dis_amt = $request->input('ord_dis_amt');
    //     $user_schedule = $request->input('user_schedule');
    //     $org_id = $request->input('org_id');
    //     $meal_fee = $request->input('meal_fee');
    //     $trf_fee = $request->input('trf_fee');
    //     $user_password1 = $request->input('user_password1');
    //     $user_password2 = $request->input('user_password2');
    //     $selected_groups = $request->input('selected_groups');

    //     $this->saveGroupData($USER_ID, $selected_groups);

    //     // dd($selected_groups);

    //     date_default_timezone_set('Asia/Taipei');
    //     $last_update_date = date('Y/m/d H:i:s');

    //     if ($user_password1 != $user_password2) {
    //         return redirect()->back()->with('error', '密碼輸入不一致');
    //     }

    //     if ($attribute1 != '') {
    //         $attribute1 = (explode(' ', $attribute1))[0];
    //     } 

    //     if ($orig_vendor != '') {
    //         $orig_vendor = (explode(' ', $orig_vendor))[0];
    //     } 

    //     if ($user_boss != '') {
    //         $user_boss = (explode(' ', $user_boss))[0];
    //     } 

    //     $updateData = [
    //         'user_name' => $user_name,
    //         'user_group' => $user_group,
    //         'user_zone' => $user_zone,
    //         'user_boss' => $user_boss,
    //         'user_role' => $user_role,
    //         'team' => $team,
    //         'attribute1' => $attribute1,
    //         'user_mail' => $user_mail,
    //         'orig_vendor' => $orig_vendor,
    //         'mail' => $mail,
    //         'salesrep_id' => $salesrep_id,
    //         'collector_id' => $collector_id,
    //         'ord_amt' => $ord_amt,
    //         'ord_dis_amt' => $ord_dis_amt,
    //         'user_schedule' => $user_schedule,
    //         'org_id' => $org_id,
    //         'meal_fee' => $meal_fee,
    //         'trf_fee' => $trf_fee,
    //         'LAST_UPDATE_DATE' => $last_update_date
    //     ];

    //     if (!empty($user_password1) && !empty($user_password2)) {
    //         // 如果 $user_password1 和 $user_password2 都不為空，則更新 user_password 欄位
    //         $updateData['user_password'] = md5($user_password1);
    //     }

    //     Member::where('user_id', $USER_ID)->update($updateData);

        return redirect()->back()->with('notice', '會員資料已成功編輯！');     
    }

    // function getUserData(){
    //     // auth()->user()->members->find($USER_ID); 
    //     $group = DB::table('VALUE_SET_LEBBY')
    //                 ->select('VLS_CODE')
    //                 ->where('VLS_KIND', 'GROUP')
    //                 ->whereIn('ENABLE_FLAG', ['Y', 'D'])
    //                 ->orderBy('VLS_CODE')
    //                 ->get();
                    
    //     $zone = DB::table('VALUE_SET_LEBBY')
    //                 ->select('VLS_CODE')
    //                 ->where('VLS_KIND', 'TERRTORY')
    //                 ->where('ENABLE_FLAG', 'Y')
    //                 ->orderBy('VLS_CODE')
    //                 ->get();

    //     $role = DB::table('PHRASE_TEST')
    //                 ->select('PHR_TYPE', DB::raw("CONCAT(PHR_TYPE, ' - ', PHR_NAME) AS PHR_NAME"))
    //                 ->where('PHR_KIND', '02')
    //                 ->whereIn('MODIFY_FLAG', ['A', 'M'])
    //                 ->orderBy('PHR_TYPE')
    //                 ->get();

    //     $org = DB::table('ORGANIZATIONS_TEST')
    //                 ->select('ORG_ID', 'OU_NAME')
    //                 ->distinct()
    //                 ->orderBy('ORG_ID')
    //                 ->get();

    //     $data = [
    //         // 'member' => $member, 
    //         'group' => $group, 
    //         'zone' => $zone, 
    //         'role' => $role, 
    //         'org' => $org
    //     ];

    //     return $data;
    // }
    
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
