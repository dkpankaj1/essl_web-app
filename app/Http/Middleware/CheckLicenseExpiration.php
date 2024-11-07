<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CheckLicenseExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
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
        $filePath = 'license.json';

        if (!Storage::exists($filePath)) {
            return null;
        }

        $licenseContent = Storage::get($filePath);
        return json_decode($licenseContent, true);
    }
}
