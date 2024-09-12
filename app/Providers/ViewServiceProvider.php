<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('path.to.sidebar.view', function ($view) {
            $user = Auth::user();
            if ($user && $user->role == 'school_admin') {
                $schoolName = $user->f_name;
                $words = explode(' ', $schoolName);
                $initials = '';
                foreach ($words as $word) {
                    $initials .= strtoupper(substr($word, 0, 1));
                }
                $view->with('initials', $initials);
            }
        });
    }
}
