<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratmasukController;
use App\Http\Controllers\SuratkeluarController;
use App\Http\Controllers\SuratkeluarbaruController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\PlhController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatistiksmController;
use App\Http\Controllers\StatistikskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuratmasuksearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', function () {
//     return view('layout.main');
// });


Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/auth', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/lacak_public', [SuratmasukController::class, 'lacak_public'])->name('lacak_public');
Route::get('/reload_captcha', [SuratmasukController::class, 'reload_captcha'])->name('reload_captcha');

Route::middleware(['auth'])->group(function () {
    // Route::post('/register', [LoginController::class, 'authenticate'])->name('authenticate');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); //->middleware(['auth', 'autologout']);
    Route::post('/logout', [loginController::class, 'logout'])->name('logout');

    Route::get('/sm_search', [SuratmasuksearchController::class, 'index'])->name('sm.cari');
    Route::get('/sm/search/ajax', [SuratmasuksearchController::class, 'get_data_ajax'])->name('sm_ajax_search');

    Route::get('/sm', [SuratmasukController::class, 'index'])->name('sm');
    Route::get('/sm_ajax', [SuratmasukController::class, 'get_data_ajax'])->name('sm_ajax');
    Route::get('/sm_rhs', [SuratmasukController::class, 'surat_rahasia'])->name('sm_rhs');
    Route::get('/catat_sm', [SuratmasukController::class, 'create'])->name('catat_sm');
    Route::post('/catat_sm', [SuratmasukController::class, 'store'])->name('simpan_sm');
    Route::get('/catat_sm/{rhs}', [SuratmasukController::class, 'create'])->name('catat_sm_rhs');
    Route::get('/sm/{id}/cetak', [SuratmasukController::class, 'cetak_tanda'])->name('cetak_tanda');
    Route::get('/sm/{id}/edit', [SuratmasukController::class, 'edit'])->name('edit_sm');
    Route::post('/sm/{id}/update', [SuratmasukController::class, 'update'])->name('update_sm');
    //Route::get('/sm/{id}/hapus', [SuratmasukController::class, 'destroy'])->name('hapus_sm');
    Route::post('hapus_sm', [SuratmasukController::class, 'destroy']);
    Route::get('/sm/{id}/lacak', [SuratmasukController::class, 'lacak'])->name('lacak_sm');
    Route::get('/sm_register', [SuratmasukController::class, 'buku_induk']);
    Route::get('/sm_register_export/{bulan}/{tahun}', [SuratmasukController::class, 'buku_induk_export']);
    Route::get('/sm_register_export/{bulan}/{tahun}/{rhs}', [SuratmasukController::class, 'buku_induk_export']);
    Route::get('/sm_send_wa/{id}', [SuratmasukController::class, 'send_wa']);
    Route::post('/sm/arsipkan', [SuratmasukController::class, 'arsipkan']);
    Route::get('/arsip', [SuratmasukController::class, 'arsip'])->name('arsip');
    Route::get('/arsip_ajax', [SuratmasukController::class, 'get_arsip_ajax'])->name('arsip_ajax');

    Route::get('/cetak_disposisi/{id}', [SuratmasukController::class, 'cetak_disposisi'])->name('cetak_disposisi');

    Route::get('/disposisi', [DisposisiController::class, 'index'])->name('disposisi');
    Route::post('/disposisi/teruskan/{id}', [DisposisiController::class, 'teruskan'])->name('teruskan');
    Route::post('/disposisi/teruskanDisposisi', [DisposisiController::class, 'teruskanDisposisi'])->name('teruskanDisposisi');
    Route::post('/disposisi/hapusDisposisi', [DisposisiController::class, 'hapusDisposisi'])->name('hapusDisposisi');
    Route::post('/disposisi/updateSifatSurat/{id}', [DisposisiController::class, 'updateSifatSurat'])->name('updateSifatSurat');
    Route::get('/disposisi/{id_surat}/{id}', [DisposisiController::class, 'show'])->name('lihat_disposisi');
    Route::get('/disposisi/create/{id_surat}/{id}', [DisposisiController::class, 'create'])->name('buat_disposisi');
    Route::post('/disposisi/store', [DisposisiController::class, 'store_ajax'])->name('simpan_disposisi');
    Route::get('/disposisi_view/{id}', [DisposisiController::class, 'view'])->name('lihat_surat');
    Route::post('/disposisi_tindaklanjut/{id}', [DisposisiController::class, 'tindak_lanjut'])->name('tindak_lanjut');

    Route::get('/disposisi/monitoring', [DisposisiController::class, 'monitoring']);
    Route::get('/disposisi_export/{bulan}/{tahun}', [DisposisiController::class, 'monitoring_export']);

    Route::get('/surat_keluar', [SuratkeluarController::class, 'index'])->name('surat_keluar');
    Route::get('/sk_ajax', [SuratkeluarController::class, 'get_data_ajax'])->name('sk_ajax');
    Route::get('/surat_keluar_rhs', [SuratkeluarController::class, 'surat_rahasia'])->name('surat_keluar_rhs');
    Route::get('/catat_sk', [SuratkeluarController::class, 'create'])->name('catat_sk');
    Route::post('/simpan_sk', [SuratkeluarController::class, 'store'])->name('simpan_sk');
    Route::get('/catat_sk/{rhs}', [SuratkeluarController::class, 'create'])->name('catat_sk_rhs');
    Route::get('/surat_keluar/{id}/lihat', [SuratkeluarController::class, 'show'])->name('lihat_surat_keluar');
    Route::get('/surat_keluar/{id}/edit', [SuratkeluarController::class, 'edit'])->name('edit_surat_keluar');
    Route::post('/surat_keluar/{id}/update', [SuratkeluarController::class, 'update'])->name('update_surat_keluar');
    Route::get('/surat_keluar/{id}/hapus', [SuratkeluarController::class, 'destroy'])->name('hapus_surat_keluar');
    Route::post('/hapus_sk', [SuratkeluarController::class, 'destroy'])->name('hapus_sk');
    Route::get('/sk_register', [SuratkeluarController::class, 'buku_induk']);
    Route::get('/sk_register_export/{bulan}/{tahun}', [SuratkeluarController::class, 'buku_induk_export']);
    Route::get('/sk_register_export/{bulan}/{tahun}/{rhs}', [SuratkeluarController::class, 'buku_induk_export']);

    Route::get('/plh', [PlhController::class, 'index'])->name('plh');
    Route::get('/catat_plh', [PlhController::class, 'create'])->name('catat_plh');
    Route::post('/simpan_plh', [PlhController::class, 'store'])->name('simpan_plh');
    Route::post('/hapus_plh', [PlhController::class, 'destroy'])->name('hapus_plh');

    Route::get('/statistik_sm', [StatistiksmController::class, 'index'])->name('statistik_sm');
    Route::get('/statistik_sm/export/{bulan}/{tahun}', [StatistiksmController::class, 'export']);
    Route::get('/statistik_sk', [StatistikskController::class, 'index'])->name('statistik_sk');
    Route::get('/statistik_sk/export/{bulan}/{tahun}', [StatistikskController::class, 'export']);

    Route::post('/tampil_stat_sm', [StatistiksmController::class, 'tampilkan'])->name('statistik.masuk.tampil');
    Route::post('/tampil_stat_sk', [StatistikskController::class, 'tampilkan'])->name('statistik.keluar.tampil');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/tambah_user', [UserController::class, 'create'])->name('tambah_user');
    Route::post('/simpan_user', [UserController::class, 'store'])->name('simpan_user');
    Route::get('/edit_user/{id}', [UserController::class, 'edit'])->name('edit_user');
    Route::post('/update_user', [UserController::class, 'update'])->name('update_user');
    Route::post('/hapus_user', [UserController::class, 'delete'])->name('hapus_user');

    Route::get('/klasifikasi', [KlasifikasiController::class, 'index'])->name('users');
    Route::get('/tambah_klasifikasi', [KlasifikasiController::class, 'create'])->name('tambah_klasifikasi');
    Route::post('/simpan_klasifikasi', [KlasifikasiController::class, 'store'])->name('simpan_klasifikasi');
    Route::get('/edit_klasifikasi/{id}', [KlasifikasiController::class, 'edit'])->name('edit_klasifikasi');
    Route::post('/update_klasifikasi', [KlasifikasiController::class, 'update'])->name('update_klasifikasi');
    Route::post('/hapus_klasifikasi', [KlasifikasiController::class, 'delete'])->name('hapus_klasifikasi');
    
    Route::get('/surat_keluar_rhs_baru', [SuratkeluarbaruController::class, 'surat_rahasia'])->name('surat_keluar_baru');
    Route::get('/surat_keluar_baru', [SuratkeluarbaruController::class, 'index'])->name('surat_keluar_baru');
    Route::get('/sk_ajax_baru', [SuratkeluarbaruController::class, 'get_data_ajax'])->name('sk_ajax_baru');
    Route::get('/catat_sk_baru', [SuratkeluarbaruController::class, 'create'])->name('catat_sk_baru');
    Route::get('/catat_sk_baru/{rhs}', [SuratkeluarbaruController::class, 'create'])->name('catat_sk_rhs_baru');
    Route::post('/simpan_sk_baru', [SuratkeluarbaruController::class, 'store'])->name('simpan_sk_baru');
    Route::get('/surat_keluar_baru/{id}/lihat', [SuratkeluarbaruController::class, 'show'])->name('lihat_surat_keluar_baru');
    Route::get('/surat_keluar_baru/{id}/edit', [SuratkeluarbaruController::class, 'edit'])->name('edit_surat_keluar_baru');
    Route::post('/surat_keluar_baru/{id}/update', [SuratkeluarbaruController::class, 'update'])->name('update_surat_keluar_baru');
    Route::post('/hapus_sk_baru', [SuratkeluarbaruController::class, 'destroy'])->name('hapus_sk_baru');
    Route::post('/surat_keluar_backdate_baru', [SuratkeluarbaruController::class, 'nomor_backdate'])->name('nomor.cari.baru');
    Route::get('/kirim_pta/{id}', [SuratkeluarbaruController::class, 'kirim_pta'])->name('kirim_pta');
    Route::get('/lacak_surat_pta/{id}', [SuratkeluarbaruController::class, 'lacak_surat_pta'])->name('lacak_surat_pta');
});

Route::post('/setting/tahun_anggaran', [SettingController::class, 'set_tahun_anggaran'])->name('set_tahun_anggaran');
Route::post('/klasifikasi/cari', [KlasifikasiController::class, 'show'])->name('klasifikasi.cari');
Route::post('/surat_keluar_backdate', [SuratkeluarController::class, 'nomor_backdate'])->name('nomor.cari');
Route::post('/cari_pegawai_plh', [PlhController::class, 'get_pelaksana_plh'])->name('cari.pegawai.plh');
Route::post('/cari_atasan_plh', [PlhController::class, 'get_atasan_plh'])->name('cari.atasan.plh');
