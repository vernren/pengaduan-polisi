<?php
// app/Http/Middleware/PetugasMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PetugasMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isPetugas()) {
            abort(403, 'Akses ditolak. Hanya petugas yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}