<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KlasifikasiModel;
use App\Models\KlasifikasiBaruModel;
use App\Models\SuratmasukModel;
use App\Models\DisposisiModel;
use App\Models\PlhModel;
use App\Models\StatistikModel;
use App\Models\EncryptHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BukuinduksmExport;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Carbon\Carbon;
use Session;
use Mews\Captcha\Facades\Captcha;
use DataTables;

class SuratmasukController extends Controller
{
    protected $sm_model;
    protected $plh_model;
    protected $klasifikasi_model;
    protected $klasifikasi_model_baru;
    protected $stat_model;
    protected $enc_helper;
    public function __construct(
        SuratmasukModel $sm,
        PlhModel $plh,
        KlasifikasiModel $k,
        KlasifikasiBaruModel $k2,
        StatistikModel $stat,
        EncryptHelper $enc)
    {
        $this->sm_model = $sm;
        $this->plh_model = $plh;
        $this->klasifikasi_model = $k;
        $this->klasifikasi_model_baru = $k2;
        $this->stat_model = $stat;
        $this->enc_helper = $enc;
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = $this->sm_model->get_data();
        // foreach ($data as $row) {
        //     $row->belum_selesai_8_jam = $this->sm_model->get_waktu_proses($row->id);
        //     $row->enc_id = $this->enc_helper->encrypt($row->id);
        //     $row->posisi = $this->sm_model->posisi_surat($row->id);
        // $row->baru = DB::table('t_surat_masuk')
        //         ->join('t_disposisi','t_surat_masuk.id','=','t_disposisi.id_surat_masuk')
        //         ->select('t_surat_masuk.*','t_disposisi.*')
        //         ->where('t_surat_masuk.id',$row->id)
        //         ->get();
        // }
        // DB::table('users')
        //     ->join('t_jabatan', 't_jabatan.id', '=', 'users.id_jabatan')
        //     ->select('users.*', 't_jabatan.nama_jabatan', 't_jabatan.bagian')
        //     ->where('t_jabatan.id', '=', $id_turt)
        //     ->where('t_jabatan.teruskan', '=', '1')
        //     ->get();

        $tahun_anggaran = session()->get('tahun_anggaran');
        $tahun = date('Y');
        $editable = $tahun_anggaran == $tahun ? TRUE : FALSE;

        $id_turt = env('ID_JABATAN_TURT', '0');
        $pegawai = null;

        return view('surat_masuk.index', ([
            //'data' => $data,
            'pegawai' => $pegawai,
            'editable' => $editable,
        ]));
    }

    public function get_data_ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->sm_model->get_data_ajax($request);
            foreach ($data as $row) {
                $row->enc_id = $this->enc_helper->encrypt($row->id);
            }
	        $totalRecords = $this->sm_model->get_data_ajax($request, '*');
            $filteredRecords = $this->sm_model->get_data_ajax($request, 'filter');

            return Datatables::of($data)
                ->skipPaging()
                ->setTotalRecords(count($totalRecords))
                ->setFilteredRecords(count($filteredRecords))
                ->addIndexColumn()
                ->addColumn('dari', function($row) {
                    $dari = '';
                    if ($row->sifat_surat < 3) {
                        $dari = $row->dari;
                    }
                    return $dari;
                })
                ->addColumn('no_surat', function($row) {
                    $no_surat = '';
                    if ($row->sifat_surat < 3) {
                        $no_surat = $row->no_surat . '<br/>' . $row->tgl_surat . '<br/>' . $row->posisi;
                    }
                    return $no_surat;
                })
                ->addColumn('isi_ringkas', function($row) {
                    $isi_ringkas = $row->sifat_surat>2 ? 'SURAT RHS' : $row->isi_ringkas;

                    if ($row->sifat_surat > 2)
                    {
                        $isi_ringkas .= '<span class="badge badge-danger badge-pill mb-15 mr-10">Rahasia</span>';
                    }
                    if ($row->belum_selesai_8_jam > 0)
                    {
                        $isi_ringkas .= '<br/><span class="badge badge-danger badge-pill mb-15 mr-10">>8 jam</span>';
                    }

                    return $isi_ringkas;
                })
                ->addColumn('action', function($row) {
                    $tahun_anggaran = session()->get('tahun_anggaran');
                    $tahun = date('Y');
                    $editable = $tahun_anggaran == $tahun ? TRUE : FALSE;
                    
                    $button = '';
                    if ($row->sifat_surat < 3) {
                        $button = '<div class="btn-group">';
                        $button .= '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>';
                        $button .= '</button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
                        if (Auth::user()->role==1 || Auth::user()->role==4) {
                            $url = url('/sm/'.$row->enc_id.'/cetak');
                            $button .= '<a class="dropdown-item" href="'.$url.'" target="_blank">';
                            $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer dropdown-icon"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>';
                            $button .= '<span>Cetak Tanda Terima</span></a><div class="dropdown-divider"></div>';

                            if ($editable) {
                                $url = url('/sm/'.$row->enc_id.'/edit');
                                $button .= '<a class="dropdown-item" href="'.$url.'">';
                                $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 dropdown-icon"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg>';
                                $button .= '<span>Edit</span></a>';
                                
                                $button .= '<a class="dropdown-item" href="#" onclick="hapus('.$row->id.')">';
                                $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash dropdown-icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>';
                                $button .= '<span>Hapus</span></a>';
                            }

                            if ($row->arsipkan==0) {
                                $button .= '<a class="dropdown-item" href="#" onclick="arsipkan('. $row->id .')">';
                                $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive dropdown-icon"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>';
                                $button .= '<span>Arsipkan</span></a>';
                            }
                            $button .= '<div class="dropdown-divider"></div>';
                        }

                        $url = url('/sm/'.$row->enc_id.'/lacak');
                        $button .= '<a class="dropdown-item" href="'.$url.'">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search dropdown-icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';
                        $button .= '<span>Lihat Detil</span></a></div></div>';
                    }
                    return $button;
                })
                ->addColumn('file', function($row) {
                    $file = '';
                    if ($row->sifat_surat < 3) {
                        $gambar = asset('images/nopdf.webp');
                        $file = '<image src="'. $gambar .'" width="50">';
                        if (!empty($row->file)) {
                            $path = asset('dok/' . $row->file);
                            $gambar = asset('images/pdf.png');
                            $file = '<a href="'. $path .'" target="_blank"><image src="'. $gambar .'" width="50" ></a>';
                        }
                    }
                    return $file;
                })
                ->rawColumns(['dari','isi_ringkas','no_surat','file','action'])
                ->make(true);
        }
    }

    public function surat_rahasia() {
        $data = $this->sm_model->get_data_rahasia();
        foreach ($data as $row) {
            $row->belum_selesai_8_jam = $this->sm_model->get_waktu_proses($row->id);
            $row->enc_id = $this->enc_helper->encrypt($row->id);
        }

        $id_turt = env('ID_JABATAN_TURT', '0');
        $pegawai = DB::table('users')
            ->join('t_jabatan', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('users.*', 't_jabatan.nama_jabatan', 't_jabatan.bagian')
            ->where('t_jabatan.id', '=', $id_turt)
            ->get();
        
        $tahun_anggaran = session()->get('tahun_anggaran');
        $tahun = date('Y');
        $editable = $tahun_anggaran == $tahun ? TRUE : FALSE;

        return view('surat_masuk.rahasia', ([
            'data'     => $data,
            'pegawai'  => $pegawai,
            'editable' => $editable,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($rhs = NULL)
    {
        $tahun = date('Y');
        if ($tahun > 2023) {
            $klasifikasi = $this->klasifikasi_model_baru->get_klasifikasi();
        } else {
            $klasifikasi = $this->klasifikasi_model->get_klasifikasi();
        }
        return view('surat_masuk.catat', [
            'klasifikasi' => $klasifikasi,
            'rhs' => $rhs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'asal' => 'Required',
        //     'nomor_surat' => 'Required|unique:App\Models\SuratmasukModel,no_surat',
        //     'isi_ringkas' => 'Required',
        //     'kode' => 'Required',
        //     'tgl_surat' => 'Required',
        //     'file' => 'Required'
        // ]);
        $this->validate(
            $request,
            [
                'asal' => 'Required',
                'nomor_surat' => 'Required|unique:App\Models\SuratmasukModel,no_surat',
                'isi_ringkas' => 'Required',
                'kode' => 'Required',
                'tgl_surat' => 'Required',
            ],
            [
                'nomor_surat.unique' => 'Nomor Surat Sudah Ada',
                'nomor_surat.required' => 'Nomor Surat Harus Diisi',
                'asal.required' => 'Asal Surat Harus Diisi',
                'isi_ringkas.required' => 'Isi Ringkas Harus Diisi',
                'kode.required' => 'Kode Surat Harus Diisi',
                'tgl_surat.required' => 'Tanggal Surat Harus Diisi',
            ]
        );

        $tahun = session()->get('tahun_anggaran');
        $akhir = SuratmasukModel::where('tahun_anggaran', $tahun)->max('no_agenda');

        if (is_numeric($akhir)) {
            $nextnum = $akhir + 1;
        } else {
            $akhir = 0;
            $nextnum = 1;
        }

        $nama_file = '';
        $tgl_surat = date('Y-m-d', strtotime($request->tgl_surat));
        $sifat_surat = $request->sifat_surat ? $request->sifat_surat : NULL;

        $split_kode = explode("-", $request->kode);

        $id_surat = 0;
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = "DokSurat" . time() . "_" . $file->getClientOriginalName();
            // $tujuan_upload = base_path('dok');
            $tujuan_upload = 'dok';
            $file->move($tujuan_upload, $nama_file);

            $id_surat = SuratmasukModel::create([
                'no_agenda' => $nextnum,
                'id_klasifikasi' => $split_kode[0],
                'klasifikasi' => $split_kode[1].'-'.$split_kode[2],
                'isi_ringkas' => $request->isi_ringkas,
                'dari' => $request->asal,
                'no_surat' => $request->nomor_surat,
                'tgl_surat' => $tgl_surat,
                'sifat_surat' => $sifat_surat,
                'tgl_diterima' => date("Y-m-d"),
                'keterangan' => $request->keterangan,
                'file' => $nama_file,
                'tahun_anggaran' => $tahun,
                'user_id' => Auth::user()->nip,
                'created_at' => date("Y-m-d h:i:s a"),
                'updated_at' => NULL,
            ])->id;
        } else {
            $id_surat = SuratmasukModel::create([
                'no_agenda' => $nextnum,
                'id_klasifikasi' => $split_kode[0],
                'klasifikasi' => $split_kode[1].'-'.$split_kode[2],
                'isi_ringkas' => $request->isi_ringkas,
                'dari' => $request->asal,
                'no_surat' => $request->nomor_surat,
                'tgl_surat' => $tgl_surat,
                'sifat_surat' => $sifat_surat,
                'tgl_diterima' => date("Y-m-d"),
                'keterangan' => $request->keterangan,
                'tahun_anggaran' => $tahun,
                'user_id' => Auth::user()->nip,
                'created_at' => date("Y-m-d h:i:s a"),
                'updated_at' => NULL,
            ])->id;
        }

        // teruskan ke kasubbag TURT
        $id_turt = env('ID_JABATAN_TURT', '0');
        $turt = DB::table('users')->where('id_jabatan', '=', $id_turt)->first();
        $plh = $this->plh_model->get_plh($turt->nip);

        DisposisiModel::create([
            'id_surat_masuk' => $id_surat,
            'disposisi_oleh' => Auth::user()->nip,
            'disposisi_kepada' => $turt->nip,
            'plh' => $plh ? $plh->nip : NULL,
            'isi_disposisi' => '',
            'jenis' => 1, // 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
            'created_at' => date("Y-m-d h:i:s a"),
            'updated_at' => NULL,
        ]);

        if ($sifat_surat < 3) {
            return redirect('/sm')->with('status', 'Surat Masuk berhasil disimpan!');
        } else {
            return redirect('/sm_rhs')->with('status', 'Surat Masuk berhasil disimpan!');
        }
    }

    // Cetak Tanda Terima
    public function cetak_tanda($enc_id)
    {
        $id = $this->enc_helper->decrypt($enc_id);
        $data = DB::table('t_surat_masuk')
            ->join('users', 'users.nip', '=', 't_surat_masuk.user_id')
            // ->leftjoin('users', 't_surat_masuk.user_id', '=', 'users.nip')
            ->select('t_surat_masuk.*', 'users.nip', 'users.name')
            ->where('t_surat_masuk.id', $id)
            ->get();

        // dd($data);
        return view('surat_masuk.cetak1', (['surat' => $data]));
    }

    public function cetak_disposisi($enc_id)
    {
        $id_surat = $this->enc_helper->decrypt($enc_id);

        $surat = $this->sm_model->get_data_surat($id_surat);
        $disposisi = $this->sm_model->get_disposisi_surat($id_surat);
        // dd($disposisi);

        return view('disposisi.cetak', ([
            'surat' => $surat,
            'disposisi' => $disposisi,
        ]));
    }

    public function edit($enc_id)
    {
        $id = $this->enc_helper->decrypt($enc_id);

        $tahun = date('Y');
        if ($tahun > 2023) {
            $klasifikasi = $this->klasifikasi_model_baru->get_klasifikasi();
        } else {
            $klasifikasi = $this->klasifikasi_model->get_klasifikasi();
        }
        
        $data = SuratmasukModel::find($id);
        return view('surat_masuk.edit', ([
            'surat' => $data,
            'klasifikasi' => $klasifikasi
        ]));
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
        // $request->validate([
        //     'asal' => 'Required',
        //     'nomor_surat' => 'Required',
        //     'isi_ringkas' => 'Required',
        //     'kode' => 'Required',
        //     'tgl_surat' => 'Required',
        //     'no_agenda' => 'Required',
        // ]);

        $this->validate(
            $request,
            [
                'asal' => 'Required',
                //'nomor_surat' => 'Required|unique:App\Models\SuratmasukModel,no_surat',
                'isi_ringkas' => 'Required',
                'kode' => 'Required',
                'tgl_surat' => 'Required',
                'no_agenda' => 'Required',
            ],
            [
                'nomor_surat.unique' => 'Nomor Surat Sudah Ada',
                'nomor_surat.required' => 'Nomor Surat Harus Diisi',
                'asal.required' => 'Asal Surat Harus Diisi',
                'isi_ringkas.required' => 'Isi Ringkas Harus Diisi',
                'kode.required' => 'Kode Surat Harus Diisi',
                'tgl_surat.required' => 'Tanggal Surat Harus Diisi',
                'no_agenda.required' => 'No Agenda Harus Diisi',
            ]
        );

        $split_kode = explode("-", $request->kode);
        $tgl_surat = date('Y-m-d', strtotime($request->tgl_surat));
        $surat = SuratmasukModel::find($id);

        $object = ([
            'dari' => $request->asal,
            'no_surat' => $request->nomor_surat,
            'isi_ringkas' => $request->isi_ringkas,
            'id_klasifikasi' => $split_kode[0],
            'klasifikasi' => $split_kode[1].'-'.$split_kode[2],
            'tgl_surat' => $tgl_surat,
            'keterangan' => $request->keterangan,
            'no_agenda' => $request->no_agenda,
            'updated_at' => date("Y-m-d h:i:s a"),
        ]);
        $object['sifat_surat'] = $request->sifat_surat!='NULL' ? $request->sifat_surat : null;

        $surat->update($object);

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $nama_file = "DokSurat" . time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'dok';
            $file->move($tujuan_upload, $nama_file);

            $surat->update(['file' => $nama_file]);
        }

        if ($request->sifat_surat < 3 || $request->sifat_surat=="NULL") {
            return redirect('/sm')->with('status', 'Surat masuk berhasil diubah..!');
        } else {
            return redirect('/sm_rhs')->with('status', 'Surat masuk berhasil diubah..!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sm = SuratmasukModel::find($id);
        $sifat_surat = $sm->sifat_surat;
        $sm->delete();
        DisposisiModel::where('id_surat_masuk', '=', $id)->delete();

        if ($sifat_surat < 3) {
            return redirect('/sm')->with('status', 'Surat masuk berhasil dihapus..');
        } else {
            return redirect('/sm_rhs')->with('status', 'Surat masuk berhasil dihapus..');
        }
    }

    public function lacak($enc_id_surat) {
        // if (Auth::user()->role==2 || Auth::user()->role==4) {
        //     return redirect('/sm')->with('error', 'Anda tidak memiliki akses');
        // }
        $id_surat = $this->enc_helper->decrypt($enc_id_surat);
        $surat_masuk = SuratmasukModel::where('id', $id_surat)->first();
        $surat_masuk->enc_id = $enc_id_surat;
        $disposisi = $this->sm_model->get_disposisi_surat($id_surat);
        return view('surat_masuk.lacak', ([
            'surat_masuk' => $surat_masuk,
            'disposisi' => $disposisi,
        ]));
    }

    public function lacak_public(Request $request) {
        $this->validate(
            $request,
            [
                'no_surat' => 'required',
                'captcha' => 'required|captcha'
            ],
            [
                'captcha' => 'Captcha Salah'
            ]
        );

        $no_surat = $request->no_surat;
        $data = $this->sm_model->lacak_public($no_surat);
        // dd($data['disposisi']);

        return view('surat_masuk.lacak_public', ([
            'surat_masuk' => $data['surat_masuk'],
            'disposisi' => $data['disposisi'],
        ]));
    }

    public function reload_captcha() {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function buku_induk(Request $request) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $m = $bulan ? $bulan : date('m');
        $y = $tahun ? $tahun : date('Y');
        $ym = $this->stat_model->get_month_year();
        return view('surat_masuk.buku_induk', ([
            'bulan'  => $m,
            'tahun'  => $y,
            'months' => $ym['months'],
            'years'  => $ym['years'],
        ]));
    }

    public function buku_induk_export($bulan, $tahun, $rhs=NULL) {
        if (Auth::user()->role==1 && $rhs!=NULL) {
            $name = "buku_induk_surat_masuk_rhs_".$bulan.$tahun.".xlsx";
            return Excel::download(new BukuinduksmExport($bulan, $tahun, $rhs), $name);
        } else {
            $name = "buku_induk_surat_masuk_".$bulan.$tahun.".xlsx";
            return Excel::download(new BukuinduksmExport($bulan, $tahun, NULL), $name);
        }
    }

    public function send_wa($id) {
        $disposisi = $this->sm_model->get_dispo_by_id($id);

        $pesan = "Assalamualaikum, anda memiliki surat masuk yang belum ditanggapi.
Silahkan login dengan user *".$disposisi->nip."* di aplikasi *E-Surat PTA : surat.pta-bandung.go.id * dan buka menu *Surat Masuk > Inbox* untuk melihat surat yang belum ditanggapi.
Terimakasih.";


        $response = Http::post('https://whatsva.com/api/sendMessageText', [
             'apikey'  => env('API_KEY', ''),
             'jid'     => $disposisi->no_hp,
             'message' => $pesan,
        ]);

        $id_surat = $this->enc_helper->encrypt($disposisi->id_surat_masuk);
        $url = url('/sm/'.$id_surat.'/lacak');
        if ($response->status()) {
            return redirect($url)->with('status', 'Berhasil Kirim Notifikasi WhatsApp');
        } else{
            return redirect($url)->with('error', 'Gagal Kirim Notifikasi WhatsApp');
        }
    }
    public function send_wa_test($id) {
        $disposisi = $this->sm_model->get_dispo_by_id($id);

        $pesan = "Assalamualaikum, anda memiliki surat masuk yang belum ditanggapi.
Silahkan login dengan user *".$disposisi->nip."* di aplikasi *E-Surat PTA : surat.pta-bandung.go.id * dan buka menu *Surat Masuk > Inbox* untuk melihat surat yang belum ditanggapi.
Terimakasih.";

        try {
            $curl = curl_init();
            $data = [
                "message" => '$pesan',
                "jid"     => "628987347793",
                "apikey"  => "LRAJCoktkM3t"
            ];
            $payload = json_encode($data);

            $ch = curl_init("https://whatsva.com/api/sendMessageText");
            # Setup request to send json via POST.

            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            # Return response instead of printing.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            # Send request.
            $result = curl_exec($ch);
            curl_close($ch);
	    dd($result);
        } catch (\Exception $e) {
            // return $e->getMessage();
            dd($e->getMessage());
        }
    }

    public function arsipkan(Request $request) {
        $id = $request->id_surat_arsip;
        $jenis_arsip = $request->jenis_arsip;
        $lokasi_arsip = $request->lokasi_arsip;

        $surat = db::table('t_surat_masuk')
                ->where('id', $id)
                ->update([
                    'arsipkan'     => 1,
                    'jenis_arsip'  => $jenis_arsip,
                    'lokasi_arsip' => $lokasi_arsip,
                ]);

        return redirect('/sm')->with('status', 'Surat berhasil diarsipkan');
    }

    public function get_arsip_ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->sm_model->get_arsip_ajax($request);
            foreach ($data as $row) {
                $row->jenis_arsip = $row->jenis_arsip == 'P' ? "Kepaniteraan" : "Kesekretariatan";
            }
	        $totalRecords = $this->sm_model->get_arsip_ajax($request, '*');
            $filteredRecords = $this->sm_model->get_arsip_ajax($request, 'filter');

            return Datatables::of($data)
                ->skipPaging()
                ->setTotalRecords(count($totalRecords))
                ->setFilteredRecords(count($filteredRecords))
                ->addIndexColumn()
                ->addColumn('no_agenda', function($row) {
                    return $row->no_agenda;
                })
                ->addColumn('no_surat', function($row) {
                    return $row->no_surat;
                })
                ->addColumn('jenis_arsip', function($row) {
                    return $row->jenis_arsip;
                })
                ->addColumn('lokasi_arsip', function($row) {
                    return $row->lokasi_arsip;
                })
                ->rawColumns(['no_agenda','no_surat','jenis_arsip','lokasi_arsip'])
                ->make(true);
        }
    }

    public function arsip()
    {
        // $data = DB::table('t_surat_masuk')
        //     ->select("id", "no_agenda", "no_surat", "file", "jenis_arsip", "lokasi_arsip")
        //     ->where("arsipkan", "=", "1")
        //     ->orderByDesc('no_agenda')
        //     ->get();

        return view('surat_masuk.arsip', ([
            // 'data' => $data,
        ]));
    }
}
