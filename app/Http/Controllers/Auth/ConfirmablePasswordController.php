<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\UserTest;

/*
-----------確認使用者密碼-----------
*/

class ConfirmablePasswordController extends Controller
{
    /**
     * 顯示確認密碼畫面
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * 確認使用者的密碼
     */
    public function store(Request $request): RedirectResponse
    {   
        // 驗證使用者的USER_ID和password是否有按照規定格式撰寫
        $request->validate([
            // USER_ID必填、7位數
            'USER_ID' => 'required|string|size:7',
            'password' => 'required|string',
        ]);

        $user = UserTest::where('USER_ID', $request->USER_ID)->first();

        dd($user);

        if (!$user || $user->USER_PASSWORD !== md5($request->password)) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(RouteServiceProvider::HOME);

        // // 驗證使用者的password是否正確
        // if (! Auth::guard('web')->validate([
        //     'USER_ID' => $request->user()->USER_ID,
        //     'password' => $request->password,
        // ])) {
        //     // 若驗證失敗時，會拋出相關密碼錯誤訊息
        //     throw ValidationException::withMessages([
        //         'password' => __('auth.password'),
        //     ]);
        // }

        // // 如果密碼驗證通過，將密碼確認時間存入 session
        // $request->session()->put('auth.password_confirmed_at', time());

        // return redirect()->intended(RouteServiceProvider::HOME);
    }
}
