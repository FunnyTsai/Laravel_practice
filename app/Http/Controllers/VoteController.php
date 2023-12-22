<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function index()
    {

        $data = Vote::get();

        return view('vote.index', ['voteData' => $data]);
    }
    
    // // 會接收前端post過來的參數
    // public function store(Request $request){

    //     // dd($request->all()); 

    //     // 要與<input>參數name的變數名稱對應
    //     // $content = $request -> validate([
    //     //     'user_id' => 'required|min:7|max:7',
    //     //     'user_password1' => 'required'
    //     // ]);

    //     $user_id = $request->input('user_id');
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

    //     // 防呆：user_id不得與資料庫重複        
    //     $checkCount = Member::where('USER_ID',$user_id)->count();

    //     if ($checkCount > 0) {
    //         return redirect()->back()->withInput()->with('error', '新增失敗！此帳號已存在！');
    //     }


    //     $this->saveGroupData($user_id, $selected_groups);

    //     date_default_timezone_set('Asia/Taipei');
    //     $creation_date = date('Y/m/d H:i:s');

    //     if ($user_password1 != $user_password2) {
    //         return redirect()->back()->with('error', '密碼輸入不一致');
    //     }

    //     if ($attribute1 != '') {
    //         $attribute1 = (explode(' ', $attribute1))[0];
    //     } 

    //     if ($orig_vendor != '') {
    //         $orig_vendor = (explode(' ', $orig_vendor))[0];
    //     } 

    //     // insert進資料表
    //     Member::insert([
    //         'user_id' => $user_id,
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
    //         'user_password' => md5($user_password1),
    //         'creation_date' => $creation_date
    //     ]);

    //     // 新增群組

        
    //     return redirect()->route('member.index')->with('notice', '會員資料已成功新增！');
        
    //     // print_r($content);
    //     // echo '<h1>' . $user_password1  . '</h1>';

    //     // 呼叫Member Model寫進資料庫 
    //     // members()->create($content);
    //     // 跳轉到首頁
    // }

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

    // public function list($USER_ID){
    //     $data = $this->getUserData($USER_ID);
    //     return view("member.create", $data);
    // }

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
            array_push($USE_GROUP, $groupName->DEPT_NAME);
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

            array_push($VOTER, $voterName->EMP_NAME);
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
        $deletedCount = Member::whereIn('USER_ID', $ids)->delete();

        if ($deletedCount > 0) {
            return redirect()->route('vote.index')->with('notice', '選取項目已成功刪除！');
        } 
        else {
            return redirect()->route('vote.index')->with('error', '刪除失敗！');
        }
    }
}
