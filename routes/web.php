<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiometricDataController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Middleware\CheckLicenseExpiration;
use App\Http\Middleware\CheckLicenseStatus;
use App\Models\Setting;
use App\Services\LicenseService;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', CheckLicenseExpiration::class]], function () {
    Route::get('/', function () {
        $setting = Setting::first();
        $license = new LicenseService();
        return view('welcome', [
            'setting' => $setting,
            'license' => $license->getLicenseData()
        ]);
    })->name('home');

    Route::get('/setting', [SettingController::class, 'edit'])->name('setting');
    Route::post('/setting', [SettingController::class, 'update']);

    Route::get('/biometric/attendance-log', [BiometricDataController::class, 'attendanceLogForm'])->name('biometric.attendance-log');
    Route::post('/biometric/attendance-log', [BiometricDataController::class, 'attendanceLogDownload']);


    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee/{employee}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/employee/{employee}/update', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('/employee/{employee}/destroy', [EmployeeController::class, 'destroy'])->name('employee.destroy');


    Route::post('/employee-sync', [EmployeeController::class, 'syncUserData'])->name('employee.sync');
    Route::post('/employee-export', [EmployeeController::class, 'exportEmployee'])->name('employee.export');


    Route::post('/today-report', [ReportController::class, 'generateTodayReport'])->name('report.today');
    Route::get('/report', [ReportController::class, 'create'])->name('report.create');
    Route::post('/report', [ReportController::class, 'generateReport'])->name('report.generate');

    Route::get('/biometric/check-status', [BiometricDataController::class, 'checkBiometricStatus'])->name('biometric.status');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::group(['middleware' => ['guest', CheckLicenseExpiration::class]], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess']);
});

Route::middleware([CheckLicenseStatus::class])->get('/license-invalid', fn() => view('license.invalid'))->name('license.invalid');
