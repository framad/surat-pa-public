<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Session\Store;

class SettingController extends Controller
{
    protected $session;
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function set_tahun_anggaran(Request $request) {
        $tahun = $request->tahun;
        $this->session->put('tahun_anggaran', $tahun);
        // echo $tahun;
        return redirect('dashboard');
    }
}
