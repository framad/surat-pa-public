<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SettingnosuratModel extends Model
{
    use HasFactory;
    protected $table = 't_setting_nomor';
    protected $fillable = [
        'id',
        'nama',
        'tahun',
        'nilai',
    ];
}