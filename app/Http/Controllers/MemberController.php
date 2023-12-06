<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // public function index(){
    //     $userData = Member::all()->toJson();

    //     return view('member.index', ['userData' => $userData]);
    //     // return view("member/index");
    // }
    
    public function index()
    {
        $userData = Member::where('ORG_ID', '84')->get();
        return view('member.index', ['userData' => $userData]);
    }

    public function create(){
        return view("member.create");
    }

    // 會接收前端post過來的參數
    public function store(Request $request){
        // 要與<input>參數name的變數名稱對應
        $content = $request -> validate([
            'USER_ID' => 'required|min:7',
            'USER_PASSWORD' => 'required'
        ]);

        // 呼叫Member Model寫進資料庫
        Member::create($content);
        // 跳轉到首頁
        return redirect()->route('root');
    }

    public function edit($USER_ID){
        // auth()->user()->members->find($USER_ID);
        $member = member::find($USER_ID);        
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

        return view("member.edit", 
                    ['member' => $member, 'group' => $group, 'zone' => $zone, 'role' => $role, 'org' => $org]);
    }

}
