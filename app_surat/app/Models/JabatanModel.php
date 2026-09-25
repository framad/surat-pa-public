<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JabatanModel extends Model
{
    use HasFactory;
    protected $table = 't_jabatan';
    protected $fillable = [
        'nama_jabatan',
        'id_atasan',
        'level',
        'bagian',
        'created_at',
        'updated_at',
    ];

    public function get_jabatan() {
        $jabatan = JabatanModel::all();
        return $jabatan;
    }
}
