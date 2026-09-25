<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'name',
        'email',
        'password',
        'foto',
        'role',
        'id_jabatan',
        'no_hp',
        'active',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function get_data() {
        $data = DB::table('users AS u')
                ->join('t_jabatan AS j', 'u.id_jabatan', '=', 'j.id')
                ->join('role AS r', 'u.role', '=', 'r.id')
                ->select(['u.id', 'u.nip', 'u.name', 'u.email', 'j.nama_jabatan', 'r.name AS role'])
                ->where('active', '=', 1)->orderBy('u.urutan')->orderBy('j.level')->orderBy('j.bagian')->orderBy('j.id')->get();
        return $data;
    }
}
