<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuratkeluarModel extends Model
{
    use HasFactory;
    protected $table = 't_surat_keluar';
    protected $fillable = [
        'id',
        'no_agenda',
        'id_klasifikasi',
        'klasifikasi',
        'nomor_surat',
        'tujuan_surat',
        'sifat_surat',
        'tanggal_surat',
        'isi_ringkas',
        'nama_penerima',
        'jabatan_penerima',
        'tahun_anggaran',
        'file',
        'penandatangan_surat',
        'jabatan_penandatangan_surat',
        'user_input',
        'user_update',
        'deleted',
    ];

    public function get_data($tahun) {
        $data = DB::table('t_surat_keluar')->select('t_surat_keluar.*')
                ->where('deleted','=',0)->where('sifat_surat','<','3')
                ->where('tahun_anggaran','=',$tahun)
                ->latest('no_agenda')
                ->latest('tanggal_surat')->get();
        return $data;
    }

    public function get_data_ajax($request, $origin=null) {
        $tahun = session()->get('tahun_anggaran');
        $search = $request->input('search.value');
        $length = ($request->length) ? $request->length : 10;
        $start = ($request->start) ? $request->start : 0;

        $sql = "SELECT * FROM t_surat_keluar
                WHERE deleted = 0 AND sifat_surat < 3
                AND tahun_anggaran = $tahun";

        if ($origin != '*') {   
            if ($search) { // jika datatable mengirimkan pencarian dengan metode POST
                $sql .= " AND (isi_ringkas LIKE '%" . $search . "%'
                          OR tujuan_surat LIKE '%" . $search . "%'
                          OR nomor_surat LIKE '%" . $search . "%'
                          OR tanggal_surat LIKE '%" . $search . "%')";
            }
        }

        $sql .= " ORDER BY no_agenda DESC, tanggal_surat DESC";

        if ($origin == null) {
            if ($length != -1) {
                $sql .= " LIMIT " . $length . " OFFSET " . $start;
            }
        }

        $data = DB::select($sql);
        return $data;
    }

    public function get_data_rhs($tahun) {
        $data = DB::table('t_surat_keluar')->select('t_surat_keluar.*')
                ->where('deleted','=',0)->where('sifat_surat','>','2')
                ->where('tahun_anggaran','=',$tahun)
                ->latest('tanggal_surat')->get();
        return $data;
    }

    public function get_statistik($bulan, $tahun) {
        $bulan = sprintf("%02d", $bulan);
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT k.id, k.kode, k.nama, k.uraian, count(k.id) jumlah
                FROM t_surat_keluar".$table." sk JOIN ref_klasifikasi".$table." k ON sk.id_klasifikasi=k.id
                WHERE LEFT(sk.tanggal_surat, 7)=? GROUP BY k.id, k.kode, k.nama, k.uraian ORDER BY k.id";
        $tgl_surat = $tahun.'-'.$bulan;
        $data = DB::select($sql, [$tgl_surat]);
        return $data;
    }

    public function get_statistik_penetapan($bulan, $tahun) {
        $bulan = sprintf("%02d", $bulan);
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT sk.kode_penetapan, count(sk.kode_penetapan) jumlah
                FROM t_surat_keluar".$table." sk JOIN ref_klasifikasi".$table." k ON sk.id_klasifikasi=k.id
                WHERE LEFT(sk.tanggal_surat, 7)=? GROUP BY sk.kode_penetapan ORDER BY sk.kode_penetapan";
        $tgl_surat = $tahun.'-'.$bulan;
        $data = DB::select($sql, [$tgl_surat]);
        return $data;
    }
    
    public function get_statistik_jabatan($bulan, $tahun) {
        $bulan = sprintf("%02d", $bulan);
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT sk.kode_penetapan, count(sk.kode_penetapan) jumlah
                FROM t_surat_keluar".$table." sk JOIN ref_klasifikasi".$table." k ON sk.id_klasifikasi=k.id
                WHERE LEFT(sk.tanggal_surat, 7)=? GROUP BY sk.kode_penetapan ORDER BY sk.kode_penetapan";
        $tgl_surat = $tahun.'-'.$bulan;
        $data = DB::select($sql, [$tgl_surat]);
        return $data;
    }

    public function get_jumlah_surat($tahun) {
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT MONTH(tanggal_surat) bulan, COUNT(id) jumlah FROM t_surat_keluar".$table."
                WHERE YEAR(tanggal_surat)=? AND sifat_surat < 3
                GROUP BY MONTH(tanggal_surat) ORDER BY MONTH(tanggal_surat)";
        $data = DB::select($sql, [$tahun]);
        return $data;
    }
    public function get_jumlah_surat_rhs($tahun) {
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT MONTH(tanggal_surat) bulan, COUNT(id) jumlah FROM t_surat_keluar".$table."
                WHERE YEAR(tanggal_surat)=? AND sifat_surat > 2
                GROUP BY MONTH(tanggal_surat) ORDER BY MONTH(tanggal_surat)";
        $data = DB::select($sql, [$tahun]);
        return $data;
    }

    public function get_statistik_parent($bulan, $tahun) {
        $bulan = sprintf("%02d", $bulan);
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT parent, SUM(jumlah) jumlah FROM (
                    SELECT k.id, p.kode parent, k.kode, k.nama, k.uraian, count(k.id) jumlah
                    FROM t_surat_keluar".$table." sk JOIN ref_klasifikasi".$table." k ON sk.id_klasifikasi=k.id
                    JOIN ref_klasifikasi".$table." p ON k.parent_id=p.id 
                    WHERE LEFT(sk.tanggal_surat, 7)=? AND sifat_surat < 3
                    GROUP BY k.id, k.kode, k.nama, k.uraian, p.kode
                ) A  GROUP BY parent ORDER BY kode";
        $tgl_surat = $tahun.'-'.$bulan;
        $data = DB::select($sql, [$tgl_surat]);
        return $data;
    }
    public function get_statistik_parent_rhs($bulan, $tahun) {
        $bulan = sprintf("%02d", $bulan);
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        $sql = "SELECT parent, SUM(jumlah) jumlah FROM (
                    SELECT k.id, p.kode parent, k.kode, k.nama, k.uraian, count(k.id) jumlah
                    FROM t_surat_keluar".$table." sk JOIN ref_klasifikasi".$table." k ON sk.id_klasifikasi=k.id
                    JOIN ref_klasifikasi".$table." p ON k.parent_id=p.id 
                    WHERE LEFT(sk.tanggal_surat, 7)=? AND sifat_surat > 2
                    GROUP BY k.id, k.kode, k.nama, k.uraian, p.kode
                ) A  GROUP BY parent ORDER BY kode";
        $tgl_surat = $tahun.'-'.$bulan;
        $data = DB::select($sql, [$tgl_surat]);
        return $data;
    }
}
