<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    // public function index(){
    //     $userData = Member::all()->toJson();

    //     return view('member.index', ['userData' => $userData]);
    //     // return view("member/index");
    // }
    
    public function index()
    {
        $userData = Member::where('ORG_ID', '84')->get();
        // $userData = Member::where('USER_NAME', 'TEST')->get();
        return view('member.index', ['userData' => $userData]);
    }

    // 會接收前端post過來的參數
    public function store(Request $request){
        // 要與<input>參數name的變數名稱對應
        $content = $request -> validate([
            'user_id' => 'required|min:7|max:7',
            'USER_PASSWORD' => 'required'
        ]);

        // 呼叫Member Model寫進資料庫 
        Member::create($content);
        // 跳轉到首頁
        return redirect()->route('root')->with('notice','會員資料已成功新增！');
    }

    // boss建議選項
    public function boss(){        
        $data = DB::table('USERS_TEST')
                    ->select('USER_NAME')
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

    public function create(){
        $data = $this->getUserData();
        
        $boss_auto = $this->boss();
        $team_auto = $this->team();
        $fac_auto = $this->fac();
        return view("member.create", [
                                        'data' => $data, 
                                        'boss_auto' => $boss_auto, 
                                        'team_auto' => $team_auto, 
                                        'fac_auto' => $fac_auto
                                    ]);;
    }

    public function list($USER_ID){
        $data = $this->getUserData($USER_ID);
        return view("member.create", $data);
    }

    public function edit($USER_ID){  
        $data = $this->getUserData($USER_ID);
        $member = member::find($USER_ID);           

        $mail = DB::table('USERS_TEST')
                    ->select('mail', $USER_ID)
                    ->get();

        $data['member'] = $member;
        $data['mail'] = $mail;
        return view("member.edit", $data);
    }

    function getUserData(){
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

    public function destroy($USER_ID){
        // auth()->user()->members->find($USER_ID);
        $member = member::find($USER_ID);

        if (!$member) {
            return redirect()->route('root')->with('error', '找不到會員資料！');
        }
        else{
            $member->delete();
            return redirect()->route('root')->with('notice','會員資料已成功刪除！');
        }
    }
    
    // public function bulkDestroy(Request $request) {
    //     $ids = explode(',', $request->input('ids'));
    
    //     // 刪除所選中的項目 
    //     Member::whereIn('id', $ids)->delete();
    
    //     return redirect()->route('root')->with('notice', '選取項目已成功刪除！');
    // }
}
