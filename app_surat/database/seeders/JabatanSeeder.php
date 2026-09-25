<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Ketua',
            'id_atasan' => '',
            'level' => '1',
            'bagian' => '0'
        ]);

        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Wakil Ketua',
            'id_atasan' => '1',
            'level' => '1',
            'bagian' => '0'
        ]);

        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Panitera',
            'id_atasan' => '1',
            'level' => '2',
            'bagian' => '1'
        ]);

        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Sekretaris',
            'id_atasan' => '1',
            'level' => '2',
            'bagian' => '2'
        ]);

        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Panitera Muda Hukum',
            'id_atasan' => '3',
            'level' => '3',
            'bagian' => '1'
        ]);

        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Panitera Muda Banding',
            'id_atasan' => '3',
            'level' => '3',
            'bagian' => '1'
        ]);

        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Kepala Bagian Perencanaan dan Kepegawaian',
            'id_atasan' => '4',
            'level' => '3',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Kepala Bagian Umum dan Keuangan',
            'id_atasan' => '4',
            'level' => '3',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Kepala Subbagian Kepegawaian dan TI',
            'id_atasan' => '7',
            'level' => '4',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Kepala Subbagian Rencana Program dan Anggaran',
            'id_atasan' => '7',
            'level' => '4',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Kepala Subbagian Tata Usaha dan Rumah Tangga',
            'id_atasan' => '8',
            'level' => '4',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Kepala Subbagian Keuangan dan Pelaporan',
            'id_atasan' => '8',
            'level' => '4',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Panitera Pengganti',
            'id_atasan' => '3',
            'level' => '4',
            'bagian' => '1'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Analis Tatalaksana',
            'id_atasan' => '9',
            'level' => '5',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Analis SDM Aparatur',
            'id_atasan' => '9',
            'level' => '5',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Bendahara',
            'id_atasan' => '12',
            'level' => '5',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Pengelola Akuntansi',
            'id_atasan' => '12',
            'level' => '5',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Penyusun Laporan Keuangan',
            'id_atasan' => '12',
            'level' => '5',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Analis Humas',
            'id_atasan' => '11',
            'level' => '5',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Pranata Komputer',
            'id_atasan' => '9',
            'level' => '5',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Pengelola BMN',
            'id_atasan' => '11',
            'level' => '5',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Analis Perkara Peradilan (Hukum)',
            'id_atasan' => '5',
            'level' => '5',
            'bagian' => '1'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Analis Perkara Peradilan (Banding)',
            'id_atasan' => '6',
            'level' => '5',
            'bagian' => '1'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Pengelola Perkara (Banding)',
            'id_atasan' => '6',
            'level' => '5',
            'bagian' => '1'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Pustakawan',
            'id_atasan' => '8',
            'level' => '4',
            'bagian' => '2'
        ]);
        DB::table('t_jabatan')->insert([
            'nama_jabatan' => 'Hakim Tinggi',
            'id_atasan' => '1',
            'level' => '2',
            'bagian' => '3'
        ]);
    }
}
