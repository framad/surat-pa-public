<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DisposisiModel extends Model
{
    use HasFactory;
    protected $table = 't_disposisi';
    protected $fillable = [
        'id',
        'id_surat_masuk',
        'disposisi_oleh',
        'disposisi_kepada',
        'plh',
        'isi_disposisi',
        'catatan_disposisi',
        'jenis',
        'tindaklanjut',
        'arsipkan',
        'teruskan',
        'created_at',
        'updated_at'
    ];

    public function get_pegawai_disposisi_pengaduan() {
        $pegawai = DB::table('users')
            ->join('t_jabatan', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('users.*', 't_jabatan.nama_jabatan', 't_jabatan.bagian')
            ->where([['users.nip', '<>', Auth::user()->nip]])
            ->where('pengaduan','1')
            ->orderBy('users.urutan')
            ->orderBy('users.id')
            ->get();
        
        return $pegawai;
    }

    public function get_pegawai_disposisi($id_disposisi) {
        $bawahan = $this->get_bawahan($id_disposisi);
        // plh
        $pegawai = DB::table('users')
            ->join('t_jabatan', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('users.*', 't_jabatan.nama_jabatan', 't_jabatan.bagian')
            ->where([['users.nip', '<>', Auth::user()->nip]])
            ->where('users.active', '=', '1')
            ->whereIn('t_jabatan.id', $bawahan)
            ->orderBy('users.urutan')
            ->orderBy('users.id')
            ->get();
        
        return $pegawai;
    }

    public function get_bawahan($id_disposisi) {
        // $id_jabatan = Auth::user()->id_jabatan;
        // if ($id_jabatan==2) { // 2=wakil
        //     $id_jabatan = 1;  // 1=ketua
        // }
        // $dispo = DB::select('SELECT disposisi_kepada, plh FROM t_disposisi WHERE id=? AND plh IS NOT NULL',[$id_disposisi]);
        // if ($dispo) {
        //     $user = DB::table('users')->select('id_jabatan')->where('nip','=',$dispo[0]->disposisi_kepada)->first();
        //     $id_jabatan = $user ? $user->id_jabatan : $id_jabatan;
        // }
        // // dd($dispo);
        // $query = DB::table('t_jabatan')
        //             ->select('id')
        //             ->where('id_atasan','=',$id_jabatan)
        //             ->where('disposisi','=',1)
        //             ->get();
        // $bawahan = array();
        // foreach ($query as $row) {
        //     array_push($bawahan, $row->id);
        // }
        // return $bawahan;

        $bawahan = array();
        $id_jabatan = Auth::user()->id_jabatan;
        
        if ($id_jabatan==2) { // 2=wakil
            $id_jabatan = 1;  // 1=ketua
        }

        // jabatan se level
        $user_level = DB::table('t_jabatan')
            ->join('users', 't_jabatan.id', '=', 'users.id_jabatan')
            ->select('t_jabatan.level', 't_jabatan.bagian')
            ->where('users.nip', Auth::user()->nip)
            ->first();
        if ($user_level->level <= 4) {
            if ($user_level->level == 2) {
                $jabatan_level = DB::table('t_jabatan')
                    ->select('id')
                    ->where('level','=',$user_level->level)
                    ->where('bagian','!=',0)
                    ->get();
            } else {
                $jabatan_level = DB::table('t_jabatan')
                    ->select('id')
                    ->where('level','=',$user_level->level)
                    ->where('bagian','=',$user_level->bagian)
                    ->get();
            }
            foreach ($jabatan_level as $row) {
                array_push($bawahan, $row->id);
            }
        }

        // cari bawahan plh
        $dispo = DB::select('SELECT disposisi_kepada, plh FROM t_disposisi WHERE id=? AND plh IS NOT NULL',[$id_disposisi]);
        if ($dispo) {
            if (isset($dispo[0]->plh)) {
                $query = DB::table('t_jabatan')
                    ->select('id')
                    ->where('id_atasan','=',$id_jabatan)
                    ->where('disposisi','=',1)
                    ->get();
                foreach ($query as $row) {
                    array_push($bawahan, $row->id);
                }
            }
            $user = DB::table('users')->select('id_jabatan')->where('nip','=',$dispo[0]->disposisi_kepada)->first();
            $id_jabatan = $user ? $user->id_jabatan : $id_jabatan;
        }

        // bawahan
        $query = DB::table('t_jabatan')
                    ->select('id')
                    ->where('id_atasan','=',$id_jabatan)
                    ->where('disposisi','=',1)
                    ->get();
        foreach ($query as $row) {
            array_push($bawahan, $row->id);
        }

	// if sekretaris, ini sementara, sampe kabag perencanaan ada
        if ($id_jabatan == 4) {
            // tambahin semua kasub
            $query = DB::table('t_jabatan')
                    ->select('id')
                    ->where('disposisi','=',1)
                    ->whereIn('id', [9,10,11,12])
                    ->get();
            foreach ($query as $row) {
                array_push($bawahan, $row->id);
            }
        }
        // end if sekretaris

        return $bawahan;
    }

    public function get_previous_disposisi($id_surat, $id_dispo) {
        $sql = "SELECT * FROM t_disposisi WHERE id_surat_masuk=? AND id<>? ORDER BY id DESC";
        $data = DB::select($sql, [$id_surat, $id_dispo]);
        return $data;
    }
}
