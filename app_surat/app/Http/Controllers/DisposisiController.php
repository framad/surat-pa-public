<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DisposisiModel;
use App\Models\SuratmasukModel;
use App\Models\TembusanModel;
use App\Models\PlhModel;
use App\Models\User;
use App\Models\EncryptHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonitoringDisposisiExport;
use App\Models\StatistikModel;

class DisposisiController extends Controller
{
    protected $dispo_model;
    protected $plh_model;
    protected $sm_model;
    protected $enc_helper;
    protected $stat_model;
    protected $tembus;
    public function __construct(
        DisposisiModel $dispo,
        PlhModel $plh,
        SuratmasukModel $sm,
        EncryptHelper $enc,
        StatistikModel $stat,
        TembusanModel $tembus)
    {
        $this->dispo_model = $dispo;
        $this->plh_model = $plh;
        $this->sm_model = $sm;
        $this->enc_helper = $enc;
        $this->stat_model = $stat;
        $this->tembus = $tembus;
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        // $tahun = session()->get('tahun_anggaran');
        $nip = "'".Auth::user()->nip."'";

        $role = Auth::user()->role;
        if ($role==5) { // role ajudan, cari nip atasan nya
            $atasan = DB::select("select u.id_jabatan, j.id_atasan, atasan.nip, atasan.name from users u join t_jabatan j on u.id_jabatan=j.id
                                join users atasan on j.id_atasan=atasan.id_jabatan where atasan.active=1 and u.nip=".$nip);
            if ($atasan) {
                $nip = $atasan[0]->nip;
            }
        }

        // $data =  DB::table('t_surat_masuk')
        //     ->join('t_disposisi', 't_surat_masuk.id', '=', 't_disposisi.id_surat_masuk')
        //     ->select(
        //         't_surat_masuk.id as id_surat',
        //         't_surat_masuk.klasifikasi',
        //         't_surat_masuk.no_agenda',
        //         't_surat_masuk.sifat_surat',
        //         't_surat_masuk.isi_ringkas',
        //         't_surat_masuk.dari',
        //         't_surat_masuk.no_surat',
        //         't_surat_masuk.tgl_surat',
        //         't_surat_masuk.tgl_diterima',
        //         't_surat_masuk.keterangan',
        //         't_surat_masuk.file',
        //         't_surat_masuk.tahun_anggaran',
        //         't_surat_masuk.user_id',
        //         't_surat_masuk.created_at',
        //         't_surat_masuk.updated_at',
        //         't_disposisi.*',
        //     )
        //     ->whereRaw('(disposisi_kepada='.$nip.' OR plh='.$nip.')')
        //     ->where('t_disposisi.teruskan', '=', null)
        //     ->get();

        $sql = "SELECT m.id id_surat, m.klasifikasi, m.no_agenda, m.sifat_surat, m.isi_ringkas, m.dari, m.no_surat, m.tgl_surat,
                m.tgl_diterima, m.keterangan, m.file, m.tahun_anggaran, m.user_id, m.created_at, m.updated_at, d.*, false tembusan
                FROM t_surat_masuk m JOIN t_disposisi d ON m.id=d.id_surat_masuk
                WHERE (disposisi_kepada=".$nip." OR plh=".$nip.") AND d.teruskan IS NULL
                UNION
                SELECT m.id id_surat, m.klasifikasi, m.no_agenda, m.sifat_surat, m.isi_ringkas, m.dari, m.no_surat, m.tgl_surat,
                m.tgl_diterima, m.keterangan, m.file, m.tahun_anggaran, m.user_id, m.created_at, m.updated_at, d.*, true tembusan
                FROM t_disposisi d JOIN t_tembusan t ON d.id=t.id_disposisi JOIN t_surat_masuk m ON m.id=d.id_surat_masuk
                WHERE t.nip=".$nip." AND t.read=0";
        $data =  DB::select($sql);
        foreach ($data as $row) {
            $row->enc_id = $this->enc_helper->encrypt($row->id_surat);
        }

        $level = DB::table('t_jabatan')
            ->join('users', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('t_jabatan.level')
            ->where('users.nip', Auth::user()->nip)
            ->first()->level;

        $pegawai = DB::table('users')
            ->join('t_jabatan', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('users.*', 't_jabatan.nama_jabatan', 't_jabatan.bagian')
            ->where([['t_jabatan.level', '<=', $level],['users.nip', '<>', Auth::user()->nip],['t_jabatan.teruskan', '=', '1'],['users.active', '=', '1']])
            ->orderBy('users.urutan')
	    ->get();

        return view('disposisi.index', ([
            'data'    => $data,
            'pegawai' => $pegawai,
            'level'   => $level,
            'role'    => $role,
        ]));
    }

    public function show($id_surat_enc, $id)
    {
        $id_surat = $this->enc_helper->decrypt($id_surat_enc);
        $suratmasuk = SuratmasukModel::where('id', $id_surat)->first();
        $history = $this->sm_model->get_disposisi_surat($id_surat);
        $disposisi = $this->sm_model->get_disposisi($id);
        // $tembusan = $this->sm_model->is_tembusan($id);
        $level = DB::table('t_jabatan')->where('id', Auth::user()->id_jabatan)
                ->select('level')->first()->level;

        // $tembusan = DB::table('t_tembusan')->where('id_disposisi', $id)->first();
        $tembusan = TembusanModel::where('id_disposisi', $id)->where('nip',Auth::user()->nip)->first();
        if($tembusan) {
            // $object = (['read' => 1]);
            $tembusan->update(['read' => 1]);
        }

        return view('disposisi.dispo', ([
            'id'           => $id,
            'id_surat_enc' => $id_surat_enc,
            'disposisi'    => $disposisi,
            'suratmasuk'   => $suratmasuk,
            'history'      => $history,
            'level'        => $level,
            'tembusan'     => $tembusan,
        ]));
    }

    public function create($id_surat_enc, $id)
    {
        $id_surat = $this->enc_helper->decrypt($id_surat_enc);
        $suratmasuk = SuratmasukModel::where('id', $id_surat)->first();
        //$pegawai = $this->dispo_model->get_pegawai_disposisi($id);

	    $dispo = $this->dispo_model->get_pegawai_disposisi($id);
        $dispo_rhs = [];
        if ($suratmasuk->sifat_surat==3) {
            $dispo_rhs = $this->dispo_model->get_pegawai_disposisi_pengaduan();
        }
        $pegawai = $dispo->merge($dispo_rhs);

        $sql = "SELECT name FROM users WHERE active=1 AND role<>5 AND nip<>'admin' ORDER BY urutan, id";
        $tembusan = DB::select($sql);

	$now = date('Y-m-d');
        foreach ($dispo as $row) {
            $sql_plh = "SELECT u.nip, u.name, j.nama_jabatan FROM t_plh p JOIN users u ON p.nip=u.nip JOIN t_jabatan j ON u.id_jabatan=j.id
                        WHERE p.id_jabatan=? AND ? BETWEEN tanggal_awal AND tanggal_akhir";
            $user_plh = DB::select($sql_plh, [$row->id_jabatan, $now]);
            if ($user_plh) {
                $row->name = $user_plh[0]->name;
                $row->nama_jabatan = "PLH " . $row->nama_jabatan;
            }
        }

        return view('disposisi.add', ([
            'id'           => $id,
            'id_surat_enc' => $id_surat_enc,
            'data'         => $suratmasuk,
            'pegawai'      => $pegawai,
            'tembusan'     => $tembusan,
        ]));
    }

    public function store_ajax(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $id_disposisi = $request->id_disposisi;
        $dispo = DisposisiModel::find($id_disposisi);

        if ($dispo->teruskan!=1) {
            $plh = $this->plh_model->get_plh($request->kepada);

            $id_surat = $request->id_surat;
            $kepada = $request->kepada;
            $plh = $plh ? $plh->nip : NULL;
            $isi_disposisi = $request->isi_disposisi;
            $tembusan = $request->tembusan;

            $new_dispo = DisposisiModel::create([
                'id_surat_masuk' => $id_surat,
                'disposisi_oleh' => Auth::user()->nip,
                'disposisi_kepada' => $kepada,
                'plh' => $plh,
                'isi_disposisi' => $isi_disposisi,
                'jenis' => 2, // 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => NULL,
            ]);

            if ($tembusan) {
                foreach ($tembusan as $tem) {
                    $user = User::where('name',$tem)->first();
                    if (($user->nip != $kepada) && ($user->nip != $plh)) {
                        TembusanModel::create([
                            'id_disposisi' => $new_dispo->id,
                            'nip'          => $user->nip,
                            'created_at'   => date("Y-m-d H:i:s"),
                            'updated_at'   => NULL
                        ]);
                    }
                }
            }

            $dispo->teruskan = '1';
            $dispo->updated_at = date("Y-m-d H:i:s");
            $dispo->save();

            session()->flash('status', 'Disposisi berhasil disimpan');
            return url("/disposisi");
        } else {
            session()->flash('error', 'Disposisi sudah ada');
            return redirect("/disposisi");
        }
    }

    public function store(Request $request)
    {
        // $plh = $this->plh_model->get_plh($request->kepada);
        // DisposisiModel::create([
        //     'id_surat_masuk' => $request->id_surat,
        //     'disposisi_oleh' => Auth::user()->nip,
        //     'disposisi_kepada' => $request->kepada,
        //     'plh' => $plh ? $plh->nip : NULL,
        //     'isi_disposisi' => $request->isi_disposisi,
        //     'jenis' => 2, // 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
        //     'created_at' => date("Y-m-d H:i:s"),
        //     'updated_at' => NULL,
        // ]);
        // $disposisi = db::table('t_disposisi')
        //             ->where('id', $request->id_disposisi)
        //             ->update([
        //                 'teruskan' => 1,
        //                 'updated_at' => date("Y-m-d H:i:s"),
        //             ]);
        // return redirect('/disposisi')->with('status', 'Disposisi berhasil disimpan!');

        $id_disposisi = $request->id_disposisi;
        $dispo = DisposisiModel::find($id_disposisi);
        if ($dispo->teruskan!=1) {
            $plh = $this->plh_model->get_plh($request->kepada);

            DisposisiModel::create([
                'id_surat_masuk' => $request->id_surat,
                'disposisi_oleh' => Auth::user()->nip,
                'disposisi_kepada' => $request->kepada,
                'plh' => $plh ? $plh->nip : NULL,
                'isi_disposisi' => $request->isi_disposisi,
                'jenis' => 2, // 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => NULL,
            ]);

            date_default_timezone_set("Asia/Bangkok");
            $dispo->teruskan = '1';
            $dispo->updated_at = date("Y-m-d H:i:s");
            $dispo->save();
            return redirect('/disposisi')->with('status', 'Disposisi berhasil disimpan');
        } else {
            return redirect('/disposisi')->with('status', 'Disposisi sudah ada');
        }
    }

    public function view($id)
    {
        $data = SuratmasukModel::find($id);
        // dd($data);
        return view('surat_masuk.lihat', (['surat' => $data]));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function teruskan(Request $request, $id)
    {
        DisposisiModel::create([
            'id_surat_masuk' => $id,
            'disposisi_oleh' => Auth::user()->nip,
            'disposisi_kepada' => $request->kepada,
            'jenis' => 1, // 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
            'created_at' => date("Y-m-d h:i:s a"),
            'updated_at' => NULL,
        ]);
        return redirect('/sm')->with('status', 'Surat Masuk berhasil disimpan!');
    }

    public function teruskanDisposisi(Request $request)
    {
        try {
            $plh = $this->plh_model->get_plh($request->kepada);
            // $nip_plh = $plh->nip;
            DisposisiModel::create([
                'id_surat_masuk' => $request->id_surat_teruskan,
                'disposisi_oleh' => Auth::user()->nip,
                'disposisi_kepada' => $request->kepada,
                'plh' => $plh ? $plh->nip : NULL,
                'jenis' => 1, // 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
                'created_at' => date("Y-m-d h:i:s a"),
                'updated_at' => NULL,
            ]);

            $disposisi = db::table('t_disposisi')
            ->where('id', $request->id_dispo_teruskan)
            ->update([
                'teruskan' => 1,
                'updated_at' => date("Y-m-d h:i:s"),
            ]);

            return redirect('/disposisi')->with('status', 'Meneruskan Surat berhasil disimpan!');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateSifatSurat(Request $request, $id)
    {
        $sm = db::table('t_surat_masuk')
            ->where('id', $id)
            ->update(['sifat_surat' => $request->sifat_surat]);

        return redirect('/disposisi')->with('status', 'Sifat surat berhasil disimpan!');
    }

    public function tindak_lanjut(Request $request, $id) {
        $data = DisposisiModel::find($id);
        $teruskan = $request->tindaklanjut=='F' ? 1 : NULL; // F=selesai, P=Progress

        $arsipkan = $request->tindaklanjut=='F' ? $request->arsipkan : '0';
        $jenis_arsip = $request->tindaklanjut=='F' ? $request->jenis_arsip : NULL;
        $lokasi_arsip = $request->tindaklanjut=='F' ? $request->lokasi_arsip : NULL;

        if ($data->jenis != 3) { // jenis 3=tindak lanjut
            DisposisiModel::create([
                'id_surat_masuk'    => $request->id_surat,
                'disposisi_oleh'    => Auth::user()->nip,
                'disposisi_kepada'  => Auth::user()->nip,
                'catatan_disposisi' => $request->catatan_disposisi,
                'tindaklanjut'      => $request->tindaklanjut,
                'teruskan'          => $teruskan,
                'jenis'             => 3, // 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
            ]);

            $disposisi = db::table('t_disposisi')
                ->where('id', $id)
                ->update(['teruskan' => 1]);
        } else {
            $disposisi = db::table('t_disposisi')
                ->where('id', $id)
                ->update([
                    'tindaklanjut'      => $request->tindaklanjut,
                    'catatan_disposisi' => $request->catatan_disposisi,
                    'teruskan'          => $teruskan,
                ]);
        }

        $surat = db::table('t_surat_masuk')
                ->where('id', $request->id_surat)
                ->update([
                    'arsipkan'     => $arsipkan=="on" ? 1 : 0,
                    'jenis_arsip'  => $jenis_arsip,
                    'lokasi_arsip' => $lokasi_arsip,
                ]);

        return redirect('/disposisi')->with('status', 'Tindak lanjut berhasil disimpan!');
    }

    public function hapusDisposisi(Request $request)
    {
        $id_surat = $request->id_surat_hapus;
        $id_dispo = $request->id_dispo_hapus;
        $enc_id = $this->enc_helper->encrypt($id_surat);

        try {
            $prev_dispos = $this->dispo_model->get_previous_disposisi($id_surat, $id_dispo);
            if ($prev_dispos) {
                // delete this dispo
                $dispo = DisposisiModel::find($id_dispo);
                $dispo->delete();

                // update previous dispo
                $prev_dispo = $prev_dispos[0];
                $update = db::table('t_disposisi')
                        ->where('id', $prev_dispo->id)
                        ->update([
                            'teruskan'   => null,
                            'updated_at' => null,
                        ]);
                // dd($update);

                return redirect('/sm/'.$enc_id.'/lacak')->with('status', 'Disposisi Berhasil Dihapus!');
            } else {
                return redirect('/sm/'.$enc_id.'/lacak')->with('error', 'Disposisi Gagal Dihapus!');
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            return redirect('/sm/'.$enc_id.'/lacak')->with('error', $e->getMessage());
        }
    }

    public function monitoring(Request $request) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $m = $bulan ? $bulan : date('m');
        $y = $tahun ? $tahun : date('Y');
        $ym = $this->stat_model->get_month_year();
        return view('surat_masuk.monitoring_disposisi', ([
            'bulan'  => $m,
            'tahun'  => $y,
            'months' => $ym['months'],
            'years'  => $ym['years'],
        ]));
    }

    public function monitoring_export($bulan, $tahun) {
        $name = "monitoring_disposisi_surat_masuk_".$bulan.$tahun.".xlsx";
        return Excel::download(new MonitoringDisposisiExport($bulan, $tahun), $name);
    }
}
