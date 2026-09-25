<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\JabatanModel;
use App\Models\RoleModel;
use Illuminate\Support\Facades\Hash;
use App\Models\SuratkeluarModel;
use App\Models\KlasifikasiModel;
use App\Services\PayUService\Exception;

class UserController extends Controller
{
    protected $user_model;
    protected $jabatan_model;
    protected $role_model;
    public function __construct(
        User $usr_model,
        JabatanModel $j_model,
        RoleModel $role
    ) {
        $this->user_model = $usr_model;
        $this->jabatan_model = $j_model;
        $this->role_model = $role;
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $role_id = auth::user()->role;
        if ($role_id==2 || $role_id==3) {
            return redirect('/dashboard');
        }
        $data = $this->user_model->get_data();
        return view('user.index', ([
            'data' => $data,
        ]));
    }

    public function create()
    {
        $jabatan = $this->jabatan_model->get_jabatan();
        $role = $this->role_model->get_role();
        return view('user.tambah', [
            'jabatan' => $jabatan,
            'role' => $role,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'Required',
                'email' => 'Required',
                'nip' => 'Required|unique:App\Models\User,nip',
                'password' => 'Required',
                'no_hp' => 'Required|numeric',
                'id_jabatan' => 'Required',
                'id_role' => 'Required',
            ],
            [
                'nip.unique' => 'Username Sudah Ada',
                'no_hp.numeric' => 'Nomor Handphone Harus Berupa Angka',
                'id_jabatan.required' => 'Jabatan Belum Dipilih',
                'id_role.required' => 'Hak Akses Belum Dipilih',
            ]
        );


        try {
            $name = $request->name;
            $email = $request->email;
            $nip = $request->nip;
            $no_hp = $request->no_hp;
            $id_jabatan = $request->id_jabatan;
            $id_role = $request->id_role;
            $password = Hash::make($request->password);

            User::create([
                'nip' => $nip,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $id_role,
                'id_jabatan' => $id_jabatan,
                'no_hp' => $no_hp,
                'created_at' => date("Y-m-d h:i:s a"),
                // 'updated_at' => NULL,
            ]);

            return redirect('/users')->with('status', 'Data Pengguna Baru Berhasil Disimpan');
        } catch (\Exception $e) {
            // dd($e);
            $error = $e->getMessage();
            $code = $e->getCode();
            if ($code==23000) {
                $error = "Username / NIP Pengguna tidak boleh sama";
            }
            return redirect('/users')->with('error', $error);
        }
    }

    public function edit($id)
    {
        $data = User::find($id);
        $jabatan = $this->jabatan_model->get_jabatan();
        $role = $this->role_model->get_role();
        return view('user.edit', ([
            'user' => $data,
            'jabatan' => $jabatan,
            'role' => $role,
        ]));
    }

    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'Required',
                'email' => 'Required',
                // 'nip' => 'Required|unique:users,nip,'.$request->id,
                'nip' => 'Required',
                'no_hp' => 'Required|numeric',
                'id_jabatan' => 'Required',
                'id_role' => 'Required',
            ],
            [
                'nip.required' => 'Username Belum Diisi',
                'nip.unique' => 'Username Sudah Ada',
                'no_hp.numeric' => 'Nomor Handphone Harus Berupa Angka',
                'id_jabatan.required' => 'Jabatan Belum Dipilih',
                'id_role.required' => 'Hak Akses Belum Dipilih',
            ]
        );

        try {
            $user = User::find($request->id);
            $password = $request->password ? Hash::make($request->password) : $user->password;

            $object = ([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'nip' => $request->nip,
                'no_hp' => $request->no_hp,
                'id_jabatan' => $request->id_jabatan,
                'role' => $request->id_role,
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $user->update($object);

            return redirect('/users')->with('status', 'Data pengguna berhasil diubah');
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return redirect('/users')->with('error', $error);
        }
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id_user);
        $user->update([
            'active'     => 0,
            'password'   => '',
            'updated_at' => date("Y-m-d h:i:s a"),
        ]);
        return redirect('/users')->with('status', 'Data pengguna berhasil dihapus');
    }
}
