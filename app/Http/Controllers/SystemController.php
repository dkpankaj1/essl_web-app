<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SystemController extends Controller
{
    public function index()
    {
        return view('system');
    }
    public function clearEmployeeDB()
    {
        DB::table('attendance_logs')->truncate();
        DB::table('employees')->truncate();
        return response()->json(['message' => 'Employee table cleared successfully.']);
    }

    public function clearAttendanceDB()
    {
        DB::table('attendance_logs')->truncate();
        return response()->json(['message' => 'Attendance table cleared successfully.']);
    }
    public function optimizeClear()
    {
        Artisan::call('optimize:clear');
        return response()->json(['message' => 'Optimize successfully.']);
    }
}
