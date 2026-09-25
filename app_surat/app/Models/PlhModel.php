<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlhModel extends Model
{
    use HasFactory;
    protected $table = 't_plh';
    protected $fillable = [
        'id',
        'nip',
        'id_jabatan',
        'tanggal_awal',
        'tanggal_akhir',
        'user_input',
        'user_update',
        'created_at',
        'updated_at',
    ];

    public function get_data() {
        $data = DB::table('t_plh')
                ->join('users', 't_plh.nip', '=', 'users.nip')
                ->join('t_jabatan', 't_plh.id_jabatan', '=', 't_jabatan.id')
                ->select('users.name', 't_jabatan.nama_jabatan', 't_plh.*')
                ->orderBy('id', 'DESC')
                ->get();
        return $data;
    }

    public function get_plh($nip) {
        $user = DB::table('users')
            ->select('id_jabatan')
            ->where('nip', $nip)
            ->first();

        $plh = DB::table('t_plh')
            ->join('users', 't_plh.nip', '=', 'users.nip')
            ->select('users.nip', 'users.name', 'users.role', 'users.id_jabatan')
            ->where('t_plh.id_jabatan', $user->id_jabatan)
            ->where('tanggal_awal', '<=', date('Y-m-d'))
            ->where('tanggal_akhir', '>=', date('Y-m-d'))
            ->first();
        
        return $plh;
    }

    public function get_atasan() {
        $jabatan = DB::table('users')
            ->join('t_jabatan', 'users.id_jabatan', '=', 't_jabatan.id')
            ->select('t_jabatan.id AS id_jabatan', 'users.id AS id_atasan', 'users.nip', 'users.name', 't_jabatan.nama_jabatan', 't_jabatan.bagian', 't_jabatan.level')
            ->where('t_jabatan.level', '<=', '4')
            ->orderBy('t_jabatan.level')
            ->orderBy('t_jabatan.bagian')
            ->orderBy('t_jabatan.id')
            ->get();
        
        return $jabatan;
    }
    
    public function get_jabatan_delegasi($tgl_awal) {
        $sql = "SELECT u.id_jabatan, u.id AS id_atasan, u.nip, u.name, j.nama_jabatan, 
                j.bagian, j.level FROM users u JOIN t_jabatan j ON u.id_jabatan=j.id
                WHERE j.level <= 4 AND j.id NOT IN (
                    SELECT id_jabatan FROM t_plh 
                    WHERE tanggal_akhir >= ?
                    AND tanggal_awal <= ?
                ) ORDER BY j.level, j.bagian, j.id";
                
        $data = DB::select($sql, [$tgl_awal, $tgl_awal]);
        return $data;
    }

    // public function recursif_get_bawahan($data) {
    //     $array_pegawai = array();

    //     foreach ($data as $row) {
    //         $user = DB::select('select u.id, u.name, j.id id_jabatan, j.nama_jabatan, j.id_atasan 
    //                 from users u join t_jabatan j on u.id_jabatan=j.id where j.id_atasan=?', [$row->id_jabatan]);

    //         foreach ($user as $item) {
    //             array_push($array_pegawai, $item);

    //             $child = $this->recursif_get_bawahan($item->id_jabatan, $item);
    //             // array_merge($array_pegawai, $child);
    //             // array_push($array_pegawai, $item);
    //         }
    //     }

    //     return $array_pegawai;
    // }

    function getOneLevel($id_jabatan, $bagian) {
        $user = DB::select("select u.id, u.name, u.nip, j.id id_jabatan, j.nama_jabatan, j.id_atasan 
                            from users u join t_jabatan j on u.id_jabatan=j.id 
                            where j.id_atasan=? and bagian=?", [$id_jabatan, $bagian]);
                            
        // $exclude_jabatan = DB::select("SELECT id_jabatan FROM t_plh 
        //                                WHERE tanggal_akhir >= '".date('Y-m-d')."'
        //                                AND tanggal_awal <= ?", [$tanggal_awal]);

        $users = array();
        $users = array_merge($users,$user);
        return $users;
    }
    function getChildren($id_jabatan, $bagian, $result) {
        $users = array();
        $users = $this->getOneLevel($id_jabatan, $bagian);

        if(count($users)>0 && is_array($users)){
            $result = array_unique(array_merge($result, $users), SORT_REGULAR);
        }
        foreach ($users as $row) {
            $child = $this->getChildren($row->id_jabatan, $bagian, $result);
            $result = array_unique(array_merge($result, $child), SORT_REGULAR);
        }
        return $result;
    }

    function exclude_jabatan_plh($tanggal_awal) {
        $exclude_jabatan = DB::select("SELECT id_jabatan, nip FROM t_plh 
                                       WHERE tanggal_akhir >= ?
                                       AND tanggal_awal <= ?", [$tanggal_awal, $tanggal_awal]);
        $arr_jabatan = array();
        $arr_nip = array();
        foreach ($exclude_jabatan as $row) {
            array_push($arr_jabatan, $row->id_jabatan);
            array_push($arr_nip, $row->nip);
        }
        return [
            'jabatan' => $arr_jabatan,
            'nip' => $arr_nip,
        ];
    }
}
