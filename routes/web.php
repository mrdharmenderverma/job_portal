<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'jobs'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobController::class, 'detail'])->name('jobDetail');

Route::group(['account'], function () {

    //Guest Routes
    Route::group(['middleware' => 'guest'], function () {
        Route::get('account/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('account/proccess-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('account/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('account/authenticateLogin', [AccountController::class, 'authenticateLogin'])->name('account.authenticateLogin');
    });

    // Authenticated Routes
    Route::group(['middleware' => 'auth'], function () {
        Route::get('account/profile', [AccountController::class, 'profile'])->name('account.profile');

        Route::get('account/post-job', [AccountController::class, 'postJob'])->name('account.postJob');
        Route::post('account/save-post-job', [AccountController::class, 'savePostJob'])->name('account.savePostJob');

        Route::get('account/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');

        Route::put('account/upateProfile', [AccountController::class, 'updateProfile'])->name('account.upateProfile');
        Route::post('account/upate-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');

        Route::get('account/logout', [AccountController::class, 'logout'])->name('account.logout');

        Route::post('/delete-job', [AccountController::class, 'deleteJob'])->name('account.deleteJob');
    });
});
