<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Examination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InitializeSessionValues
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (!session()->has('academic_session_id')) {
                $academicSessionId = Examination::where('is_active', 1)->value('id');
                if (!$academicSessionId) {
                    // Log a warning if no active academic session is found
                    Log::warning('No active academic session found.');
                } else {
                    session(['academic_session_id' => $academicSessionId]);
                    Log::info('academic_session_id set to: ' . $academicSessionId);
                }
            }

            if (!session()->has('school_id')) {
                $schoolId = Auth::user()->school_id;
                session(['school_id' => $schoolId]);
                Log::info('school_id set to: ' . $schoolId);
            }
        } else {
                Log::warning('User not authenticated in InitializeSessionValues middleware.');
        }

        return $next($request);
    }
}
