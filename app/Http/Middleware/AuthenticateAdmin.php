<?php namespace Admin\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateAdmin {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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

        $user = $this->auth->user();

        if ($user) {
            if ($user->role_id == 1) {
                return $next($request);
            }
            return redirect()->to('/');
        } 
        
        if ($request->ajax()) {
             return response('Unauthorized.', 401);
        }
        
        return redirect()->to('admin');
    }

}
