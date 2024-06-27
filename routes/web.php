<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CreateRoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 认证路由
Auth::routes();

// 自定义的登录和注册路由
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/index', 'IndexController@index');
Route::get('/target_info', 'IndexController@targetInfo');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// 角色创建路由
Route::get('create-role', [CreateRoleController::class, 'showCreateRoleForm'])->name('create_role_form');
Route::post('create-role', [CreateRoleController::class, 'createRole'])->name('create_role');

Route::post('/attack', 'IndexController@attack');
Route::post('/retreat', 'IndexController@retreat');
Route::get('/role_state', 'StateController@roleState');
Route::get('/target_state', 'StateController@targetState');
Route::get('/role_equip', 'BagController@equipBag');
Route::get('/role_item', 'BagController@itemBag');
Route::post('/wear', 'BagController@wear');
Route::post('/take_off', 'BagController@takeOff');
Route::post('/sell', 'BagController@sell');
Route::post('/use_item', 'BagController@useItem');
Route::post('/return_map', 'IndexController@returnMap');
Route::get('/item_info', 'StateController@itemInfo');
Route::post('/take_off_tlb', 'StateController@takeOffTlb');
Route::get('/chat', 'ChatController@index');
