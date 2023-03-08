<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $pageConfigs = ['blankPage' => true];
    return view('welcome', ['pageConfigs' => $pageConfigs]);
});
Route::get('/dashboard/otp', [DashboardController::class, 'OTP'])->name('dashboard.otp')->middleware(['auth']);
Route::post('otp/login', [DashboardController::class, 'store'])->name('otp.login')->middleware(['auth']);;
//Route::get('/dashboard', function () {
////    return view('dashboard');
//    Route::get('dashboard', [DashboardController::class, 'dashboard']);
//})->middleware(['auth'])->name('dashboard');
Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware(['auth']);

require __DIR__ . '/vuexy.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/users.php';
