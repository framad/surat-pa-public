<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasibaruModel extends Model
{
    use HasFactory;
    protected $table = 'ref_klasifikasi_baru';
    protected $fillable = [
        'id',
        'kode',
        'nama',
        'uraian',
        'deleted',
        'created_at',
        'updated_at'
    ];

    public function get_klasifikasi() {
        $klasifikasi = KlasifikasibaruModel::where('deleted','=','0')->get();
        return $klasifikasi;
    }
}
