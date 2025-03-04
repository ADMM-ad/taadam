<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNetworkAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedSubnet = '192.168.2';
        $clientIp = $request->ip();

        // Izinkan jika dari localhost
        if ($clientIp === '127.0.0.1' || $clientIp === '::1') {
            return $next($request);
        }

        // Cek apakah IP sesuai subnet yang diizinkan
        if (!str_starts_with($clientIp, $allowedSubnet)) {
            abort(403, 'Akses hanya diperbolehkan dari jaringan Wi-Fi 192.168.2.0.');
        }

        return $next($request);
    }
}
