<?php

namespace App\Http\Controllers;
use App\Models\Member;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    // public function index(){
    //     $userData = Member::all()->toJson();

    //     return view('member.index', ['userData' => $userData]);
    //     // return view("member/index");
    // }
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
    public function index()
    {
        $userData = Member::where('ORG_ID', '84')->get();
        return view('member.index', ['userData' => $userData]);
    }

}
