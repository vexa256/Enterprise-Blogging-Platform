<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class Admin
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
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'errors' => trans('index.nopermission')], 401);
            } else {
                \Session::flash('error.message',  trans('index.nopermission'));
                return redirect('/');
            }
        }

        return $next($request);
    }
}
