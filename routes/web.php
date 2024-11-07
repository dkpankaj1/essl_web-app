<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiometricDataController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        $setting = Setting::first();
        return view('welcome', [
            'setting' => $setting,
        ]);
    })->name('home');

    Route::get('/setting', [SettingController::class, 'edit'])->name('setting');
    Route::post('/setting', [SettingController::class, 'update']);

    Route::get('/biometric/attendance-log', [BiometricDataController::class, 'attendanceLogForm'])->name('biometric.attendance-log');
    Route::post('/biometric/attendance-log', [BiometricDataController::class, 'attendanceLogDownload']);


    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee/{employee}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/employee/{employee}/update', [EmployeeController::class, 'update'])->name('employee.update');
    Route::post('/employee/sync', [EmployeeController::class, 'syncUserData'])->name('employee.sync');

    Route::get('/report', [ReportController::class, 'create'])->name('report.create');
    Route::post('/report', [ReportController::class, 'generateReport'])->name('report.generate');

    Route::get('/biometric/check-status', [BiometricDataController::class, 'checkBiometricStatus'])->name('biometric.status');

    Route::get('/profile', [AuthController::class, 'changeLoginDetail'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateLoginDetail']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess']);
});