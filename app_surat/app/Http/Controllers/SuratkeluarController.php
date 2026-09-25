<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BukuindukskExport;
use App\Models\SuratkeluarModel;
use App\Models\KlasifikasiModel;
use App\Models\StatistikModel;
use App\Models\SettingnosuratModel;
use App\Models\EncryptHelper;
use App\Services\PayUService\Exception;
use DataTables;

class SuratkeluarController extends Controller
{    
    protected $sk_model;
    protected $klasifikasi_model;
    protected $stat_model;
    protected $no_model;
    protected $enc_helper;
    public function __construct(
        SuratkeluarModel $sk, 
        KlasifikasiModel $k, 
        StatistikModel $stat,
        SettingnosuratModel $no,
        EncryptHelper $enc)
    {
        $this->sk_model = $sk;
        $this->klasifikasi_model = $k;
        $this->stat_model = $stat;
        $this->no_model = $no;
        $this->enc_helper = $enc;
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $role_id = auth::user()->role;
        if ($role_id==2) {
            return redirect('/dashboard');
        }
        
        // $tahun = session()->get('tahun_anggaran');
        // $data = $this->sk_model->get_data($tahun);
        // foreach ($data as $row) {
        //     $row->enc_id = $this->enc_helper->encrypt($row->id);
        // }

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
        
        return view('surat_keluar.index', ([
            //'data' => $data,
            'pegawai' => $pegawai,
        ]));
    }

    public function get_data_ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->sk_model->get_data_ajax($request);
            foreach ($data as $row) {
                $row->enc_id = $this->enc_helper->encrypt($row->id);
            }
            $totalRecords = $this->sk_model->get_data_ajax($request, '*');
            $filteredRecords = $this->sk_model->get_data_ajax($request, 'filter');
            
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
                    $tahun_anggaran = session()->get('tahun_anggaran');
                    $tahun = date('Y');
                    $editable = $tahun_anggaran == $tahun ? TRUE : FALSE;
                    // if ($row->sifat_surat < 3) {
                    if (Auth::user()->role!=5 && Auth::user()->role!=3) {
                        $button = '<div class="btn-group">';
                        $button .= '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>';
                        $button .= '</button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
                        
                        $url = url('/surat_keluar/'.$row->enc_id.'/lihat');
                        $button .= '<a class="dropdown-item" href="'.$url.'">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search dropdown-icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';
                        $button .= '<span>Lihat</span></a>';
                        
                        if ($editable) {
                            $url = url('/surat_keluar/'.$row->enc_id.'/edit');
                            $button .= '<a class="dropdown-item" href="'.$url.'">';
                            $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 dropdown-icon"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg>';
                            $button .= '<span>Edit</span></a>';

                            // $button .= '<a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalHapus'.$row->id.'">';
                            $button .= '<a class="dropdown-item" href="#" onclick="hapus('.$row->id.')">';
                            $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash dropdown-icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>';
                            $button .= '<span>Hapus</span></a>';
                        }
                    }
                    return $button;
                })
                ->rawColumns(['nomor_surat','file','action'])
                ->make(true);
        }
    }

    public function surat_rahasia()
    {
        $role_id = auth::user()->role;
        if ($role_id==2 || $role_id==5) {
            return redirect('/dashboard');
        }
        
        $tahun = session()->get('tahun_anggaran');
        $data = $this->sk_model->get_data_rhs($tahun);
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
        
        return view('surat_keluar.rahasia', ([
            'data' => $data,
            'pegawai' => $pegawai,
        ]));
    }
    public function create($rhs=NULL)
    {
        // ini buat tahun 2024
        // return redirect('/surat_keluar');
        // end

        $klasifikasi = $this->klasifikasi_model->get_klasifikasi();
        return view('surat_keluar.catat', [
            'klasifikasi' => $klasifikasi,
            'rhs' => $rhs,
        ]);
    }
    public function store(Request $request)
    {
        $this->validate(
            $request, 
            [
                'kode' => 'Required',
                'tujuan_surat' => 'Required',
                'sifat_surat' => 'Required',
                'tgl_surat' => 'Required',
                'isi_ringkas' => 'Required',
            ],
            [
                'kode.required' => 'Kode Surat Harus Diisi',
                'tujuan_surat.required' => 'Tujuan Surat Harus Diisi',
                'sifat_surat.required' => 'Sifat Surat Harus Diisi',
                'tgl_surat.required' => 'Tanggal Surat Harus Diisi',
                'isi_ringkas.required' => 'Isi Ringkas Harus Diisi',
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
            $split_kode = explode("-", $request->kode);
            
            $backdate = isset($request->nomor_backdate) ? true : false;
            if ($backdate) {
                $alphabet = range('A', 'Z');
                // agenda_count di filter by sifat surat
                $agenda_count = SuratkeluarModel::where([
                                    ['tahun_anggaran', $tahun],
                                    ['no_agenda',$request->nomor_backdate],
                                    ($rhs ? ['sifat_surat','>','2'] : ['sifat_surat','<','3']),
                                ])->count();
                $nomor_surat = 'W10-A/'.sprintf("%04d", $request->nomor_backdate).'.'.$alphabet[$agenda_count-1].'/'. $split_kode[1] .'/';
                $nomor_surat .= $rhs ? 'RHS/' : '';
                $nomor_surat .= $bulan_romawi.'/'.$tahun;
                $no_agenda = $request->nomor_backdate;
            } else {
                if ($rhs) {
                    $nama_setting = "no_surat_keluar_rhs";
                } else {
                    $nama_setting = "no_surat_keluar";
                }
                $nomor_akhir = SettingnosuratModel::where([['nama', $nama_setting],['tahun', $tahun]])->first();
                if (is_numeric($nomor_akhir->nilai)) {
                    $no_agenda = $nomor_akhir->nilai + 1;
                } else {
                    $no_agenda = 1;
                }
                $nomor_surat = 'W10-A/'.sprintf("%04d", $no_agenda).'/'. $split_kode[1] .'/';
                $nomor_surat .= $rhs ? 'RHS/' : '';
                $nomor_surat .= $bulan_romawi .'/'.$tahun;
            }

            $id_surat = 0;
            if ($request->hasfile('file')) {
                $file = $request->file('file');
                $nama_file = "DokSuratKeluar" . time() . "_" . $file->getClientOriginalName();
                $tujuan_upload = 'dok/keluar';
                $file->move($tujuan_upload, $nama_file);

                $id_surat = SuratkeluarModel::create([
                    'id_klasifikasi' => $split_kode[0],
                    'klasifikasi' => $split_kode[1].'-'.$split_kode[2],
                    'no_agenda' => $no_agenda,
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
                $id_surat = SuratkeluarModel::create([
                    'id_klasifikasi' => $split_kode[0],
                    'klasifikasi' => $split_kode[1].'-'.$split_kode[2],
                    'no_agenda' => $no_agenda,
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
                // update nomor agenda
                SettingnosuratModel::where('nama', $nama_setting)->where('tahun',$tahun)->update(['nilai' => $no_agenda]);
            }

            if ($rhs) {
                return redirect('/surat_keluar_rhs')->with('status', 'Surat Keluar Rahasia Berhasil Disimpan');
            } else {
                return redirect('/surat_keluar')->with('status', 'Surat Keluar Berhasil Disimpan');
            }
        } catch (\Exception $e) {
            // report($e);
            return $e->getMessage();
        }
    }
    public function show($enc_id)
    {
        $id = $this->enc_helper->decrypt($enc_id);
        $data = SuratkeluarModel::find($id);
        return view('surat_keluar.lihat', ([
            'surat' => $data
        ]));
    }
    public function edit($enc_id)
    {
        $id = $this->enc_helper->decrypt($enc_id);
        $data = SuratkeluarModel::find($id);
        $klasifikasi = $this->klasifikasi_model->get_klasifikasi();
        return view('surat_keluar.edit', ([
            'surat' => $data,
            'klasifikasi' => $klasifikasi
        ]));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'Required',
            'tujuan_surat' => 'Required',
            'sifat_surat' => 'Required',
            'isi_ringkas' => 'Required',
            'tanggal_surat' => 'Required',
        ]);

        $surat = SuratkeluarModel::find($id);
        $nosurat_split = explode('/', $surat->nomor_surat);
        $sifat_surat = $request->sifat_surat!='NULL' ? $request->sifat_surat : null;
        $split_kode = explode("-", $request->kode);
        $nosurat = $nosurat_split[0].'/'.$nosurat_split[1].'/'. $split_kode[1] .'/'.$nosurat_split[3].'/'.$nosurat_split[4];

        $object = ([
            'id_klasifikasi' => $split_kode[0],
            'klasifikasi' => $split_kode[1].'-'.$split_kode[2],
            'nomor_surat' => $nosurat,
            'tujuan_surat' => $request->tujuan_surat,
            'sifat_surat' => $sifat_surat,
            'isi_ringkas' => $request->isi_ringkas,
            'nama_penerima' => $request->nama_penerima,
            'jabatan_penerima' => $request->jabatan_penerima,
            'penandatangan_surat' => $request->penandatangan_surat,
            'jabatan_penandatangan_surat' => $request->jabatan_penandatangan_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'user_update' => Auth::user()->nip,
            'updated_at' => date("Y-m-d h:i:s a"),
            // 'user_input' => $surat->user_input,
            // 'deleted' => 0,
            // 'created_at' => $surat->created_at,
        ]);

        $surat->update($object);

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = "DokSuratKeluar" . time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'dok/keluar';
            $file->move($tujuan_upload, $nama_file);
            $surat->update(['file' => $nama_file]);
        }

        return redirect('/surat_keluar')->with('status', 'Surat keluar berhasil diubah..');
    }

    // public function destroy($enc_id)
    // {
    //     $id = $this->enc_helper->decrypt($enc_id);
    //     $surat = SuratkeluarModel::find($id);
    //     $surat->update([
    //         'deleted' => 1,
    //         'user_update' => Auth::user()->nip,
    //         'updated_at' => date("Y-m-d h:i:s a"),
    //     ]);
    //     return redirect('/surat_keluar')->with('status', 'Surat keluar berhasil dihapus..');
    // }
    public function destroy(Request $request)
    {
        try {
            // $id = $this->enc_helper->decrypt($request->enc_id);
            $surat = SuratkeluarModel::find($request->id_surat);
            // dd($request->id_surat);
            $surat->update([
                'deleted' => 1,
                'user_update' => Auth::user()->nip,
                'updated_at' => date("Y-m-d h:i:s a"),
            ]);

            return redirect('/surat_keluar')->with('status', 'Surat keluar berhasil dihapus..');
        } catch (\Exception $e) {
            return redirect('/surat_keluar')->with('error', $e->getMessage()); //'Surat keluar gagal dihapus..');
        }
    }

    public function nomor_backdate(Request $request)
    {
        $tahun = session()->get('tahun_anggaran');
        $tanggal = date('Y-m-d', strtotime($request->tanggal));
        $data= $this->recursif_backdate($tanggal, $tahun, $request->rhs);
        $output = '';
        foreach ($data as $x => $row) {
            $param = $row->no_agenda.'|'.date('d-m-Y',strtotime($row->tanggal_surat));
            $output .= '<tr>';
            $output .= '<td>' . ($x+1) . '</td>';
            $output .= '<td>' . $row->no_agenda . '</td>';
            $output .= '<td>' . date('d-M-Y', strtotime($row->tanggal_surat)) . '</td>';
            $output .= '<td>' . $row->jumlah . '</td>';
            $output .= '<td><button class="btn btn-primary" onclick="pilihNomor(`'.$param.'`)">Pilih</button></td>';
            $output .= '</tr>';
        }
        echo $output;
    }
    public function recursif_backdate($tanggal, $tahun_anggaran, $rhs) 
    {
        if ($rhs=="rhs") {
            $data = DB::select('select z.* from 
                    (select a.no_agenda, a.tanggal_surat,
                    (select count(id) from t_surat_keluar where no_agenda=a.no_agenda and tanggal_surat=? and tahun_anggaran=?) jumlah
                    from t_surat_keluar a where tanggal_surat=? and tahun_anggaran=? and sifat_surat > 2
                    group by a.no_agenda, a.tanggal_surat order by a.id desc
                    ) z where z.jumlah < 27', [$tanggal, $tahun_anggaran, $tanggal, $tahun_anggaran]);
        // dd($tanggal, $tahun_anggaran, $rhs, $data);
        } else {
            $data = DB::select('select z.* from 
            (
                select a.no_agenda, a.tanggal_surat,
                (select count(id) from t_surat_keluar where no_agenda=a.no_agenda and tanggal_surat=? and tahun_anggaran=?) jumlah
                from t_surat_keluar a where tanggal_surat=? and tahun_anggaran=? and sifat_surat < 3
                group by a.no_agenda, a.tanggal_surat order by a.id desc
            ) z where z.jumlah < 27', [$tanggal, $tahun_anggaran, $tanggal, $tahun_anggaran]);
        }
        if ($data) {
            return $data;
        } else {
            $tgl_baru = date('Y-m-d', strtotime('-1 day', strtotime($tanggal)));
            return $this->recursif_backdate($tgl_baru, $tahun_anggaran, $rhs);
        }
    }
    public function buku_induk(Request $request) {
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
    public function buku_induk_export($bulan, $tahun, $rhs=NULL) {
        if (Auth::user()->role==1 && $rhs!=NULL) {
            $name = "buku_induk_surat_keluar_rhs_".$bulan.$tahun.".xlsx";
            return Excel::download(new BukuindukskExport($bulan, $tahun, $rhs), $name);
        } else {
            $name = "buku_induk_surat_keluar_".$bulan.$tahun.".xlsx";
            return Excel::download(new BukuindukskExport($bulan, $tahun, NULL), $name);
        }
    }
}
