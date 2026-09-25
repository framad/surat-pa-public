<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratkeluarModel;
use App\Models\StatistikModel;
use App\Exports\KlasifikasikeluarExport;
use Maatwebsite\Excel\Facades\Excel;

class StatistikskController extends Controller
{
    protected $sk_model;
    protected $stat_model;
    public function __construct(SuratkeluarModel $sm, StatistikModel $stat)
    {
        $this->sk_model = $sm;
        $this->stat_model = $stat;
    }

    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $m = $bulan ? $bulan : date('m');
        $y = $tahun ? $tahun : date('Y');

        $ym = $this->stat_model->get_month_year();
        $data = $this->sk_model->get_statistik($m, $y);
        $parent = $this->sk_model->get_statistik_parent($m, $y);
        $penetapan = $this->sk_model->get_statistik_penetapan($m, $y);
        $jabatan = $this->sk_model->get_statistik_jabatan($m, $y);
        
        return view('statistik_surat.keluar', ([
            'data'   => $data,
            'parent'   => $parent,
            'bulan'  => $m,
            'tahun'  => $y,
            'months' => $ym['months'],
            'years'  => $ym['years'],
        ]));
    }

    public function tampilkan(Request $request) {
        $m = $request->bulan ? $request->bulan : date('m');
        $y = $request->tahun ? $request->tahun : date('Y');
        $data = $this->sk_model->get_statistik($m, $y);
        $output = '';
        $no = 1;
        foreach ($data as $row) {
            $output .= '<tr>';
            $output .= '<td>' . $no++ . '</td>';
            $output .= '<td>' . $row->kode . '</td>';
            $output .= '<td>' . $row->nama . '</td>';
            $output .= '<td>' . $row->jumlah . '</td>';
            $output .= '</tr>';
        }
        echo $output;
    }

    public function export_template() {
        $m = date('m');
        $y = date('Y');
        $data = $this->sk_model->get_statistik($m, $y);
        return view('statistik_surat.export_sk', (['data' => $data]));
    }

    public function export($bulan, $tahun) 
    {
        return Excel::download(new KlasifikasikeluarExport($bulan, $tahun), 'klasifikasi_surat_keluar.xlsx');
    }
}