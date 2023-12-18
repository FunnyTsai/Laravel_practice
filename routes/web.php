<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/welcome', function () {
//     return view('welcome');
// });

// 測試是否能正確取得資料表資料 
// Route::get('/', function () {
//     var_dump( DB::table('USERS_TEST')->first() );
// });


/*
|--------------------------------------------------------------------------
| 1. Route::resource會自動產生基本CRUD的route，
|      在MembersController中就可以使用store()、edit()等方法..
|   
| 2. name('*','member')可以在blade頁面中使用各方法做連結 
|    ex:{{ route('member.create') }}
|   
| 3. except(['destroy'])可以排除特定的方法
|   
| 4. middleware('auth')可以驗證使用者是否有登入
|--------------------------------------------------------------------------
*/
Route::resource('member', MembersController::class)->except([
    'destroy'
])->middleware('auth')->name('*','member');

Route::resource('vote', VoteController::class)->middleware('auth')->name('*','vote');


/*
|--------------------------------------------------------------------------
| 1. 單獨使用get定義的index方法
|      在MembersController中就可以使用store()、edit()等方法..
|--------------------------------------------------------------------------
*/
// Route::get('/', [MembersController::class, 'index'])->name('member');
Route::delete('/member/bulkDestroy', [MembersController::class, 'bulkDestroy'])->name('member.bulkDestroy');


Route::get('/home', function () {
    return view('home');
})->middleware('auth');

// Route::get('/userData', [MembersController::class, 'getUserData'])->name('userData.json');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::get('/sidebar', function () {
//     return view('layouts.sidebar');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';