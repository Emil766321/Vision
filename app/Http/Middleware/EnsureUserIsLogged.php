<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \Illuminate\Contracts\Auth\Guard;
use \Auth;

class EnsureUserIsLogged
{
    protected $auth;
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->auth->check())
        {
            return $next($request);
        }
        return redirect('login');
    }
}
