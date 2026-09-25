<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('users')->insert([
            'name' => 'Dr. H. SAMPARAJA, S.H., M.H.',
            'nip' => '195604061984031002',
            'email' => 'samparajanompo626@gmail.com',
            'role' => '2',
            'id_jabatan' => '1',
            'password' => Hash::make('195604061984031002'),
            'no_hp' => '081233086261'
        ]);
        DB::table('users')->insert([
            'name' => 'Drs. H. PAHRI HAMIDI, S.H.',
            'nip' => '196304081987031002',
            'email' => 'pahrihamidi63@gmail.com',
            'role' => '2',
            'id_jabatan' => '3',
            'password' => Hash::make('196304081987031002'),
            'no_hp' => '08127356922'
        ]);
        DB::table('users')->insert([
            'name' => 'MUHAMMAD TAUFIQURRAHMAN, S.Ag., M.H.',
            'nip' => '197311081999031002',
            'email' => 'taufiqurrahman73@yahoo.co.id',
            'role' => '2',
            'id_jabatan' => '4',
            'password' => Hash::make('197311081999031002'),
            'no_hp' => '085240258624'
        ]);
        DB::table('users')->insert([
            'name' => 'RUSTANDI, S.Ag.',
            'nip' => '196908171995031001',
            'email' => 'rustandiajah@gmail.com',
            'role' => '2',
            'id_jabatan' => '7',
            'password' => Hash::make('196908171995031001'),
            'no_hp' => '081322858709'
        ]);
        DB::table('users')->insert([
            'name' => 'NURMANSYAH, S.Ag.',
            'nip' => '197205101997031003 ',
            'email' => 'syah03686@gmail.com',
            'role' => '2',
            'id_jabatan' => '8',
            'password' => Hash::make('197205101997031003'),
            'no_hp' => '081222138949'
        ]);
        DB::table('users')->insert([
            'nip' => '198512282011011009',
            'name' => 'Faridl Muzaky',
            'email' => 'f4ridl.m@gmail.com',
            'password' => Hash::make('198512282011011009'),
            'role' => '1',
            'id_jabatan' => '9',
            'no_hp' => ''
        ]);
        DB::table('users')->insert([
            'name' => 'REZA M SAJIDIN, S.Sy.',
            'nip' => '198104082009041002',
            'email' => 'fliptopz@gmail.com',
            'role' => '1',
            'id_jabatan' => '11',
            'password' => Hash::make('198104082009041002'),
            'no_hp' => '087823744484'
        ]);

        DB::table('users')->insert([
            'name' => 'MEILA AULIA, S.H.',
            'nip' => '199011242014022001',
            'email' => 'meilaaulia.fh08@gmail.com',
            'role' => '3',
            'id_jabatan' => '14',
            'password' => Hash::make('199011242014022001'),
            'no_hp' => '081224266351'
        ]);
    }
}
