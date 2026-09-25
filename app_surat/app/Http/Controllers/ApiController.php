<?php

namespace App\Http\Controllers;

use App\Models\SuratmasukModel;
use App\Models\ApiModel;
use App\Models\PlhModel;
use App\Models\DisposisiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    protected $plh_model;
    public function __construct(PlhModel $plh)
    {
        $this->plh_model = $plh;
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $data = null; //SuratmasukModel::latest()->paginate(10);
        return [
            "status" => 1,
            "data"   => $data
        ];
    }

    public function store(Request $request)
    {
        $api_prakerin = env('API_EKSTERNAL', '');
        $key = $request->header('key');

        try {
            if ($key == $api_prakerin) {
                $this->validate(
                    $request,
                    [
                        'no_surat'  => 'Required|unique:App\Models\SuratmasukModel,no_surat',
                        'dari'      => 'Required',
                        'tgl_surat' => 'Required',
                        'file'      => 'required|mimes:doc,docx,pdf,jpg,jpeg|max:20480',
                    ],
                    [
                        'no_surat.unique'    => 'Nomor Surat Sudah Ada',
                        'no_surat.required'  => 'Nomor Surat Harus Diisi',
                        'dari.required'      => 'Asal Surat Harus Diisi',
                        'tgl_surat.required' => 'Tanggal Surat Harus Diisi',
                    ]
                );

                $tahun = date("Y");
                $akhir = SuratmasukModel::where('tahun_anggaran', $tahun)->max('no_agenda');
                $id_surat = 0;

                if (is_numeric($akhir)) {
                    $nextnum = $akhir + 1;
                } else {
                    $akhir = 0;
                    $nextnum = 1;
                }

                $nama_file = null;
                if ($file = $request->file('file')) {
                    //
                    $nama_file = "DokSurat_" . time() . "_" . $file->getClientOriginalName();
                    $tujuan_upload = 'dok';
                    $file->move($tujuan_upload, $nama_file);
                    //
                }

                $id_surat = SuratmasukModel::create([
                    'no_agenda' => $nextnum,
                    'id_klasifikasi' => 7, // HM.01.1 Hubungan
                    'klasifikasi' => "HM.01.1-HM.01.1",
                    'sifat_surat' => 1, // surat biasa
                    'isi_ringkas' => "Permohonan Prakerin",
                    'dari' => $request->dari,
                    'no_surat' => $request->no_surat,
                    'tgl_surat' => date('Y-m-d', strtotime($request->tgl_surat)),
                    'tgl_diterima' => date("Y-m-d"),
                    'keterangan' => $request->keterangan,
                    'file' => $nama_file,
                    'tahun_anggaran' => $tahun,
                    'user_id' => "prakerin",
                    'created_at' => date("Y-m-d h:i:s a"),
                    'updated_at' => NULL,
                ])->id;

                // teruskan ke kasubbag TURT
                $id_turt = env('ID_JABATAN_TURT', '0');
                $turt = DB::table('users')->where('id_jabatan', '=', $id_turt)->first();
                $plh = $this->plh_model->get_plh($turt->nip);

                DisposisiModel::create([
                    'id_surat_masuk' => $id_surat,
                    'disposisi_oleh' => "prakerin",
                    'disposisi_kepada' => $turt->nip,
                    'plh' => $plh ? $plh->nip : NULL,
                    'isi_disposisi' => '',
                    'jenis' => 1, // 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
                    'created_at' => date("Y-m-d h:i:s a"),
                    'updated_at' => NULL,
                ]);

                return response()->json([
                    "success" => true,
                    "message" => "File Berhasil Diupload",
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Unauthorized",
                ], 401);
            }
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                "message" => $ex->getMessage(),
            ], 400);
        }
    }

    public function prakerin(Request $request)
    {
        $api_prakerin = env('API_EKSTERNAL', '');
        $key = $request->header('key');

        try {
            if ($key == $api_prakerin) {
                $this->validate(
                    $request,
                    [
                        'no_surat'     => 'Required|unique:App\Models\SuratmasukModel,no_surat',
                        'nama_sekolah' => 'Required',
                        'tgl_surat'    => 'Required',
                        'file'         => 'required|mimes:doc,docx,pdf,jpg,jpeg|max:20480',
                    ],
                    [
                        'no_surat.unique'       => 'Nomor Surat Sudah Ada',
                        'no_surat.required'     => 'Nomor Surat Harus Diisi',
                        'nama_sekolah.required' => 'Asal Surat Harus Diisi',
                        'tgl_surat.required'    => 'Tanggal Surat Harus Diisi',
                    ]
                );

                $tahun = date("Y");
                $akhir = SuratmasukModel::where('tahun_anggaran', $tahun)->max('no_agenda');
                $id_surat = 0;

                if (is_numeric($akhir)) {
                    $nextnum = $akhir + 1;
                } else {
                    $akhir = 0;
                    $nextnum = 1;
                }

                $nama_file = null;
                if ($file = $request->file('file')) {
                    //
                    $nama_file = "DokSurat_" . time() . "_" . $file->getClientOriginalName();
                    $tujuan_upload = 'dok';
                    $file->move($tujuan_upload, $nama_file);
                    //
                }

                $id_surat = SuratmasukModel::create([
                    'no_agenda' => $nextnum,
                    'id_klasifikasi' => 7, // HM.01.1 Hubungan
                    'klasifikasi' => "HM.01.1-HM.01.1",
                    'sifat_surat' => 1, // surat biasa
                    'isi_ringkas' => "Permohonan Prakerin",
                    'dari' => $request->nama_sekolah,
                    'no_surat' => $request->no_surat,
                    'tgl_surat' => date('Y-m-d', strtotime($request->tgl_surat)),
                    'tgl_diterima' => date("Y-m-d"),
                    'keterangan' => $request->keterangan,
                    'file' => $nama_file,
                    'tahun_anggaran' => $tahun,
                    'user_id' => "prakerin",
                    'created_at' => date("Y-m-d h:i:s a"),
                    'updated_at' => NULL,
                ])->id;

                // teruskan ke kasubbag TURT
                $id_turt = env('ID_JABATAN_TURT', '0');
                $turt = DB::table('users')->where('id_jabatan', '=', $id_turt)->first();
                $plh = $this->plh_model->get_plh($turt->nip);

                DisposisiModel::create([
                    'id_surat_masuk' => $id_surat,
                    'disposisi_oleh' => "prakerin",
                    'disposisi_kepada' => $turt->nip,
                    'plh' => $plh ? $plh->nip : NULL,
                    'isi_disposisi' => '',
                    'jenis' => 1, // 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
                    'created_at' => date("Y-m-d h:i:s a"),
                    'updated_at' => NULL,
                ]);

                return response()->json([
                    "success" => true,
                    "message" => "File Berhasil Diupload",
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Unauthorized",
                ], 401);
            }
        } catch (\Exception $ex) {
            return response()->json([
                "success" => false,
                "message" => $ex->getMessage(),
            ], 400);
        }
    }
}
