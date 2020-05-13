<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class MaintenanceMode
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (get_buzzy_config('Siteactive') != 'no' || $this->auth->check() && $this->auth->user()->isAdmin() || $request->is('login')) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            abort(403, trans('index.nopermission'));
        } else {
            abort(503);
        }
    }
}
