<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MembersController extends Controller
{
    // public function index(){
    //     $userData = Member::all()->toJson();

    //     return view('member.index', ['userData' => $userData]);
    //     // return view("member/index");
    // }
    
    public function index()
    {
        // $userData = Member::where('ORG_ID', '84')->get();

        $data = Member::select('UT1.*', 'UT2.USER_NAME AS BOSS_NAME')
                    ->from('USERS_TEST AS UT1')
                    ->leftjoin('USERS_TEST AS UT2', 'UT1.USER_BOSS', '=', 'UT2.USER_ID')
                    // ->where('UT1.ORG_ID', '<>', '0')
                    // ->where('UT1.USER_ID', 'W34000')
                    ->get();

        return view('member.index', ['userData' => $data]);
    }

    // 會接收前端post過來的參數
    public function store(Request $request){

        // dd($request->all()); 

        // 要與<input>參數name的變數名稱對應
        // $content = $request -> validate([
        //     'user_id' => 'required|min:7|max:7',
        //     'user_password1' => 'required'
        // ]);

        $user_id = $request->input('user_id');
        $user_name = $request->input('user_name');
        $user_group = $request->input('user_group');
        $user_zone = $request->input('user_zone');
        $user_boss = $request->input('user_boss');
        $user_role = $request->input('user_role');
        $team = $request->input('team');
        $attribute1 = $request->input('attribute1');
        $user_mail = $request->input('user_mail');
        $orig_vendor = $request->input('orig_vendor');
        $mail = $request->input('mail');
        $salesrep_id = $request->input('salesrep_id');
        $collector_id = $request->input('collector_id');
        $ord_amt = $request->input('ord_amt');
        $ord_dis_amt = $request->input('ord_dis_amt');
        $user_schedule = $request->input('user_schedule');
        $org_id = $request->input('org_id');
        $meal_fee = $request->input('meal_fee');
        $trf_fee = $request->input('trf_fee');
        $user_password1 = $request->input('user_password1');
        $user_password2 = $request->input('user_password2');
        $selected_groups = $request->input('selected_groups');

        // 防呆：user_id不得與資料庫重複        
        $checkCount = Member::where('USER_ID',$user_id)->count();

        if ($checkCount > 0) {
            return redirect()->back()->withInput()->with('error', '新增失敗！此帳號已存在！');
        }


        $this->saveGroupData($user_id, $selected_groups);

        date_default_timezone_set('Asia/Taipei');
        $creation_date = date('Y/m/d H:i:s');

        if ($user_password1 != $user_password2) {
            return redirect()->back()->with('error', '密碼輸入不一致');
        }

        if ($attribute1 != '') {
            $attribute1 = (explode(' ', $attribute1))[0];
        } 

        if ($orig_vendor != '') {
            $orig_vendor = (explode(' ', $orig_vendor))[0];
        } 

        // insert進資料表
        Member::insert([
            'user_id' => $user_id,
            'user_name' => $user_name,
            'user_group' => $user_group,
            'user_zone' => $user_zone,
            'user_boss' => $user_boss,
            'user_role' => $user_role,
            'team' => $team,
            'attribute1' => $attribute1,
            'user_mail' => $user_mail,
            'orig_vendor' => $orig_vendor,
            'mail' => $mail,
            'salesrep_id' => $salesrep_id,
            'collector_id' => $collector_id,
            'ord_amt' => $ord_amt,
            'ord_dis_amt' => $ord_dis_amt,
            'user_schedule' => $user_schedule,
            'org_id' => $org_id,
            'meal_fee' => $meal_fee,
            'trf_fee' => $trf_fee,
            'user_password' => md5($user_password1),
            'creation_date' => $creation_date
        ]);

        // 新增群組

        
        return redirect()->route('member.index')->with('notice', '會員資料已成功新增！');
        
        // print_r($content);
        // echo '<h1>' . $user_password1  . '</h1>';

        // 呼叫Member Model寫進資料庫 
        // members()->create($content);
        // 跳轉到首頁
    }

    // boss建議選項
    public function boss(){        
        $data = DB::table('USERS_TEST')
                    ->select(DB::raw("CONCAT(USER_ID, ' ', USER_NAME) AS BOSS"))
                    // ->select('USER_NAME')
                    ->where('USER_ROLE', 'E')
                    ->get();

        return $data;
    }

    // team建議選項
    public function team(){        
        $data = DB::table('USERS_TEST')
                    ->select('TEAM')
                    ->distinct()
                    ->get();

        return $data;
    }

    // 原廠建議選項
    public function fac(){        
        $data = DB::table('FACTORY_TEST')
                    ->select(DB::raw("CONCAT(Fac_Code, ' ', Fac_Name) AS Fac"))
                    ->distinct()
                    ->get();

        return $data;
    }

    // 差勤員工編號建議選項
    public function attribute1(){        

        // $data = Member::select('USER_ID','USER_NAME')
        $data = Member::select(DB::raw("CONCAT(USER_ID, ' ', USER_NAME) AS USER_INFO"))
                ->where('ORG_ID', '84')
                ->distinct()
                ->get();

        return $data;
    }

    // 群組建議選項
    public function group(){        
        $data = DB::table('PHRASE_TEST')
                ->select('PHR_NAME')
                ->where('PHR_KIND', '01')
                ->where('MODIFY_FLAG', '<>', 'D')
                ->get();

        return $data;
    }

    public function create(){
        $data = $this->getData();
        
        $boss_auto = $this->boss();
        $team_auto = $this->team();
        $fac_auto = $this->fac();
        $attribute1_auto = $this->attribute1();        
        $group_auto = $this->group();

        return view("member.create", [
                        'data' => $data, 
                        'boss_auto' => $boss_auto, 
                        'team_auto' => $team_auto, 
                        'fac_auto' => $fac_auto, 
                        'attribute1_auto' => $attribute1_auto, 
                        'group_auto' => $group_auto
                    ]);
    }

    public function list($USER_ID){
        $data = $this->getData($USER_ID);
        return view("member.create", $data);
    }

    public function edit($USER_ID){  
        $data = $this->getData($USER_ID);
        $member = member::find($USER_ID);     

        if ($member->COLLECTOR_ID) {            
            $collector_name = DB::table('A_AR_COLLECTOR_TEST')
                                ->select('NAME')
                                ->where('COLLECTOR_ID', $member->COLLECTOR_ID)
                                ->first(); 

            $data['collector_name'] = $collector_name;
        } 

        if ($member->ATTRIBUTE1) {            
            $attribute1_name = member::select('USER_NAME')
                                ->where('USER_ID', $member->ATTRIBUTE1)
                                ->first(); 

            $data['attribute1_name'] = $attribute1_name;
        }

        if ($member->USER_BOSS) {            
            $boss_name = member::select('USER_NAME')
                                ->where('USER_ID', $member->USER_BOSS)
                                ->first(); 

            $data['boss_name'] = $boss_name;
        }

        // 群組資料           
        $group = DB::table('groups_TEST as g')
                    ->leftjoin('phrase_TEST as p', function ($join) {
                        $join->on('g.grp_code', '=', 'p.phr_type')
                            ->where('p.PHR_KIND', '01')
                            ->where('p.MODIFY_FLAG', '<>', 'D');
                    })
                    ->select('PHR_NAME')
                    ->where('g.grp_users', $member->USER_ID)
                    ->get();

        $data['group_info'] = $group;             
        $data['member'] = $member;
        
        $boss_auto = $this->boss();
        $team_auto = $this->team();
        $fac_auto = $this->fac();
        $attribute1_auto = $this->attribute1();
        $group_auto = $this->group();

        return view("member.edit", [
                        'data' => $data, 
                        'member' => $member, 
                        'boss_auto' => $boss_auto, 
                        'team_auto' => $team_auto, 
                        'fac_auto' => $fac_auto, 
                        'attribute1_auto' => $attribute1_auto, 
                        'group_auto' => $group_auto
                    ]);
    }

    public function update(Request $request, $USER_ID){  
        
        $user_name = $request->input('user_name');
        $user_group = $request->input('user_group');
        $user_zone = $request->input('user_zone');
        $user_boss = $request->input('user_boss');
        $user_role = $request->input('user_role');
        $team = $request->input('team');
        $attribute1 = $request->input('attribute1');
        $user_mail = $request->input('user_mail');
        $orig_vendor = $request->input('orig_vendor');
        $mail = $request->input('mail');
        $salesrep_id = $request->input('salesrep_id');
        $collector_id = $request->input('collector_id');
        $ord_amt = $request->input('ord_amt');
        $ord_dis_amt = $request->input('ord_dis_amt');
        $user_schedule = $request->input('user_schedule');
        $org_id = $request->input('org_id');
        $meal_fee = $request->input('meal_fee');
        $trf_fee = $request->input('trf_fee');
        $user_password1 = $request->input('user_password1');
        $user_password2 = $request->input('user_password2');
        $selected_groups = $request->input('selected_groups');

        $this->saveGroupData($USER_ID, $selected_groups);

        // dd($selected_groups);

        date_default_timezone_set('Asia/Taipei');
        $last_update_date = date('Y/m/d H:i:s');

        if ($user_password1 != $user_password2) {
            return redirect()->back()->with('error', '密碼輸入不一致');
        }

        if ($attribute1 != '') {
            $attribute1 = (explode(' ', $attribute1))[0];
        } 

        if ($orig_vendor != '') {
            $orig_vendor = (explode(' ', $orig_vendor))[0];
        } 

        if ($user_boss != '') {
            $user_boss = (explode(' ', $user_boss))[0];
        } 

        $updateData = [
            'user_name' => $user_name,
            'user_group' => $user_group,
            'user_zone' => $user_zone,
            'user_boss' => $user_boss,
            'user_role' => $user_role,
            'team' => $team,
            'attribute1' => $attribute1,
            'user_mail' => $user_mail,
            'orig_vendor' => $orig_vendor,
            'mail' => $mail,
            'salesrep_id' => $salesrep_id,
            'collector_id' => $collector_id,
            'ord_amt' => $ord_amt,
            'ord_dis_amt' => $ord_dis_amt,
            'user_schedule' => $user_schedule,
            'org_id' => $org_id,
            'meal_fee' => $meal_fee,
            'trf_fee' => $trf_fee,
            'LAST_UPDATE_DATE' => $last_update_date
        ];

        if (!empty($user_password1) && !empty($user_password2)) {
            // 如果 $user_password1 和 $user_password2 都不為空，則更新 user_password 欄位
            $updateData['user_password'] = md5($user_password1);
        }

        Member::where('user_id', $USER_ID)->update($updateData);

        return redirect()->back()->with('notice', '會員資料已成功編輯！');     
    }

    function getData(){
        // auth()->user()->members->find($USER_ID); 
        $group = DB::table('VALUE_SET_LEBBY')
                    ->select('VLS_CODE')
                    ->where('VLS_KIND', 'GROUP')
                    ->whereIn('ENABLE_FLAG', ['Y', 'D'])
                    ->orderBy('VLS_CODE')
                    ->get();
                    
        $zone = DB::table('VALUE_SET_LEBBY')
                    ->select('VLS_CODE')
                    ->where('VLS_KIND', 'TERRTORY')
                    ->where('ENABLE_FLAG', 'Y')
                    ->orderBy('VLS_CODE')
                    ->get();

        $role = DB::table('PHRASE_TEST')
                    ->select('PHR_TYPE', DB::raw("CONCAT(PHR_TYPE, ' - ', PHR_NAME) AS PHR_NAME"))
                    ->where('PHR_KIND', '02')
                    ->whereIn('MODIFY_FLAG', ['A', 'M'])
                    ->orderBy('PHR_TYPE')
                    ->get();

        $org = DB::table('ORGANIZATIONS_TEST')
                    ->select('ORG_ID', 'OU_NAME')
                    ->distinct()
                    ->orderBy('ORG_ID')
                    ->get();

        $data = [
            // 'member' => $member, 
            'group' => $group, 
            'zone' => $zone, 
            'role' => $role, 
            'org' => $org
        ];

        return $data;
    }
    
    public function bulkDestroy(Request $request) {
        $ids = explode(',', $request->input('deleteIds'));

        // 刪除所選中的項目 
        $deletedCount = Member::whereIn('USER_ID', $ids)->delete();

        if ($deletedCount > 0) {
            return redirect()->route('member.index')->with('notice', '選取項目已成功刪除！');
        } 
        else {
            return redirect()->route('member.index')->with('error', '刪除失敗！');
        }
    }

    public function saveGroupData($user_id, $selected_groups)
    {
        if (Auth::check()) {
    
            // 先刪除使用者目前有的所有群組
            DB::table('groups_TEST')->where('GRP_USERS', $user_id)->delete();
    
            if (!empty($selected_groups)) {
                foreach ($selected_groups as $content) {
    
                    // 取得群組存入資料庫的代號
                    $PHR_TYPE = DB::table('phrase_TEST')
                                    ->where('PHR_NAME', $content)
                                    ->value('PHR_TYPE');
    
                    DB::table('groups_TEST')
                        ->insert([
                            'GRP_USERS' => $user_id,
                            'GRP_CODE' => $PHR_TYPE,
                        ]);
                }
            }
        } 
        else {
            dd($user_id);
        }
    }
}
