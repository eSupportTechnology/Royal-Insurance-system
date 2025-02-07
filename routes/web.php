<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorsController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

// Route::get('/', function () {
//     return view('AdminDashboard.home');
// });

// Route::get('/test', function () {
    // return view('test');
// });

// Route::prefix('dashboard')->group(function () {
//     Route::view('index', 'dashboard.index')->name('index');
//     Route::view('dashboard-02', 'dashboard.dashboard-02')->name('dashboard-02');

// });

Route::prefix('authentication')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('login/page', [AuthController::class, 'login'])->name('login.store');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('register/store', [AuthController::class, 'signup'])->name('register.store');

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/indexxx', [MotorsController::class, 'indexxx'])->name('indexxx');
Route::get('/create', [MotorsController::class, 'create'])->name('createmotors');
Route::post('/store', [MotorsController::class, 'store'])->name('storemotors');
Route::get('/edit/{id}', [MotorsController::class, 'edit'])->name('editmotors');
Route::put('/update/{id}', [MotorsController::class, 'update'])->name('updatemotors');
Route::delete('/delete/{id}', [MotorsController::class, 'destroy'])->name('deletemotors');
Route::get('/mail/{id}', [MotorsController::class, 'mail'])->name('mailmotors');
Route::post('/mail/{id}/store', [MotorsController::class, 'storeMail'])->name('storemailmotors');

//insurance health//

Route::get('/health/index', [HealthController::class, 'index'])->name('health.index');
Route::get('/health/create', [HealthController::class, 'create'])->name('health.create');
Route::post('/health/store', [HealthController::class, 'store'])->name('health.store');
Route::get('/health/edit/{id}', [HealthController::class, 'edit'])->name('health.edit');
Route::put('/health/update/{id}', [HealthController::class, 'update'])->name('health.update');
Route::delete('/health/delete/{id}', [HealthController::class, 'destroy'])->name('health.delete');

//insurance company//

Route::get('/company/index', [CompanyController::class, 'index'])->name('company.index');
Route::get('/company/create', [CompanyController::class, 'create'])->name('company.create');
Route::post('/company/store', [CompanyController::class, 'store'])->name('company.store');
Route::get('/company/edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');
Route::put('/company/update/{id}', [CompanyController::class, 'update'])->name('company.update');
Route::delete('/company/delete/{id}', [CompanyController::class, 'destroy'])->name('company.delete');
Route::get('/{company_id}/status', [CompanyController::class, 'status'])->name('company.status');
});
});
// Route::prefix('authentication')->group(function () {

//     Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
//     Route::post('login/page', [AuthController::class, 'login'])->name('login');
//     Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.form');
//     Route::post('register/store', [AuthController::class, 'signup'])->name('register');
//     Route::view('forget-password', 'authentication.forget-password')->name('forget-password');
// });

require __DIR__.'/auth.php';
