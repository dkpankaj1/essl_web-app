<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CheckLicenseStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Replace with your actual logic to check if the license is expired or invalid
        if ($this->isLicenseValid()) {
            // If the license is valid, prevent access to the invalid/expired routes
            return redirect()->route('home'); // Redirect to a default route, e.g., home
        }

        return $next($request);
    }

    private function isLicenseValid()
    {
        // Implement your license validation logic here
        // For example:
        $licensePath = storage_path('license.json');

        if (!Storage::exists('license.json')) {
            return false; // License file doesn't exist
        }

        $licenseData = json_decode(Storage::get('license.json'), true);

        // Check for expiration date and other conditions (e.g., tampered signature)
        return isset($licenseData['expires_at']) && now()->lte($licenseData['expires_at']);
    }
}
