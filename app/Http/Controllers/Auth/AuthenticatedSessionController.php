<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/*
-----------處理使用者登入、登出、session管理-----------
*/

class AuthenticatedSessionController extends Controller
{
    /**
     *  顯示登入畫面
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * 處理登入請求
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 進行身分驗證
        $request->authenticate();

        // 驗證成功的話生成session
        $request->session()->regenerate();

        // 重新導向至route HOME
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * 登出後session將會失效
     */
    public function destroy(Request $request): RedirectResponse
    {
        // 登出使用者
        Auth::guard('web')->logout();

        // 使session無效
        // session則是用於在伺服器端存儲和管理特定使用者的狀態和資訊
        $request->session()->invalidate();

        // 重新生成 CSRF
        // CSRF 用於防止跨站請求偽造攻擊
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
