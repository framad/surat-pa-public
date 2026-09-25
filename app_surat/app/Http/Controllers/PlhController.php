<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlhModel;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class PlhController extends Controller
{
    protected $plh_model;
    public function __construct(PlhModel $plh)
    {
        $this->plh_model = $plh;
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $data = $this->plh_model->get_data();
        return view('plh.index', ([
            'data' => $data,
        ]));
    }
    
    public function create()
    {
        $atasan = $this->plh_model->get_atasan();
        // $pegawai = $this->plh_model->get_pegawai();
        
        return view('plh.create', ([
            'atasan' => $atasan,
            // 'pegawai' => $pegawai,
        ]));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request, 
            [
                'nip'           => 'Required',
                'id_jabatan'    => 'Required',
                'tanggal_awal'  => 'Required',
                'tanggal_akhir' => 'Required',
            ],
            [
                'id_jabatan.required'    => 'Pejabat Harus Diisi',
                'nip.required'           => 'Pelaksana Harus Diisi',
                'tanggal_awal.required'  => 'Tanggal Awal Harus Diisi',
                'tanggal_akhir.required' => 'Tanggal Akhir Harus Diisi'
            ]
        );
        
        try {
            PlhModel::create([
                'nip' => $request->nip,
                'id_jabatan' => $request->id_jabatan,
                'tanggal_awal' => date('Y-m-d', strtotime($request->tanggal_awal)),
                'tanggal_akhir' => date('Y-m-d', strtotime($request->tanggal_akhir)),
                'user_input' => Auth::user()->nip,
                'user_update' => NULL,
                'created_at' => date("Y-m-d h:i:s a"),
                'updated_at' => NULL,
            ]);

            return redirect('/plh')->with('status', 'Data PLH Berhasil Disimpan!');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        try {
            PlhModel::find($request->id_plh)->delete();

            return redirect('/plh')->with('status', 'Data PLH Berhasil Dihapus.');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_pelaksana_plh(Request $request)
    {
        try {
            $bagian = $request->bagian;
            $id_jabatan = $request->id_jabatan;
            $tanggal_awal = date('Y-m-d', strtotime($request->tanggal_awal));
            $data = $this->plh_model->getChildren($id_jabatan, $bagian, []);
            $exclude = $this->plh_model->exclude_jabatan_plh($tanggal_awal);
            // dd($exclude);

            $output = '';
            $no = 1;
            foreach ($data as $row) {
                if (!in_array($row->id_jabatan, $exclude['jabatan'])) {
                    if (!in_array($row->nip, $exclude['nip'])) {
                        $param = $row->nip.'|'.$row->name;
                        $output .= '<tr>';
                        $output .= '<td>' . $no++ . '</td>';
                        $output .= '<td>' . $row->name . '</td>';
                        $output .= '<td>' . $row->nama_jabatan . '</td>';
                        $output .= '<td><button class="btn btn-primary" onclick="pilihPegawai(`'. $param .'`)">Pilih</button></td>';
                        $output .= '</tr>';
                    }
                }
            }
            echo $output;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function get_atasan_plh(Request $request) {
        $tanggal_awal = date('Y-m-d', strtotime($request->tanggal_awal));
        $data = $this->plh_model->get_jabatan_delegasi($tanggal_awal);
        
        $output = '';
        $no = 1;
        foreach ($data as $row) {
            $param = $row->id_jabatan.'|'.$row->name.'|'.$row->bagian;
            $output .= '<tr>';
            $output .= '<td>' . $no++ . '</td>';
            $output .= '<td>' . $row->name . '</td>';
            $output .= '<td>' . $row->nama_jabatan . '</td>';
            $output .= '<td><button class="btn btn-primary" onclick="pilihAtasan(`'. $param .'`)">Pilih</button></td>';
            $output .= '</tr>';
        }
        echo $output;
    }
}