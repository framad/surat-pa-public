<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DisposisiModel;
use App\Models\User;
use phpDocumentor\Reflection\Types\Self_;
use Illuminate\Http\Request;

class SuratmasukModel extends Model
{
    use HasFactory;
    protected $table = 't_surat_masuk';
    protected $fillable = [
        'id',
        'no_agenda',
        'id_klasifikasi',
        'klasifikasi',
        'sifat_surat',
        'indek_berkas',
        'isi_ringkas',
        'dari',
        'no_surat',
        'tgl_surat',
        'tgl_diterima',
        'keterangan',
        'file',
        'tahun_anggaran',
        'user_id',
        'arsipkan',
        'jenis_arsip',
        'lokasi_arsip',
        'created_at',
        'updated_at'
    ];

    public function get_data() {
        $tahun = session()->get('tahun_anggaran');
        $sql = "SELECT m.id, m.klasifikasi, m.no_agenda, m.sifat_surat, m.isi_ringkas,
                m.dari, m.no_surat, m.tgl_surat, m.file, m.arsipkan
                FROM t_surat_masuk m LEFT JOIN t_disposisi d ON m.id=d.id_surat_masuk
                WHERE m.tahun_anggaran=".$tahun; // ." AND m.sifat_surat < 3"
                // sifat surat: 1=biasa,2=penting,3=rhs pengaduan,4=rhs kepeg,5=rhs banding

        // 1=admin,2=user,3=super user,4=operator,5=ajudan
        if (Auth::user()->role==2 || Auth::user()->role==3) {
            if (Auth::user()->role==2 || Auth::user()->role==3) {
                $nip = Auth::user()->nip;
                $sql .= " AND (d.disposisi_kepada='".$nip."' OR d.plh='".$nip."')";
            }
        }
        if (Auth::user()->role!=2 && Auth::user()->role!=3) {
            $sql .= " OR sifat_surat IS NULL";
        }
        $sql .= " GROUP BY m.id, m.klasifikasi, m.no_agenda, m.sifat_surat, m.isi_ringkas,
                  m.dari, m.no_surat, m.tgl_surat, m.file, m.arsipkan
                  ORDER BY m.no_agenda DESC";
        $data = DB::select($sql);
        return $data;
    }

    public function query_admin($request, $origin=null) {
        $tahun = session()->get('tahun_anggaran');
        $search = $request->input('search.value');
        $length = ($request->length) ? $request->length : 10;
        $start = ($request->start) ? $request->start : 0;
        $nip = Auth::user()->nip;

        $sql = "SELECT * FROM t_surat_masuk WHERE tahun_anggaran=".$tahun;

        if ($origin != '*') {
            if ($search) { // jika datatable mengirimkan pencarian dengan metode POST
                $sql .= " AND (isi_ringkas like '%" . $search . "%'
                         OR no_agenda like '%" . $search . "%'
                         OR dari like '%" . $search . "%'
                         OR dari like '%" . $search . "%'
                         OR no_surat like '%" . $search . "%')";
            }
        }
        $sql .= " ORDER BY no_agenda DESC";

        if ($origin == null) {
            if ($length != -1) {
                $sql .= " LIMIT " . $length . " OFFSET " . $start;
            }
        }

        $data = DB::select($sql);
        if ($origin == null) {
            foreach ($data as $row) {
                $row->belum_selesai_8_jam = $this->get_waktu_proses($row->id);
                $row->posisi = $this->posisi_surat($row->id);
            }
        }
        return $data;
    }
    public function get_data_ajax($request, $origin=null) {
        $tahun = session()->get('tahun_anggaran');
        $search = $request->input('search.value');
        $length = ($request->length) ? $request->length : 10;
        $start = ($request->start) ? $request->start : 0;
        $nip = Auth::user()->nip;

	    if (in_array(Auth::user()->role, [1,4])) {
            // admin
            return $this->query_admin($request, $origin);
        }

        $sql = "SELECT m.id, m.klasifikasi, m.no_agenda, m.sifat_surat, m.isi_ringkas,
                m.dari, m.no_surat, m.tgl_surat, m.file, m.arsipkan, false tembusan
                FROM t_surat_masuk m LEFT JOIN t_disposisi d ON m.id=d.id_surat_masuk
                WHERE (m.tahun_anggaran=".$tahun; // ." AND m.sifat_surat < 3"
                // sifat surat: 1=biasa,2=penting,3=rhs pengaduan,4=rhs kepeg,5=rhs banding

        // 1=admin,2=user,3=super user,4=operator,5=ajudan
        if (Auth::user()->role==2 || Auth::user()->role==3) {
            $sql .= " AND (d.disposisi_kepada='".$nip."' OR d.plh='".$nip."'))";
        } else if (Auth::user()->role!=2 && Auth::user()->role!=3) {
            $sql .= " OR sifat_surat IS NULL)";
        }

        // if ($origin != '*') {
        //     if ($search) { // jika datatable mengirimkan pencarian dengan metode POST
        //         $sql .= " AND (isi_ringkas like '%" . $search . "%'
        //                     OR m.no_agenda like '%" . $search . "%'
        //                     OR m.dari like '%" . $search . "%'
        //                     OR m.dari like '%" . $search . "%'
        //                     OR m.no_surat like '%" . $search . "%')";
        //     }
        // }

        if (Auth::user()->role!=4 && Auth::user()->role!=5) {
            $sql = "SELECT * FROM (" .$sql;
            $sql .= " UNION SELECT m.id, m.klasifikasi, m.no_agenda, m.sifat_surat, m.isi_ringkas,
                    m.dari, m.no_surat, m.tgl_surat, m.file, m.arsipkan, true tembusan
                    FROM t_tembusan t JOIN t_disposisi d ON t.id_disposisi=d.id JOIN t_surat_masuk m ON m.id=d.id_surat_masuk
                    WHERE t.nip='$nip' AND t.read=1 AND m.tahun_anggaran='$tahun'
                    ) as A";
        }

        if ($origin != '*') {
            if ($search) { // jika datatable mengirimkan pencarian dengan metode POST
                if (Auth::user()->role!=4 && Auth::user()->role!=5) {
                    $sql .= " WHERE ";
                } else {
                    $sql .= " AND ";
                }
                $sql .= "(isi_ringkas like '%" . $search . "%'
                         OR no_agenda like '%" . $search . "%'
                         OR dari like '%" . $search . "%'
                         OR dari like '%" . $search . "%'
                         OR no_surat like '%" . $search . "%')";
            }
        }

        $sql .= " GROUP BY id, klasifikasi, no_agenda, sifat_surat, isi_ringkas, dari, no_surat, tgl_surat, file, arsipkan, tembusan
                  ORDER BY no_agenda DESC";

        // dd($sql);

        if ($origin == null) {
            if ($length != -1) {
                $sql .= " LIMIT " . $length . " OFFSET " . $start;
            }
        }

        try {
            $data = DB::select($sql);
            if ($origin == null) {
                foreach ($data as $row) {
                    $row->belum_selesai_8_jam = $this->get_waktu_proses($row->id);
                    $row->posisi = $this->posisi_surat($row->id);
                }
            }
            return $data;
        } catch (\Exception $ex) {
            // dd($ex->getMessage());
        }
    }

    public function get_data_rahasia() {
        $tahun = session()->get('tahun_anggaran');
        $sql = "SELECT m.id, m.klasifikasi, m.no_agenda, m.sifat_surat, m.isi_ringkas, m.dari, m.no_surat, m.tgl_surat, m.file
                FROM t_surat_masuk m LEFT JOIN t_disposisi d ON m.id=d.id_surat_masuk
                WHERE m.tahun_anggaran=".$tahun." AND m.sifat_surat > 2";
                // sifat surat: 1=biasa,2=penting,3=rhs pengaduan,4=rhs kepeg,5=rhs banding
        if (Auth::user()->role==2 || Auth::user()->role==4) { // surat hanya terlihat oleh admin, super user dan user yang mendapatkan disposisi
            $nip = Auth::user()->nip;
            $sql .= " AND (d.disposisi_kepada='".$nip."' OR d.plh='".$nip."')";
        }
        if (Auth::user()->role!=2 && Auth::user()->role!=3) { // sifat surat NULL = belum ditentukan
            // $sql .= " OR sifat_surat IS NULL";
        }
        $sql .= " GROUP BY m.id, m.klasifikasi, m.no_agenda, m.sifat_surat, m.isi_ringkas, m.dari, m.no_surat, m.tgl_surat, m.file
                  ORDER BY m.tgl_surat DESC";
        $data = DB::select($sql);
        return $data;
    }
    public function get_disposisi($id_disposisi) {
        $data = DisposisiModel::find($id_disposisi);
        return $data;
    }
    public function is_tembusan($id_disposisi) {
        $nip = "'".Auth::user()->nip."'";
        $sql = "SELECT COUNT(*) hitung FROM t_tembusan WHERE id_disposisi=".$id_disposisi." AND nip=".$nip;
        $data = DB::select($sql);
        if ($data[0]->hitung > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function get_disposisi_surat($id_surat) {
        $data = DB::select('SELECT d.id, o.name AS oleh, j2.nama_jabatan jabatan_oleh, d.jenis, d.isi_disposisi, d.catatan_disposisi, d.teruskan,
                            d.tindaklanjut, d.created_at, d.updated_at, k.name AS kepada, j.nama_jabatan, plh.name pelaksana, d.id_surat_masuk
                            FROM t_disposisi AS d
                            LEFT JOIN users AS o ON d.disposisi_oleh=o.nip
                            LEFT JOIN users AS k ON d.disposisi_kepada=k.nip
                            LEFT JOIN users AS plh ON d.plh=plh.nip
                            JOIN t_jabatan j ON k.id_jabatan=j.id
                            JOIN t_jabatan j2 ON o.id_jabatan=j2.id
                            WHERE d.id_surat_masuk=? ORDER BY d.id', [$id_surat]);

        $disposisi = array();
        foreach ($data as $row) {
            $dispo = '';
            if ($row->jenis==3) { // jenis = 1:Teruskan, 2:Disposisi, 3:Tindaklanjut
                $dispo = $row->oleh;
            } else {
                $dispo = $row->oleh . ($row->jenis==1 ? ' MENERUSKAN KE ':' DISPOSISI KE ') . $row->kepada;
            }

            // $oleh = $row->oleh;
            // $trimmedOleh = (strlen($oleh) > 20) ? substr($oleh, 0, 20) . "..." : $oleh;

            date_default_timezone_set("Asia/Bangkok");
            $arr = [
                'id' => $row->id,
                'id_surat_masuk' => $row->id_surat_masuk,
                'oleh' => $row->oleh,
                'jabatan_oleh' => $row->jabatan_oleh,
                'jenis' => $row->jenis, //==1 ? 'Meneruskan Ke':'Disposisi Ke',
                'jenis_text' => $row->jenis==1 ? 'Meneruskan' : ($row->jenis==2 ? 'Disposisi' : 'Tindak Lanjut'),
                'kepada' => $row->kepada,
                'nama_jabatan' => $row->nama_jabatan,
                'pelaksana' => $row->pelaksana ? '(PLH) : '.$row->pelaksana : NULL,
                'disposisi' => $dispo,
                'isi_disposisi' => $row->isi_disposisi ? $row->isi_disposisi : '-',
                'teruskan' => $row->teruskan==1 ? 'Sudah diteruskan':'Belum diteruskan',
                'tindaklanjut' => $row->catatan_disposisi ? $row->catatan_disposisi:'-',
                'tgl_terima' => date('d F Y', strtotime($row->created_at)),
                'tgl_selesai' => $row->updated_at ? date('d F Y', strtotime($row->updated_at)) : '-',
                'jam_terima' => date('H:i:s', strtotime($row->created_at)),
                'jam_selesai' => $row->updated_at ? date('H:i:s', strtotime($row->updated_at)) : '-',
            ];
            array_push($disposisi, (object)$arr);
        }
        // dd($disposisi);

        return $disposisi;
    }
    public function get_dispo_by_id($id) {
        $data = DB::table('t_disposisi AS d')
             ->leftJoin('users AS u', 'd.disposisi_kepada', '=', 'u.nip')
             ->where('d.id','=',$id)
             ->first();
        return $data;
    }
    public function get_waktu_proses($id_surat_masuk) {
        $query = "SELECT m.id, m.created_at, d.updated_at, d.tindaklanjut, TIMESTAMPDIFF(MINUTE, m.created_at, CURRENT_TIMESTAMP()) diff_menit
                  FROM t_surat_masuk m LEFT JOIN t_disposisi d ON m.id=d.id_surat_masuk
                  WHERE m.id=? ORDER BY d.id DESC LIMIT 1";
        $data = DB::select($query, [$id_surat_masuk]);
        $belum_selesai_lebih_dari_8_jam =
            $data[0]->tindaklanjut=='F' ?
                0 :
                ($data[0]->diff_menit <= 480 ? 0 : 1)
        ;

        return $belum_selesai_lebih_dari_8_jam;
    }

    public function get_count_statistik($bulan, $tahun, $limit, $start, $search) {
        $bulan = sprintf("%02d", $bulan);
        $tgl_diterima = $tahun.'-'.$bulan;
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT k.id, k.kode, k.nama, k.uraian, count(k.id) jumlah
                FROM t_surat_masuk m JOIN ref_klasifikasi".$table." k ON m.id_klasifikasi=k.id
                WHERE LEFT(m.tgl_diterima, 7)=?";
        if ($search) {
            $sql .= " AND ((k.kode LIKE ?) OR (k.nama LIKE ?))";
        }
        $sql .= " GROUP BY k.id, k.kode, k.nama, k.uraian ORDER BY k.id";
        if ($limit > 0) {
            $sql .= " LIMIT " . $limit . " OFFSET " . $start;
        }
        if ($search) {
            $data = DB::select($sql, [$tgl_diterima, '%'.$search.'%', '%'.$search.'%']);
        } else {
            $data = DB::select($sql, [$tgl_diterima]);
        }
    }

    public function get_statistik_server_side($bulan, $tahun, $limit, $start, $search) {
        $bulan = sprintf("%02d", $bulan);
        $tgl_diterima = $tahun.'-'.$bulan;
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT SQL_CALC_FOUND_ROWS k.id, k.kode, k.nama, k.uraian, count(k.id) jumlah
                FROM t_surat_masuk m JOIN ref_klasifikasi".$table." k ON m.id_klasifikasi=k.id
                WHERE LEFT(m.tgl_diterima, 7)=?";
        $sql_count = "SELECT FOUND_ROWS() found";
        if ($search) {
            $sql .= " AND ((k.kode LIKE ?) OR (k.nama LIKE ?))";
        }
        $sql .= " GROUP BY k.id, k.kode, k.nama, k.uraian ORDER BY k.id";
        if ($limit > 0) {
            $sql .= " LIMIT " . $limit . " OFFSET " . $start;
        }
        if ($search) {
            $data = DB::select($sql, [$tgl_diterima, '%'.$search.'%', '%'.$search.'%']);
        } else {
            $data = DB::select($sql, [$tgl_diterima]);
        }
        $data_count = DB::select($sql_count);

        $result = array();
        $num = $start > 0 ? $start + 1 : 1;
        $no = $num > 0 ? $num : 1;
        foreach ($data as $row) {
            $item = (object) [
                'no' => $no++,
                'kode'  => $row->kode,
                'nama'  => $row->nama,
                'jumlah'  => $row->jumlah
            ];
            array_push($result, $item);
        }

        return [
            'data' => $result,
            'count' => $data_count[0]->found,
        ];
    }

    public function get_statistik($bulan, $tahun) {
        $bulan = sprintf("%02d", $bulan);
        $tgl_diterima = $tahun.'-'.$bulan;

        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT k.id, k.kode, k.nama, k.uraian, count(k.id) jumlah
                FROM t_surat_masuk m JOIN ref_klasifikasi".$table." k ON m.id_klasifikasi=k.id
                WHERE LEFT(m.tgl_diterima, 7)=? GROUP BY k.id, k.kode, k.nama, k.uraian ORDER BY k.kode";
        $data = DB::select($sql, [$tgl_diterima]);

        return $data;
    }

    public function get_jumlah_surat($tahun) {
        $sql = "SELECT MONTH(tgl_diterima) bulan, COUNT(id) jumlah FROM t_surat_masuk
                WHERE YEAR(tgl_diterima)=? AND sifat_surat < 3
                GROUP BY MONTH(tgl_diterima) ORDER BY MONTH(tgl_diterima)";
        $data = DB::select($sql, [$tahun]);
        return $data;
    }

    public function get_jumlah_surat_rhs($tahun) {
        $sql = "SELECT MONTH(tgl_diterima) bulan, COUNT(id) jumlah FROM t_surat_masuk
                WHERE YEAR(tgl_diterima)=? AND sifat_surat > 2
                GROUP BY MONTH(tgl_diterima) ORDER BY MONTH(tgl_diterima)";
        $data = DB::select($sql, [$tahun]);
        return $data;
    }

    public function get_stat_parent($bulan, $tahun) {
        $bulan = sprintf("%02d", $bulan);
        $tgl_diterima = $tahun.'-'.$bulan;
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT parent, SUM(jumlah) jumlah FROM (
            SELECT k.id, p.kode parent, k.kode, k.nama, k.uraian, count(k.id) jumlah
            FROM t_surat_masuk m JOIN ref_klasifikasi".$table." k ON m.id_klasifikasi=k.id
            JOIN ref_klasifikasi".$table." p ON k.parent_id=p.id
            WHERE LEFT(m.tgl_diterima, 7)=? AND sifat_surat < 3
            GROUP BY k.id, k.kode, k.nama, k.uraian, p.kode
            ) A GROUP BY parent ORDER BY parent";
        $data = DB::select($sql, [$tgl_diterima]);

        return $data;
    }
    public function get_stat_parent_rhs($bulan, $tahun) {
        $bulan = sprintf("%02d", $bulan);
        $tgl_diterima = $tahun.'-'.$bulan;
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT parent, SUM(jumlah) jumlah FROM (
            SELECT k.id, p.kode parent, k.kode, k.nama, k.uraian, count(k.id) jumlah
            FROM t_surat_masuk m JOIN ref_klasifikasi".$table." k ON m.id_klasifikasi=k.id
            JOIN ref_klasifikasi".$table." p ON k.parent_id=p.id
            WHERE LEFT(m.tgl_diterima, 7)=? AND sifat_surat > 2
            GROUP BY k.id, k.kode, k.nama, k.uraian, p.kode
            ) A GROUP BY parent ORDER BY parent";
        $data = DB::select($sql, [$tgl_diterima]);

        return $data;
    }
    public function lacak_public($no_surat) {
        $sql = "SELECT id, no_surat, tgl_diterima, dari, isi_ringkas, sifat_surat
                FROM t_surat_masuk WHERE no_surat LIKE ?";
        $q_surat_masuk = DB::select($sql, ['%'.$no_surat.'%']);

        $surat_masuk = array();
        $disposisi = array();
        if ($q_surat_masuk) {
            $item = $q_surat_masuk[0];
            $surat_masuk = (object) ([
                'no_surat'     => $item->no_surat,
                'tgl_diterima' => date('d F Y', strtotime($item->tgl_diterima)),
                'dari'         => $item->dari,
                'isi_ringkas'  => $item->isi_ringkas,
                'sifat_surat'  => $item->sifat_surat,
            ]);

            $disposisi = $this->get_disposisi_surat($item->id);
        }

        return ([
            'surat_masuk' => $surat_masuk,
            'disposisi' => $disposisi,
        ]);
    }
    public function get_data_surat($id_surat) {
        date_default_timezone_set("Asia/Bangkok");
        $surat = DB::table('t_surat_masuk')
            ->join('users', 'users.nip', '=', 't_surat_masuk.user_id')
            ->select('t_surat_masuk.*', 'users.nip', 'users.name')
            ->where('t_surat_masuk.id', $id_surat)
            ->first();

        switch ($surat->sifat_surat) {
            case '1':
                $surat->sifat_surat = "Biasa";
                break;
            case '2':
                $surat->sifat_surat = "Penting";
                break;
            case '3':
                $surat->sifat_surat = "Rahasia (Pengaduan)";
                break;
            case '4':
                $surat->sifat_surat = "Rahasia (Kepegawaian)";
                break;
            case '5':
                $surat->sifat_surat = "Rahasia (Perkara Banding)";
                break;
            default:
                break;
        }

        return $surat;
    }
    public function posisi_surat($id_surat) {
        $data = DisposisiModel::where('id_surat_masuk', $id_surat)->orderByDesc('id')->first();
        $nip = $data->disposisi_kepada;
        if ($data->plh) {
            $nip = $data->plh;
        }
        $user = User::where('nip', $nip)->first();
        return $user->name;
    }

    public function get_arsip_ajax($request, $origin=null) {
        $tahun = session()->get('tahun_anggaran');
        $search = $request->input('search.value');
        $length = ($request->length) ? $request->length : 10;
        $start = ($request->start) ? $request->start : 0;


        $sql = "SELECT id, no_agenda, no_surat, file, jenis_arsip, lokasi_arsip FROM t_surat_masuk
                WHERE arsipkan=1";
                // sifat_surat: 1=biasa,2=penting,3=rhs pengaduan,4=rhs kepeg,5=rhs banding

        // 1=admin,2=user,3=super user,4=operator,5=ajudan
        if (Auth::user()->role==2 || Auth::user()->role==4 || Auth::user()->role==5) {
            $sql .= " AND sifat_surat < 3";
        }

        if ($origin != '*') {
            if ($search) { // jika datatable mengirimkan pencarian dengan metode POST
                $sql .= " AND (no_agenda like '%" . $search . "%'
                          OR no_surat like '%" . $search . "%'
                          OR jenis_arsip like '%" . $search . "%'
                          OR lokasi_arsip like '%" . $search . "%')";
            }
        }

        $sql .= " ORDER BY no_agenda DESC";

        if ($origin == null) {
            if ($length != -1) {
                $sql .= " LIMIT " . $length . " OFFSET " . $start;
            }
        }

        $data = DB::select($sql);
        // if ($origin == null) {
        //     foreach ($data as $row) {
        //         $row->belum_selesai_8_jam = $this->get_waktu_proses($row->id);
        //         $row->posisi = $this->posisi_surat($row->id);
        //     }
        // }
        return $data;
    }

    public function get_data_ajax_search($request, $origin=null) {
        $search = $request->input('search');
        $tgl_awal = $request->input('tgl_awal') ? date('Y-m-d', strtotime($request->input('tgl_awal'))) : null;
        $tgl_akhir = $request->input('tgl_akhir') ? date('Y-m-d', strtotime($request->input('tgl_akhir'))) : null;

        $length = ($request->length) ? $request->length : 10;
        $start = ($request->start) ? $request->start : 0;
        $nip = Auth::user()->nip;

        $sql = "SELECT * FROM t_surat_masuk";

        if ($origin != '*') {
            $sql .= " WHERE (isi_ringkas like '%" . $search . "%'
                      OR no_agenda like '%" . $search . "%'
                      OR dari like '%" . $search . "%'
                      OR dari like '%" . $search . "%'
                      OR no_surat like '%" . $search . "%')";
	    
	    if ($tgl_awal != null) {
                if ($tgl_akhir != null) {
                    $sql .= " AND tgl_surat BETWEEN '" . $tgl_awal . "' AND '" . $tgl_akhir . "'";
                } else {
                    $sql .= " AND tgl_surat='" . $tgl_awal . "'";
                }
            }
        }
        $sql .= " ORDER BY no_agenda DESC";

        if ($origin == null) {
            if ($length != -1) {
                $sql .= " LIMIT " . $length . " OFFSET " . $start;
            }
        }

        try {
            $data = DB::select($sql);
            if ($origin == null) {
                foreach ($data as $row) {
                    $row->belum_selesai_8_jam = $this->get_waktu_proses($row->id);
                    $row->posisi = $this->posisi_surat($row->id);
                }
            }
            return $data;
        } catch (\Exception $ex) {
            // dd($ex->getMessage());
        }
    }
}
