<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAndSetUserAttributes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Your authentication logic to obtain user attributes
        if (Auth::check()) {
            // $user = Auth::user();

            // $userAttributes = [
            //     'role_id' => $user->role_id,
            //     'school_id' => $user->school_id,
            //     'state_id' => $user->state_id,
            //     'district_id' => $user->district_id,
            //     'municipality_id' => $user->municipality_id,
            //     'ward_id' => $user->ward_id,
            //     'f_name' => $user->f_name,
            //     'm_name' => $user->m_name,
            //     'l_name' => $user->l_name,
            //     'email' => $user->email,
            // ];

            $currentDate = Carbon::now()->toDateString();
            $sessions = AcademicSession::where('from_date', '<=', $currentDate)
                ->where('to_date', '>=', $currentDate)
                ->value('id');
            $sessions_id = $sessions ? $sessions : '';
            // Set the user attributes in the session
            $currentDate = Carbon::now()->toDateString();
            $sessions = AcademicSession::where('from_date', '<=', $currentDate)
                ->where('to_date', '>=', $currentDate)
                ->value('id');
            $sessions_id = $sessions ? $sessions : '';
            // Set the user attributes in the session
            session(['school_id' => Auth::user()->school_id]);
            session(['academic_session_id' => $sessions_id]);
        }

        return $next($request);
    }
}