<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class LicenseService
{
    public function getLicenseData()
    {
        $filePath = 'license.json';

        if (!Storage::exists($filePath)) {
            return null;
        }

        $licenseContent = Storage::get($filePath);
        return json_decode($licenseContent, true);
    }
}
