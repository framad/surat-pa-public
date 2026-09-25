<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiModel extends Model
{
    use HasFactory;
    protected $table = 'ref_klasifikasi';
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
        $klasifikasi = KlasifikasiModel::where('deleted','=','0')->get();
        return $klasifikasi;
    }
}
