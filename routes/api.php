<?php


use App\Http\Controllers\Api\Visitors\DriveInController;
use App\Http\Controllers\Api\Visitors\SmsCheckInController;
use App\Http\Controllers\Api\Visitors\WalkInController;
use App\Http\Controllers\Api\AuthenticationController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Visitors\VisitorController;
use Illuminate\Support\Facades\Route;



//visitor walkin,drivein apis



    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
Route::group(['namespace' => 'Api'], function () {
    Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('visitors')->group(function () {
        Route::get('my_all', [VisitorController::class,'index']);
        Route::get('visitor/{id}', [DriveInController::class,'show']);
        Route::get('organization-options', [VisitorController::class, 'organizationOptions']);
        Route::get('identification-options', [VisitorController::class, 'identificationOptions']);
        Route::get('premises-options', [VisitorController::class,'premisesOptions']);
        Route::get('purpose-options', [VisitorController::class,'purposeOptions']);
        Route::get('host-options', [VisitorController::class,'hostOptions']);
        Route::get('tag-options', [VisitorController::class,'tagOptions']);

        Route::get('drivein/all', [DriveInController::class,'index']);
        Route::post('drivein/create', [DriveInController::class,'store']);

        Route::get('smsCheckin/all', [SmsCheckInController::class,'index']);
        Route::post('smsCheckin/create', [SmsCheckInController::class,'store']);

        Route::get('walkin/all', [WalkInController::class,'index']);
        Route::post('walkin/create', [WalkInController::class,'store']);

        Route::post('verify_checkout', [VisitorController::class,'verifyUser']);
        Route::put('checkout', [VisitorController::class, 'checkout'])->name('api.visitors.checkout');


    });
});
});
Route::post('/login', [AuthenticationController::class, 'Login']);

