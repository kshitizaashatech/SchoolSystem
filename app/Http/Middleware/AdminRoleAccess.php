<?php

namespace App\Http\Middleware;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Closure, Auth, AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminRoleAccess
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
        $roles = Role::pluck('name')->toArray();
        
        $permissions = Permission::all()->pluck('name')->toArray();
        
        if ($request->user()->hasRole($roles)) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');

        ///
        
        $options = array(
            'validate_all' => true,
            'return_type' => 'both'
        );

        list($validate, $allValidations) = $request->user()->ability(
            $roles,
            $permissions,
            $options
        );
        
        var_dump($validate);
        
        var_dump($allValidations);

        if ($validate) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');

    }
}
