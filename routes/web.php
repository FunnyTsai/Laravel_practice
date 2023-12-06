<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MembersController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// // 測試是否能正確取得資料表資料
// Route::get('/', function () {
//     var_dump( DB::table('USERS_TEST')->first() );
// });

// Route::resource會自動產生基本CRUD的route
// 在MembersController中就可以使用store()、edit()等方法..
Route::resource('member', MembersController::class);
// Route::delete('/member/bulk-destroy', [MembersController::class, 'bulkDestroy'])->name('member.bulkDestroy');

Route::get('/userData', [MembersController::class, 'getUserData'])->name('userData.json');


// 單獨使用get定義的index方法
// 指定名字為root後，當未來root指向的位子更改時就會一起更動，方便維護
Route::get('/', [MembersController::class, 'index'])->name('root');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::get('/sidebar', function () {
//     return view('layouts.sidebar');
// });


// Route::get('/test', function () {
//     return view('layouts.member');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';