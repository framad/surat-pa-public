<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\KlasifikasiModel;
use App\Models\KlasifikasiBaruModel;

class KlasifikasiController extends Controller
{
    protected $model;
    protected $model2;
    public function __construct(
        KlasifikasiModel $klasifikasi,
        KlasifikasiBaruModel $k2
    ) 
    {
        $this->model = $klasifikasi;
        $this->model2 = $k2;
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $role_id = auth::user()->role;
        if ($role_id==2 || $role_id==3) {
            return redirect('/dashboard');
        }

        $tahun = date('Y');
        if ($tahun > 2023) {
            $data = $this->model2->get_klasifikasi();
        } else {
            $data = $this->model->get_klasifikasi();
        }
        return view('klasifikasi.index', ([
            'data' => $data,
        ]));
    }
    
    public function create()
    {
        return view('klasifikasi.tambah');
    }
    
    public function store(Request $request)
    {
        $this->validate(
            $request, 
            [
                'kode'   => 'Required',
                'nama'   => 'Required',
                'uraian' => 'Required',
            ],
            [
                'kode.required'   => 'Kode Klasifikasi Harus Diisi',
                'nama.required'   => 'Nama Klasifikasi Harus Diisi',
                'uraian.required' => 'Uraian Klasifikasi Harus Diisi',
            ]
        );
        
        try {
            $kode = $request->kode;
            $nama = $request->nama;
            $uraian = $request->uraian;

            $tahun = date('Y');
            if ($tahun > 2023) {
                KlasifikasibaruModel::create([
                    'kode' => $kode,
                    'nama' => $nama,
                    'uraian' => $uraian,
                    'created_at' => date("Y-m-d h:i:s a"),
                    // 'updated_at' => NULL,
                ]);
            } else {
                KlasifikasiModel::create([
                    'kode' => $kode,
                    'nama' => $nama,
                    'uraian' => $uraian,
                    'created_at' => date("Y-m-d h:i:s a"),
                    // 'updated_at' => NULL,
                ]);
            }

            return redirect('/klasifikasi')->with('status', 'Data Klasifikasi Berhasil Disimpan');
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return redirect('/klasifikasi')->with('error', $error);
        }
    }
    
    public function show(Request $request)
    {
        $tahun = date('Y');
        if ($tahun > 2023) {
            $klasifikasi = KlasifikasibaruModel::where('kode', 'LIKE', '%' . $request->kode . '%')->get();
        } else {
            $klasifikasi = KlasifikasiModel::where('kode', 'LIKE', '%' . $request->kode . '%')->get();
        }
        $output = '<ul class="list-group" style="display:block; position:relative">';
        foreach ($klasifikasi as $row) {
            $output .= '
            <li class="list-group-item"><a href="#">' . $row->kode . '-' . $row->nama . '</a></li>
            ';
        }
        $output .= '</ul>';
        echo $output;
    }

    public function edit($id)
    {
        $tahun = date('Y');
        if ($tahun > 2023) {
            $data = KlasifikasibaruModel::find($id);
        } else {
            $data = KlasifikasiModel::find($id);
        }
        return view('klasifikasi.edit', ([
            'klasifikasi' => $data,
        ]));
    }

    public function update(Request $request)
    {
        $this->validate(
            $request, 
            [
                'kode'   => 'Required',
                'nama'   => 'Required',
                'uraian' => 'Required',
            ],
            [
                'kode.required'   => 'Kode Klasifikasi Harus Diisi',
                'nama.required'   => 'Nama Klasifikasi Harus Diisi',
                'uraian.required' => 'Uraian Klasifikasi Harus Diisi',
            ]
        );

        try {
            $tahun = date('Y');
            if ($tahun > 2023) {
                $klasifikasi = KlasifikasibaruModel::find($request->id);
            } else {
                $klasifikasi = KlasifikasiModel::find($request->id);
            }

            $object = ([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'uraian' => $request->uraian,
                'updated_at' => date("Y-m-d h:i:s a"),
            ]);
            $klasifikasi->update($object);

            return redirect('/klasifikasi')->with('status', 'Data klasifikasi berhasil diubah');
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return redirect('/klasifikasi')->with('error', $error);
        }
    }

    public function delete(Request $request)
    {
        $tahun = date('Y');
        if ($tahun > 2023) {
            $klasifikasi = KlasifikasibaruModel::find($request->id_klasifikasi);
        } else {
            $klasifikasi = KlasifikasiModel::find($request->id_klasifikasi);
        }
        $klasifikasi->update([
            'deleted' => 1,
            'updated_at' => date("Y-m-d h:i:s a"),
        ]);
        return redirect('/klasifikasi')->with('status', 'Data klasifikasi berhasil dihapus');
    }
}
