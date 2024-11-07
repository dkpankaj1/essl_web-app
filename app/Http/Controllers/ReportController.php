<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceBasicReportExport;
use App\Exports\AttendanceDetailReportExport;
use App\Exports\AttendanceReportExport;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee;
use App\Models\Setting;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create()
    {
        return view('report');
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => ['required', Rule::in([1, 2])],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $setting = Setting::first();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $shiftStartTime = $setting->start_time;
        $shiftEndTime = $setting->end_time;

        $employees = Employee::with([
            'AttendanceLogs' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('timestamp', [$startDate, $endDate]);
            }
        ])->get();

        $report = [];
        $dates = [];

        $dateRange = new \DatePeriod(
            new \DateTime($startDate),
            new \DateInterval('P1D'),
            (new \DateTime($endDate))->modify('+1 day')
        );

        foreach ($dateRange as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        foreach ($employees as $employee) {
            $employeeReport = ['employee_name' => $employee->name];

            foreach ($dates as $currentDate) {
                $checkIn = $employee->AttendanceLogs->first(function ($log) use ($currentDate, $shiftStartTime) {
                    return $log->type === 0 && date('Y-m-d', strtotime($log->timestamp)) === $currentDate
                        && date('H:i:s', strtotime($log->timestamp)) <= $shiftStartTime;
                });

                $checkOut = $employee->AttendanceLogs->first(function ($log) use ($currentDate, $shiftEndTime) {
                    return $log->type === 1 && date('Y-m-d', strtotime($log->timestamp)) === $currentDate
                        && date('H:i:s', strtotime($log->timestamp)) >= $shiftEndTime;
                });

                $status = $checkIn ? 'P' : 'A';

                $employeeReport[$currentDate] = [
                    'status' => $status,
                    'check_in' => $checkIn ? date('H:i:s', strtotime($checkIn->timestamp)) : '',
                    'check_out' => $checkOut ? date('H:i:s', strtotime($checkOut->timestamp)) : '',
                ];
            }

            $report[] = $employeeReport;
        }

        if ($request->report_type === "2") {
            return Excel::download(new AttendanceDetailReportExport($report, $dates), 'attendance_detail_report.xlsx');
        }

        return Excel::download(new AttendanceBasicReportExport($report, $dates), 'attendance_report.xlsx');

    }
}