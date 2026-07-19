<?php

use App\Http\Controllers\AuthController;
// * Controller
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

// * Route - authentications
Route::controller(AuthController::class)
    ->group(function () {
        Route::get('/', function () {
            return redirect()->route('login');
        });

        Route::get('/login', 'index')->name('login');
        Route::post('/authenticate', 'authenticate');
        Route::get('/logout', 'logout')->middleware('auth.token')->name('logout');
        Route::get('/verify', 'verifyUserSiteAccess')->middleware('auth.token')->name('verify');

        // lupa password
        Route::post('/forgot-password/request-otp', 'requestOTPByEmail');
        Route::post('/forgot-password/reset', 'confirmResetPasswordByOTP');
    });
