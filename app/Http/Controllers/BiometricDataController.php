<?php
namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Employee;
use App\Models\Setting;
use App\Services\ZKTecoService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;

class BiometricDataController extends Controller
{
    protected $zk;
    protected $testMode;

    public function __construct()
    {
        $setting = Setting::first();

        if (!$setting || !$setting->machine_ip) {
            Log::error('Machine IP is not configured in settings.');
            abort(500, 'Machine IP is not configured.');
        }

        $this->zk = new ZKTecoService($setting->machine_ip);
        $this->testMode = env('USE_MOCK_ATTENDANCE_LOG', false);  // Check environment variable for mock data usage
    }

    public function attendanceLogForm()
    {
        $setting = Setting::first();

        if (!$setting) {
            return redirect()->back()->withErrors(['error' => 'Settings not found']);
        }

        return view('biometric-data', compact('setting'));
    }

    public function attendanceLogDownload()
    {
        $attendanceLogData = $this->testMode === true ? $this->getAttendanceLogFormFile() : $this->getLiveAttendanceLog();
        if ($attendanceLogData) {
            try {
                foreach ($attendanceLogData as $log) {
                    $employee = Employee::where('userid', $log['id'])->first();
                    if ($employee) {
                        AttendanceLog::firstOrCreate(
                            [
                                "uid" => $log['uid'],
                                "employee_id" => $employee->id
                            ],
                            [
                                "uid" => $log['uid'],
                                "employee_id" => $employee->id,
                                "timestamp" => $log['timestamp'],
                                "type" => $log['type']
                            ]
                        );
                    }
                }
                $notification = ['message' => "Attendance log synchronized successfully.", 'alert-type' => "success"];
            } catch (Exception $e) {
                $notification = ['message' => "Attendance log synchronized Failed.", 'alert-type' => "error"];
            }
        } else {
            $notification = ['message' => "Something went wrong.", 'alert-type' => "error"];
        }

        return back()->with($notification);

    }

    public function checkBiometricStatus()
    {
        try {
            $status = $this->testMode ? "offline (mock)" : ($this->zk->connect() ? "online" : "offline");
            if ($status) {
                Setting::first()->update([
                    'serial_no' => $this->zk->getSerialNumber()
                ]);
            }
            return response()->json(['status' => $status]);
        } catch (Exception $e) {
            Log::error('Error checking biometric status: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Unable to check biometric status.'], 500);
        }
    }

    public function getLiveAttendanceLog()
    {
        if ($this->zk->connect()) {
            return $this->zk->getAttendanceLog();
        }
        return null;
    }
    public function getAttendanceLogFormFile()
    {
        $attLogPath = public_path('data/attendance-log.json');
        $jsonContent = file_get_contents($attLogPath);
        return json_decode($jsonContent, true);
    }

    public function clearAttendanceLog()
    {
        try {
            // if ($this->zk->connect()) {
            //     $this->zk->clearAttendanceLog();
            // }
            $notification = ['message' => "Log clear successfully.", 'alert-type' => 'success'];
        } catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
        }
        return redirect()->back()->with($notification);
    }
}
