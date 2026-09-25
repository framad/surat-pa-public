<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class Setting
{
    protected $session;
    public function __construct(Store $session)
    {
        $this->session = $session;
    }
    
    public function handle(Request $request, Closure $next)
    {
        if (!($this->session->get('tahun_anggaran'))) {
            $this->session->put('tahun_anggaran', date("Y"));
        }
        
        return $next($request);
    }
}
