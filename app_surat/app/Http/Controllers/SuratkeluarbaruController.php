<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BukuindukskExport;
use App\Models\SuratkeluarbaruModel;
use App\Models\KlasifikasiBaruModel;
use App\Models\StatistikModel;
use App\Models\SettingnosuratModel;
use App\Models\EncryptHelper;
use App\Services\PayUService\Exception;
use DataTables;
use Illuminate\Support\Facades\Storage;

// ubah penomoran sesuai dengan tata naskah dinas yang baru
class SuratkeluarbaruController extends Controller
{
    protected $sk_model_baru;
    protected $klasifikasi_model;
    protected $stat_model;
    protected $no_model;
    protected $enc_helper;
    public function __construct(
        SuratkeluarbaruModel $sk_baru,
        KlasifikasiBaruModel $k,
        StatistikModel $stat,
        SettingnosuratModel $no,
        EncryptHelper $enc)
    {
        $this->sk_model_baru = $sk_baru;
        $this->klasifikasi_model = $k;
        $this->stat_model = $stat;
        $this->no_model = $no;
        $this->enc_helper = $enc;
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        // - no_agenda RHS
        // - tabel klasifikasi baru

        $role_id = auth::user()->role;
        if ($role_id==2) {
            //return redirect('/dashboard');
        }

        $level = DB::table('t_jabatan')
            ->join('users', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('t_jabatan.level')
            ->where('users.nip', Auth::user()->nip)
            ->get();

        foreach ($level as $datalevel) {
            $level_user = $datalevel->level;
        }

        $pegawai =  DB::table('users')
            ->join('t_jabatan', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('users.*', 't_jabatan.nama_jabatan', 't_jabatan.bagian')
            ->where('t_jabatan.level', '<', $level_user)
            ->get();

        return view('surat_keluar_baru.index_baru', ([
            'pegawai' => $pegawai,
        ]));
    }

    public function get_data_ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->sk_model_baru->get_data_ajax($request);
            foreach ($data as $row) {
                $row->enc_id = $this->enc_helper->encrypt($row->id);
            }
            $totalRecords = $this->sk_model_baru->get_data_ajax($request, '*');
            $filteredRecords = $this->sk_model_baru->get_data_ajax($request, 'filter');

            return Datatables::of($data)
                ->skipPaging()
                ->setTotalRecords(count($totalRecords))
                ->setFilteredRecords(count($filteredRecords))
                ->addIndexColumn()
                ->addColumn('nomor_surat', function($row) {
                    $no_surat = $row->nomor_surat . '<br/>' . date('d-M-Y', strtotime($row->tanggal_surat));
                    return $no_surat;
                })
                ->addColumn('file', function($row) {
                    $file = '';
                    $gambar = asset('images/nopdf.webp');
                    $file = '<image src="'. $gambar .'" width="50">';
                    if (!empty($row->file)) {
                        $path = asset('dok/keluar/' . $row->file);
                        // asset('dok/keluar').'/'.$item->file
                        $gambar = asset('images/pdf.png');
                        $file = '<a href="'. $path .'" target="_blank"><image src="'. $gambar .'" width="50" ></a>';
                    }

                    return $file;
                })
                ->addColumn('action', function($row) {
                    $button = '';
                    // if ($row->sifat_surat < 3) {
                    if (Auth::user()->role!=5 && Auth::user()->role!=3) {
                        $button = '<div class="btn-group">';
                        $button .= '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>';
                        $button .= '</button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';

                        $url = url('/surat_keluar_baru/'.$row->enc_id.'/lihat');
                        $button .= '<a class="dropdown-item" href="'.$url.'">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search dropdown-icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';
                        $button .= '<span>Lihat</span></a>';

                        $url = url('/surat_keluar_baru/'.$row->enc_id.'/edit');
                        $button .= '<a class="dropdown-item" href="'.$url.'">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 dropdown-icon"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg>';
                        $button .= '<span>Edit</span></a>';

                        // $button .= '<a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalHapus'.$row->id.'">';
                        $button .= '<a class="dropdown-item" href="#" onclick="hapus('.$row->id.')">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash dropdown-icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>';
                        $button .= '<span>Hapus</span></a>';

                        $url = url('/kirim_pta/'.$row->enc_id);
                        $button .= '<a class="dropdown-item" href="'.$url.'">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send dropdown-icon"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>';
                        $button .= '<span>Kirim ke PTA</span></a>';

                        $url = url('/lacak_surat_pta/'.$row->enc_id);
                        $button .= '<a class="dropdown-item" href="'.$url.'">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search dropdown-icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';
                        $button .= '<span>Lacak Surat PTA</span></a>';
                    }
                    return $button;
                })
                ->rawColumns(['nomor_surat','file','action'])
                ->make(true);
        }
    }

    public function create($rhs=NULL)
    {
        $klasifikasi = $this->klasifikasi_model->get_klasifikasi();
        return view('surat_keluar_baru.catat_baru', [
            'klasifikasi' => $klasifikasi,
            'rhs' => $rhs,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'kode'                        => 'Required',
                'tujuan_surat'                => 'Required',
                'sifat_surat'                 => 'Required|not_in:0',
                'jabatan_penandatangan_surat' => 'Required|not_in:0',
                'tgl_surat'                   => 'Required',
                'isi_ringkas'                 => 'Required',
            ],
            [
                'kode.required'         => 'Kode Surat Harus Diisi',
                'tujuan_surat.required' => 'Tujuan Surat Harus Diisi',
                'sifat_surat.required'  => 'Sifat Surat Harus Diisi',
                'sifat_surat.not_in'    => 'Sifat Surat Harus Diisi',
                'jabatan_penandatangan_surat.required' => 'Jabatan TTD Harus Diisi',
                'jabatan_penandatangan_surat.not_in'   => 'Jabatan TTD Harus Diisi',
                'tgl_surat.required'    => 'Tanggal Surat Harus Diisi',
                'isi_ringkas.required'  => 'Isi Ringkas Harus Diisi',
            ]
        );

        try {
            $tahun = session()->get('tahun_anggaran');
            $nama_file = '';
            $tgl_surat = date('Y-m-d', strtotime($request->tgl_surat));
            $sifat_surat = $request->sifat_surat ? $request->sifat_surat : NULL;
            $rhs = $sifat_surat > 2 ? true : false;

            $romawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
            $bulan_romawi = $romawi[(date('n', strtotime($request->tgl_surat))-1)];
            $split_kode = explode("-", $request->kode); // id, kode, nama
            $no_agenda = $this->get_no_agenda_terakhir($tahun, $rhs);
            $pejabat = $request->jabatan_penandatangan_surat;
            $kode_penetapan = $request->kode_penetapan;
            $kode_penetapan_nomor = $kode_penetapan ? $kode_penetapan.'.' : $kode_penetapan;
            $kode_satker = env('KODE_SATKER', '-');

            $backdate = isset($request->nomor_backdate) ? true : false;
            if ($backdate) {
                $alphabet = range('A', 'Z');
                // agenda_count di filter by sifat surat
                $no_urut_count = SuratkeluarbaruModel::where([
                                    ['tahun_anggaran', $tahun],
                                    ['no_urut',$request->nomor_backdate],
                                    ['jabatan_penandatangan_surat', $pejabat],
                                    ($rhs ? ['sifat_surat','>','2'] : ['sifat_surat','<','3']),
                                ])->count();
                // 0001/KPTA.W10-A/PL.1.2.3/I/2024
                $nomor_surat = sprintf("%04d", $request->nomor_backdate).'.'.$alphabet[$no_urut_count-1] . '/'. $pejabat . '.' . $kode_satker . $kode_penetapan_nomor . $split_kode[1] .'/';
                $nomor_surat .= $rhs ? 'RHS/' : '';
                $nomor_surat .= $bulan_romawi.'/'.$tahun;
                $no_surat = $request->nomor_backdate;
            } else {
                if ($rhs) {
                    // $nama_setting = "no_surat_keluar_rhs";
                    $nama_setting = $pejabat."_rhs"; //$split_kode[0]."_rhs";
                } else {
                    // $nama_setting = "no_surat_keluar";
                    $nama_setting = $pejabat; //$split_kode[0];
                }

                $no_surat = $this->get_no_surat_terakhir($pejabat, $tahun);

                // 0001/KPTA.W10-A/PL.1.2.3/I/2024
                $nomor_surat = sprintf("%04d", $no_surat) . '/'. $pejabat .'.'. $kode_satker . $kode_penetapan_nomor . $split_kode[1] .'/';
                $nomor_surat .= $rhs ? 'RHS/' : '';
                $nomor_surat .= $bulan_romawi .'/'.$tahun;
            }

            $id_surat = 0;
            if ($request->hasfile('file')) {
                $file = $request->file('file');
                $nama_file = "DokSuratKeluar" . time() . "_" . $file->getClientOriginalName();
                $tujuan_upload = 'dok/keluar';
                $file->move($tujuan_upload, $nama_file);

                $id_surat = SuratkeluarbaruModel::create([
                    'id_klasifikasi' => $split_kode[0],
                    'kode_penetapan' => $kode_penetapan,
                    'klasifikasi' => $split_kode[1].'-'.$split_kode[2],
                    'no_agenda' => $no_agenda,
                    'no_urut' => $no_surat,
                    'nomor_surat' => $nomor_surat,
                    'tujuan_surat' => $request->tujuan_surat,
                    'sifat_surat' => $sifat_surat,
                    'tanggal_surat' => $tgl_surat,
                    'isi_ringkas' => $request->isi_ringkas,
                    'nama_penerima' => $request->nama_penerima,
                    'jabatan_penerima' => $request->jabatan_penerima,
                    'file' => $nama_file,
                    'tahun_anggaran' => $tahun,
                    'penandatangan_surat' => $request->penandatangan_surat,
                    'jabatan_penandatangan_surat' => $request->jabatan_penandatangan_surat,
                    'user_input' => Auth::user()->nip,
                    'user_update' => NULL,
                    'deleted' => 0,
                    'created_at' => date("Y-m-d h:i:s a"),
                    'updated_at' => NULL,
                ])->id;
            } else {
                $id_surat = SuratkeluarbaruModel::create([
                    'id_klasifikasi' => $split_kode[0],
                    'kode_penetapan' => $kode_penetapan,
                    'klasifikasi' => $split_kode[1].'-'.$split_kode[2],
                    'no_agenda' => $no_agenda,
                    'no_urut' => $no_surat,
                    'nomor_surat' => $nomor_surat,
                    'tujuan_surat' => $request->tujuan_surat,
                    'sifat_surat' => $sifat_surat,
                    'tanggal_surat' => $tgl_surat,
                    'isi_ringkas' => $request->isi_ringkas,
                    'nama_penerima' => $request->nama_penerima,
                    'jabatan_penerima' => $request->jabatan_penerima,
                    'tahun_anggaran' => $tahun,
                    'penandatangan_surat' => $request->penandatangan_surat,
                    'jabatan_penandatangan_surat' => $request->jabatan_penandatangan_surat,
                    'user_input' => Auth::user()->nip,
                    'user_update' => NULL,
                    'deleted' => 0,
                    'created_at' => date("Y-m-d h:i:s a"),
                    'updated_at' => NULL,
                ])->id;
            }

            if (!$backdate) {
                // update nomor surat terakhir
                SettingnosuratModel::where('nama', $nama_setting)->where('tahun',$tahun)->update(['nilai' => $no_surat]);

                // update nomor agenda terakhir
                $nama = $rhs ? 'no_agenda_rhs' : 'no_agenda';
                SettingnosuratModel::where('nama', $nama)->where('tahun',$tahun)->update(['nilai' => $no_agenda]);
            }

            if ($rhs) {
                return redirect('/surat_keluar_rhs_baru')->with('status', 'Surat Keluar Rahasia Berhasil Disimpan');
            } else {
                return redirect('/surat_keluar_baru')->with('status', 'Surat Keluar Berhasil Disimpan');
            }
        } catch (\Exception $e) {
            // report($e);
            return $e->getMessage();
        }
    }

    public function get_no_surat_terakhir($nama_setting, $tahun) {
        $nomor_akhir = SettingnosuratModel::where([['nama', $nama_setting],['tahun', $tahun]])->first();
        if ($nomor_akhir) {
            $no_surat = $nomor_akhir->nilai + 1;
            return $no_surat;
        } else {
            SettingnosuratModel::create([
                'nama'  => $nama_setting,
                'tahun' => $tahun,
                'nilai' => 1
            ]);

            return 1;
        }
    }
    public function get_no_agenda_terakhir($tahun, $rhs) {
        $nama = $rhs ? 'no_agenda_rhs' : 'no_agenda';
        $nomor_akhir = SettingnosuratModel::where([['nama', $nama],['tahun', $tahun]])->first();
        if ($nomor_akhir) {
            $no_agenda = $nomor_akhir->nilai + 1;
            return $no_agenda;
        } else {
            SettingnosuratModel::create([
                'nama'  => $nama,
                'tahun' => $tahun,
                'nilai' => 1
            ]);
            return 1;
        }
    }

    public function surat_rahasia()
    {
        $role_id = auth::user()->role;
        if ($role_id==2 || $role_id==5) {
            return redirect('/dashboard');
        }

        $tahun = session()->get('tahun_anggaran');
        $data = $this->sk_model_baru->get_data_rhs($tahun);
        foreach ($data as $row) {
            $row->enc_id = $this->enc_helper->encrypt($row->id);
        }

        $level = DB::table('t_jabatan')
            ->join('users', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('t_jabatan.level')
            ->where('users.nip', Auth::user()->nip)
            ->get();

        foreach ($level as $datalevel) {
            $level_user = $datalevel->level;
        }

        $pegawai =  DB::table('users')
            ->join('t_jabatan', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('users.*', 't_jabatan.nama_jabatan', 't_jabatan.bagian')
            ->where('t_jabatan.level', '<', $level_user)
            ->get();

        return view('surat_keluar_baru.rahasia_baru', ([
            'data' => $data,
            'pegawai' => $pegawai,
        ]));
    }

    public function show($enc_id)
    {
        $id = $this->enc_helper->decrypt($enc_id);
        $data = SuratkeluarbaruModel::find($id);
        return view('surat_keluar_baru.lihat_baru', ([
            'surat' => $data
        ]));
    }
    public function edit($enc_id)
    {
        $id = $this->enc_helper->decrypt($enc_id);
        $data = SuratkeluarbaruModel::find($id);
        $klasifikasi = $this->klasifikasi_model->get_klasifikasi();
        return view('surat_keluar_baru.edit_baru', ([
            'surat' => $data,
            'klasifikasi' => $klasifikasi
        ]));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'tujuan_surat' => 'Required',
            'sifat_surat' => 'Required',
            'isi_ringkas' => 'Required',
        ]);

        $surat = SuratkeluarbaruModel::find($id);

        // 0002/KPTA.W10-A/ST.OT/XII/2023
        $nosurat_split = explode('/', $surat->nomor_surat);

        $kode_penetapan = $request->kode_penetapan;
        $kode_penetapan_nomor = $kode_penetapan ? $kode_penetapan.'.' : '';

        $split_kode = explode("-", $request->kode); // id, kode, nama

        $sifat_surat = $request->sifat_surat != 'NULL' ? $request->sifat_surat : null;
        // $jabatan_penandatangan_surat = $request->jabatan_penandatangan_surat;
        // $jabatan_surat = explode('.', $nosurat_split[1]);
        // $jabatan_surat = $jabatan_penandatangan_surat . '.' . $jabatan_surat[1];
        $nosurat = $nosurat_split[0] .'/'
                    .$nosurat_split[1].'/'
                    .$kode_penetapan_nomor.$split_kode[1] .'/'
                    .$nosurat_split[3].'/'
                    .$nosurat_split[4];

        $object = ([
            'nomor_surat' => $nosurat,
            'kode_penetapan' => $kode_penetapan,
            'id_klasifikasi' => $split_kode[0],
            'klasifikasi' => $split_kode[1],
            'tujuan_surat' => $request->tujuan_surat,
            'isi_ringkas' => $request->isi_ringkas,
            'nama_penerima' => $request->nama_penerima,
            'jabatan_penerima' => $request->jabatan_penerima,
            'sifat_surat' => $sifat_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'user_update' => Auth::user()->nip,
            'updated_at' => date("Y-m-d h:i:s a"),
        ]);
        // 'tanggal_surat' => $request->tanggal_surat,
        // 'penandatangan_surat' => $request->penandatangan_surat,
        // 'jabatan_penandatangan_surat' => $jabatan_penandatangan_surat,
        // 'user_input' => $surat->user_input,
        // 'deleted' => 0,
        // 'created_at' => $surat->created_at,

        $surat->update($object);

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = "DokSuratKeluar" . time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'dok/keluar';
            $file->move($tujuan_upload, $nama_file);
            $surat->update(['file' => $nama_file]);
        }

        return redirect('/surat_keluar_baru')->with('status', 'Surat keluar berhasil diubah..');
    }

    public function destroy(Request $request)
    {
        try {
            $surat = SuratkeluarbaruModel::find($request->id_surat);
            // dd($surat->sifat_surat);
            $surat->update([
                'deleted' => 1,
                'user_update' => Auth::user()->nip,
                'updated_at' => date("Y-m-d h:i:s a"),
            ]);

            if ($surat->sifat_surat < 3) {
                return redirect('/surat_keluar_baru')->with('status', 'Surat keluar berhasil dihapus');
            } else {
                return redirect('/surat_keluar_rhs_baru')->with('status', 'Surat keluar berhasil dihapus');
            }
        } catch (\Exception $e) {
            return redirect('/surat_keluar_baru')->with('error', 'Surat keluar gagal dihapus'); //'Surat keluar gagal dihapus..'); // $e->getMessage()
        }
    }

    public function nomor_backdate(Request $request)
    {
        $tahun = session()->get('tahun_anggaran');
        $tanggal = date('Y-m-d', strtotime($request->tanggal));
        $data= $this->recursif_backdate($tanggal, $tahun, $request->rhs, $request->pejabat);
        $output = '';
        foreach ($data as $x => $row) {
            $param = $row->no_urut.'|'.date('d-m-Y',strtotime($row->tanggal_surat));
            $output .= '<tr>';
            $output .= '<td>' . ($x+1) . '</td>';
            $output .= '<td>' . $row->no_urut . '</td>';
            $output .= '<td>' . date('d-M-Y', strtotime($row->tanggal_surat)) . '</td>';
            $output .= '<td>' . $row->jumlah . '</td>';
            $output .= '<td><button class="btn btn-primary" onclick="pilihNomor(`'.$param.'`)">Pilih</button></td>';
            $output .= '</tr>';
        }
        echo $output;
    }
    public function recursif_backdate($tanggal, $tahun_anggaran, $rhs, $pejabat)
    {
        if ($rhs=="rhs") {
            $data = DB::select('select z.* from
                    (select a.no_urut, a.tanggal_surat,
                    (select count(id) from t_surat_keluar_baru where no_urut=a.no_urut and tanggal_surat=? and tahun_anggaran=?) jumlah
                    from t_surat_keluar_baru a where tanggal_surat=? and tahun_anggaran=? and jabatan_penandatangan_surat=? and sifat_surat > 2
                    group by a.no_urut, a.tanggal_surat order by a.id desc
                    ) z where z.jumlah < 27', [$tanggal, $tahun_anggaran, $tanggal, $tahun_anggaran, $pejabat]);
        // dd($tanggal, $tahun_anggaran, $rhs, $data);
        } else {
            $data = DB::select('select z.* from
            (
                select a.no_urut, a.tanggal_surat,
                (select count(id) from t_surat_keluar_baru where no_urut=a.no_urut and tanggal_surat=? and tahun_anggaran=?) jumlah
                from t_surat_keluar_baru a where tanggal_surat=? and tahun_anggaran=? and jabatan_penandatangan_surat=? and sifat_surat < 3
                group by a.no_urut, a.tanggal_surat order by a.id desc
            ) z where z.jumlah < 27', [$tanggal, $tahun_anggaran, $tanggal, $tahun_anggaran, $pejabat]);
        }
        if ($data) {
            return $data;
        } else {
            $tgl_baru = date('Y-m-d', strtotime('-1 day', strtotime($tanggal)));
            return $this->recursif_backdate($tgl_baru, $tahun_anggaran, $rhs, $kode);
        }
    }
    public function buku_induk(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $m = $bulan ? $bulan : date('m');
        $y = $tahun ? $tahun : date('Y');
        $ym = $this->stat_model->get_month_year();
        return view('surat_keluar.buku_induk', ([
            'bulan'  => $m,
            'tahun'  => $y,
            'months' => $ym['months'],
            'years'  => $ym['years'],
        ]));
    }
    public function buku_induk_export($bulan, $tahun, $rhs=NULL)
    {
        if (Auth::user()->role==1 && $rhs!=NULL) {
            $name = "buku_induk_surat_keluar_rhs_".$bulan.$tahun.".xlsx";
            return Excel::download(new BukuindukskExport($bulan, $tahun, $rhs), $name);
        } else {
            $name = "buku_induk_surat_keluar_".$bulan.$tahun.".xlsx";
            return Excel::download(new BukuindukskExport($bulan, $tahun, NULL), $name);
        }
    }

    public function kirim_pta($enc_id) {
        try {
            $id = $this->enc_helper->decrypt($enc_id);
            $surat = SuratkeluarbaruModel::find($id);
            
            if (!$surat->file) {
                return redirect('/surat_keluar_baru')->with('error', 'Surat gagal dikirim : File surat harus dilampirkan');
            }

            $api_url = env('API_PTA_URL', '');
            $id_satker = env('ID_SATKER', '-');
            $nama_satker = env('NAMA_SATKER', '-');
            $api_key = env('API_SURAT_PTA', '-');

            $filename = public_path("dok\keluar\\".$surat->file);

            $response = Http::withHeaders([
                'key'       => $api_key,
                'id_satker' => $id_satker
            ])
            ->attach('file', fopen($filename, 'r'))
            ->post($api_url.'api/surat_masuk_satker', [
                'no_surat'       => $surat->nomor_surat,
                'dari'           => $nama_satker,
                'tgl_surat'      => $surat->tanggal_surat,
                'keterangan'     => $surat->keterangan,
                'id_klasifikasi' => $surat->id_klasifikasi,
                'klasifikasi'    => $surat->klasifikasi,
                'sifat_surat'    => $surat->sifat_surat,
                'isi_ringkas'    => $surat->isi_ringkas,
                'tahun_anggaran' => $surat->tahun_anggaran,
            ])
            ->json();

            if ($response['success']) {
                if ($surat->sifat_surat < 3) {
                    return redirect('/surat_keluar_baru')->with('status', 'Surat berhasil dikirim ke PTA');
                } else {
                    return redirect('/surat_keluar_rhs_baru')->with('status', 'Surat berhasil dikirim ke PTA');
                }
            } else {
                if ($surat->sifat_surat < 3) {
                    return redirect('/surat_keluar_baru')->with('error', 'Surat gagal dikirim ke PTA : ' . $response['message']);
                } else {
                    return redirect('/surat_keluar_rhs_baru')->with('error', 'Surat gagal dikirim ke PTA : ' . $response['message']);
                }
            }
        } catch (\Exception $ex) {
            // dd($ex->getMessage());
            return redirect('/surat_keluar_baru')->with('error', 'Surat gagal dikirim ke PTA');
        }    
}

    public function lacak_surat_pta($enc_id) {
        $id = $this->enc_helper->decrypt($enc_id);
        $surat = SuratkeluarbaruModel::find($id);
        $no_surat = $surat->nomor_surat;

        $api_url = env('API_PTA_URL', '');
        $api_key = env('API_SURAT_PTA', '-');
        $id_satker = env('ID_SATKER', '-');

        $response = Http::withHeaders([
            'key'       => $api_key,
            'id_satker' => $id_satker
        ])->get($api_url.'api/lacak_surat?no_surat='.$no_surat)->json();

        $data = $response['data'];
        // dd($data);

        return view('surat_masuk.lacak_pta', ([
            'surat_masuk' => $data['surat_masuk'],
            'disposisi' => $data['disposisi'],
        ]));
    }
}
