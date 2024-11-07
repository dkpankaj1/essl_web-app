<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Setting;
use App\Services\ZKTecoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
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
        $this->testMode = env('USE_MOCK_ATTENDANCE_LOG', false);
    }

    public function index()
    {
        $employees = Employee::orderBy('name', 'asc')->paginate(10);
        return view("employee.index", ['employees' => $employees]);

    }

    public function edit(Employee $employee)
    {
        return view("employee.edit", ['employee' => $employee]);
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate(['name' => 'required']);

        try {
            $employee->update(['name' => $request->name]);

            $notification = ['message' => "Employee Update Success.", 'alert-type' => 'success'];
        } catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
        }
        return redirect()->route('employee.index')->with($notification);
    }

    public function syncUserData()
    {
        $userData = $this->testMode === true ? $this->getUserDataFromFile() : $this->getLiveUserData();

        if ($userData) {
            try {
                foreach ($userData as $user) {
                    Employee::firstOrCreate([
                        "uid" => $user['uid'],
                        "userid" => $user['userid']
                    ], [
                        "uid" => $user['uid'],
                        "userid" => $user['userid'],
                        "name" => $user['name'],
                        "role" => $user['role'],
                        "password" => $user['password'],
                        "cardno" => $user['cardno']
                    ]);
                }
                $notification = ['message' => "User Sync Success.", 'alert-type' => "success"];
            } catch (\Exception $e) {
                $notification = ['message' => "User Sync Failed.", 'alert-type' => "error"];
            }
        } else {
            $notification = ['message' => "Something went wrong", 'alert-type' => "error"];

        }
        return back()->with($notification);
    }

    protected function getLiveUserData(): ?array
    {
        if ($this->zk->connect()) {
            return $this->zk->getUsers();
        }
        return null;
    }

    protected function getUserDataFromFile()
    {
        $userListPath = public_path('data/user_data.json');
        $jsonContent = file_get_contents($userListPath);
        return json_decode($jsonContent, true);
    }

    public function exportEmployee()
    {
        return Excel::download(new EmployeeExport, 'employees.xlsx');
    }

    public function destroy(Employee $employee)
    {
        try {
            $employee->AttendanceLogs()->delete();
            $employee->delete();
            $notification = ['message' => 'Employee delete success.', 'alert-type' => 'success'];
        } catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
        }
        return back()->with($notification);
    }
}
