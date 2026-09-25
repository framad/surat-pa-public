<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TembusanModel extends Model
{
    use HasFactory;
    protected $table = 't_tembusan';
    protected $fillable = [
        'id',
        'id_disposisi',
        'nip',
        'read',
        'created_at',
        'updated_at'
    ];
}
