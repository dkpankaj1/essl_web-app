<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CheckLicenseStatus
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->isLicenseValid()) {
            return redirect()->route('home');
        }
        return $next($request);
    }

    private function isLicenseValid()
    {
        $filePath = 'license.json';
        if (!Storage::exists($filePath)) {
            return false;
        }
        $licenseData = json_decode(Storage::get($filePath), true);
        return isset($licenseData['expires_at']) && now()->lte($licenseData['expires_at']);
    }
}
