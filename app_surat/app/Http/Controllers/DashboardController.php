<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Store;
use App\Models\DashboardModel;
use App\Models\SuratmasukModel;
use App\Models\SuratkeluarModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $session;
    protected $model;
    protected $sm_model;
    protected $sk_model;
    public function __construct(
        Store $session, 
        DashboardModel $dashboard, 
        SuratmasukModel $sm,
        SuratkeluarModel $sk)
    {
        $this->session = $session;
        $this->model = $dashboard;
        $this->sm_model = $sm;
        $this->sk_model = $sk;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Auth::user()->role;
        $dashboard = $this->model->get_dashboard_data();        
        // $last_active = $this->session->get('last_active');
        // $time = $this->session->get('time');
        $m = date('m');
        $y = date('Y');

        $statistik_masuk = $this->sm_model->get_stat_parent($m, $y);
        $statistik_masuk_rhs = $this->sm_model->get_stat_parent_rhs($m, $y);

        $statistik_keluar = $this->sk_model->get_statistik_parent($m, $y);
        $statistik_keluar_rhs = $this->sk_model->get_statistik_parent_rhs($m, $y);

        $sm_tahun = $this->sm_model->get_jumlah_surat($y);
        $sm_rhs_tahun = $this->sm_model->get_jumlah_surat_rhs($y);

        $sk_tahun = $this->sk_model->get_jumlah_surat($y);
        $sk_rhs_tahun = $this->sk_model->get_jumlah_surat_rhs($y);

        return view('layout.dashboard', (
            [
                'dashboard'            => $dashboard[0],
                'role'                 => $role,
                'statistik_masuk'      => $statistik_masuk,
                'statistik_masuk_rhs'  => $statistik_masuk_rhs,
                'statistik_keluar'     => $statistik_keluar,
                'statistik_keluar_rhs' => $statistik_keluar_rhs,
                'sm_tahun'             => $sm_tahun,
                'sm_rhs_tahun'         => $sm_rhs_tahun,
                'sk_tahun'             => $sk_tahun,
                'sk_rhs_tahun'         => $sk_rhs_tahun,
            ]
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
