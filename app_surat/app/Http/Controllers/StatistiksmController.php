<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratmasukModel;
use App\Models\StatistikModel;
use App\Exports\KlasifikasimasukExport;
use Maatwebsite\Excel\Facades\Excel;

class StatistiksmController extends Controller
{
    protected $sm_model;
    protected $stat_model;
    public function __construct(SuratmasukModel $sm, StatistikModel $stat)
    {
        $this->sm_model = $sm;
        $this->stat_model = $stat;
    }
    
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $m = $bulan ? $bulan : date('m');
        $y = $tahun ? $tahun : date('Y');

        $ym = $this->stat_model->get_month_year();
        $data = $this->sm_model->get_statistik($m, $y);
        $data_parent = $this->sm_model->get_stat_parent($m, $y);
        
        return view('statistik_surat.masuk', ([
            'bulan'  => $m,
            'tahun'  => $y,
            'months' => $ym['months'],
            'years'  => $ym['years'],
            'parent' => $data_parent,
            'data'   => $data,
        ]));
    }

    public function tampilkan_server_side(Request $request) {
        $columns = array( 
            0 =>'id', 
            1 =>'kode',
            2 => 'nama',
            3 => 'jumlah',
        );
        
        $limit = (int)$request->length;
        $start = (int)$request->start;
        
        $search = $request->search['value'];
        $order = $columns[$request->order['0']['column']];
        $dir = $request->order['0']['dir'];
        $m = $request->bulan ? $request->bulan : date('m');
        $y = $request->tahun ? $request->tahun : date('Y');
        
        // $all = $this->sm_model->get_statistik($m, $y, 0, 0, $search);
        $filtered = $this->sm_model->get_statistik($m, $y, $limit, $start, $search);
        $totalData = $filtered['count']; //count($all);
        // dd($filtered['count']);
        $json_data = array(
            "draw"            => intval($request->draw),
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalData), 
            "data"            => $filtered['data'],
            "search"          => $search,
        );

        echo json_encode($json_data); 
    }

    public function tampilkan(Request $request) {
        $m = $request->bulan ? $request->bulan : date('m');
        $y = $request->tahun ? $request->tahun : date('Y');
        
        $data = $this->sm_model->get_statistik($m, $y);
        echo json_encode($data); 
    }
    
    public function export($bulan, $tahun) 
    {
        return Excel::download(new KlasifikasimasukExport($bulan, $tahun), 'klasifikasi_surat_masuk.xlsx');
    }
}