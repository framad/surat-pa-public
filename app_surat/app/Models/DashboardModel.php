<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardModel extends Model
{
    use HasFactory;

    public function get_dashboard_data() {
        $tanggal = date('Y-m');
        $nip = Auth::user()->nip;
        $role = Auth::user()->role;

        $tahun = date('Y');
        $table = "";
        if ($tahun > 2023) {
            $table = "_baru";
        }
        
        if ($role==5) { // role ajudan, cari nip atasan nya
            $atasan = DB::select("select u.id_jabatan, j.id_atasan, atasan.nip, atasan.name from users u join t_jabatan j on u.id_jabatan=j.id 
                                join users atasan on j.id_atasan=atasan.id_jabatan where u.nip=? and atasan.active=1", [$nip]);
            if ($atasan) {
                $nip = $atasan[0]->nip;
            }
        }
	    //dd($nip);

        $dashboard = DB::select("SELECT IFNULL(surat_masuk_user, '0') AS surat_masuk_user, total_surat_masuk, surat_masuk_bulan_ini,
                     IFNULL(surat_masuk_user_bulan_ini, '0') AS surat_masuk_user_bulan_ini, total_surat_keluar, surat_keluar_bulan_ini, 
                     IFNULL(disposisi_masuk, '0') AS disposisi_masuk FROM
                     (SELECT
                        (select count(*) from t_surat_masuk) total_surat_masuk,
                        (select count(*) from t_surat_masuk where LEFT(tgl_diterima, 7)=?) surat_masuk_bulan_ini,
                        (select count(*) from t_surat_keluar".$table." WHERE deleted=0) total_surat_keluar,
                        (select count(*) from t_surat_keluar".$table." WHERE LEFT(tanggal_surat, 7)=? and deleted=0) surat_keluar_bulan_ini,
                        (
                            -- (SELECT count(id_surat_masuk) FROM t_disposisi WHERE (disposisi_kepada=?) GROUP BY disposisi_kepada) +
                            -- (SELECT count(id_surat_masuk) FROM t_disposisi WHERE (plh=?) GROUP BY plh)
                            SELECT COUNT(*) FROM
                            (
                                SELECT id_surat_masuk, disposisi_kepada
                                FROM t_disposisi WHERE disposisi_kepada=? GROUP BY id_surat_masuk, disposisi_kepada
                                UNION
                                SELECT id_surat_masuk, plh AS disposisi_kepada
                                FROM t_disposisi WHERE plh=? GROUP BY id_surat_masuk, plh
                            ) A
                        ) surat_masuk_user,
                        (
                            -- (SELECT count(id) FROM t_disposisi WHERE disposisi_kepada=? AND LEFT(created_at, 7)=? GROUP BY disposisi_kepada) + 
                            -- (SELECT count(id) FROM t_disposisi WHERE plh=? AND LEFT(created_at, 7)=? GROUP BY disposisi_kepada)
                            SELECT COUNT(*) FROM
                            (
                                SELECT id_surat_masuk, disposisi_kepada
                                FROM t_disposisi WHERE disposisi_kepada=? AND LEFT(created_at, 7)=? GROUP BY id_surat_masuk, disposisi_kepada
                                UNION
                                SELECT id_surat_masuk, plh AS disposisi_kepada
                                FROM t_disposisi WHERE plh=? AND LEFT(created_at, 7)=? GROUP BY id_surat_masuk, plh
                            ) A
                        ) surat_masuk_user_bulan_ini,
                        (
                            -- select count(id) from t_disposisi where (disposisi_kepada=? OR plh=?) and teruskan IS NULL group by disposisi_kepada
                            SELECT COUNT(*) FROM
                            (
                                SELECT id_surat_masuk, disposisi_kepada FROM t_disposisi
                                JOIN t_surat_masuk on t_disposisi.id_surat_masuk=t_surat_masuk.id
                                WHERE disposisi_kepada=? AND teruskan IS NULL
                                GROUP BY id_surat_masuk, disposisi_kepada
                                UNION
                                SELECT id_surat_masuk, plh AS disposisi_kepada FROM t_disposisi 
                                WHERE plh=? AND teruskan IS NULL 
                                GROUP BY id_surat_masuk, plh
                            ) A
                        ) disposisi_masuk
                     ) dashboard", [$tanggal, $tanggal, $nip, $nip, $nip, $tanggal, $nip, $tanggal, $nip, $nip]);
        // $nip 
        // $tanggal
        return $dashboard;
    }
}
