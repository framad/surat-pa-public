<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    protected $session;
    protected $timeout = 1800;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function handle(Request $request, Closure $next)
    {

        $is_logged_in = $request->path() != '/logout';
        
        $this->session->put('time', time());

        if (!session('last_active')) {
            // $this->session->put('last_active', time());
        } elseif (time() - $this->session->get('last_active') > $this->timeout) {

            $this->session->forget('last_active');

            $cookie = cookie('intend', $is_logged_in ? url()->current() : 'dashboard');

            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }

        $is_logged_in ? $this->session->put('last_active', time()) : $this->session->forget('last_active');

        return $next($request);
    }
}
