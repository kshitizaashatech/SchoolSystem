<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Closure, Auth, AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminPermissionAccess
{
    public function __construct(User $user)
    {
        $this->auth = $user;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url_permession_check = $this->urlPermessionCheck($request);
        // dd($url_permession_check);

        // if ($url_permession_check != '' || $url_permession_check == null) {
        if ($url_permession_check != '') {
            if ($request->user()->can($url_permession_check, true)) {
                // dd($request);
                return $next($request);
            }
            // abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }

    public function urlPermessionCheck($request)
    {
        $permession = '';
        $currentRouteName = Route::currentRouteName();
        // dd($request);
        $formattedName = $this->formatRouteName($currentRouteName);
        // dd($formattedName);
        if ($request->isMethod('GET')) {

            if (Str::endsWith($formattedName, 'index')) {
                $permession = str_replace('_index', '', $formattedName);
                $permession = "list_" . $permession;
            } elseif (Str::endsWith($formattedName, 'edit')) {
                $permession = str_replace('_edit', '', $formattedName);
                $permession = "edit_" . $permession;
            } elseif (Str::endsWith($formattedName, 'create')) {
                $permession = str_replace('_create', '', $formattedName);
                $permession = "create_" . $permession;
            } else {
                $permission = null;
            }
        } elseif ($request->isMethod('POST')) {
            if (Str::endsWith($formattedName, 'store')) {
                $permession = str_replace('_store', '', $formattedName);
                $permession = "create_" . $permession;
            }
        } elseif ($request->isMethod('DELETE')) {
            // dd($formattedName);
            $permession = str_replace('_destroy', '', $formattedName);
            $permession = "delete_" . $permession;
        } elseif ($request->isMethod('PUT') || $request->isMethod('PATCH')) {
            $permession = str_replace('_update', '', $formattedName);
            $permession = "edit_" . $permession;
        }


        // dd($permession);
        return $permession;
    }

    function formatRouteName($routeName)
    {
        // Split by dots, remove 'admin' element, and implode again
        $formattedName = implode('_', array_filter(explode('.', $routeName), function ($part) {
            return $part !== 'admin';
        }));

        // Check if the string contains "-"
        if (strpos($formattedName, '-') !== false) {
            // Replace "-" with "_"
            $formattedName = str_replace('-', '_', $formattedName);
        }

        return $formattedName;
    }
}
