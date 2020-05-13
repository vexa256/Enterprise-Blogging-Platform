<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class DemoAdmin
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
    public function handle($request, Closure $next)
    {
        if (env('APP_DEMO') && Auth::check() && Auth::user()->email == 'demo@admin.com') {
            if ($request->expectsJson()) {
                return response()->jsona(['status' => 'error', 'errors' => 'You do not have permission for this action as demo admin account!'], 401);
            } else {
                \Session::flash('error.message',  'You do not have permission for this action as demo admin account!');
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
