<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\ZKTecoService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::first();
        return view('setting', ['setting' => $setting]);
    }
    public function update(Request $request)
    {
        $request->validate([
            "company_name" => ['required'],
            "machine_ip" => ['required'],
            "start_time" => ['required'],
            "punch_start_before" => ['required'],
            "end_time" => ['required'],
            "punch_end_after" => ['required'],
        ]);
        
        try {

            $setting = Setting::first();
            $serialNumber = $request->machine_ip;

            $setting->update([
                "company_name" => $request->company_name,
                "machine_ip" => $request->machine_ip,
                "serial_no" => $serialNumber,
                "start_time" => $request->start_time,
                "punch_start_before" => $request->punch_start_before,
                "end_time" => $request->end_time,
                "punch_end_after" => $request->punch_end_after,
            ]);
            $notification = ['message' => "Update Success.", 'alert-type' => "success"];
        } catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => "error"];

        }
        return redirect()->back()->with($notification);
    }
}
