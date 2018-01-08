<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Auth;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.jobs._menu', function($view) {
            $view->with('count_failed_jobs', DB::table('failed_jobs')->count());
            $view->with('count_jobs', DB::table('jobs')->count());
        });

        view()->composer('layouts.app', function($view) {
            if(Auth::check()){
                $view->with('parent_id', User::where('parent_id', Auth::user()->id)->count());
            } else {
                $view->with('parent_id', null);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
