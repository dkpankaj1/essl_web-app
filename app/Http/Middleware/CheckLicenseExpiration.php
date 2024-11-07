<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CheckLicenseExpiration
{
    protected $filePath = 'license.json';
    public function handle(Request $request, Closure $next): Response
    {
        $licenseData = $this->getLicenseData();
        if (!$licenseData) {
            return redirect()->route('license.invalid');
        }
        $expiresAt = $licenseData['expires_at'] ?? null;
        if ($expiresAt && now()->greaterThan($expiresAt)) {
            return redirect()->route('license.invalid');
        }
        return $next($request);

    }
    private function getLicenseData()
    {

        if (!Storage::exists($this->filePath)) {
            return null;
        }

        $licenseContent = Storage::get($this->filePath);
        return json_decode($licenseContent, true);
    }
}
