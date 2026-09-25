@extends('layout.main')
@section('title', 'Tambah Pengguna')

@section('css')
    <!-- select2 CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Pickr CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/pickr-widget/dist/pickr.min.css" rel="stylesheet" type="text/css" />

    <!-- Daterangepicker CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="align-left"></i></span></span>Tambah Pengguna</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="hk-sec-title">Tambah Pengguna</h5>
                            <p class="mb-25">Silahkan masukkan data pengguna yang akan ditambahkan</p>
                        </div>
                        <div class="col-sm d-flex justify-content-end align-items-start ">
                            <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/users')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    Gagal Menyimpan Data:
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ url('/simpan_user')}}" method="POST" id="form-surat" class="needs-validation" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nama" value="{{ old('name') }}" required>
                                        <div class="invalid-feedback">  
                                            Kolom Ini Harus Diisi
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                                        <div class="invalid-feedback">  
                                            Kolom Ini Harus Diisi
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>NIP / Username</label>
                                        <input type="text" name="nip" class="form-control" placeholder="NIP / Username (Tanpa Titik)" value="{{ old('nip') }}" required>
                                        <div class="invalid-feedback">  
                                            Kolom Ini Harus Diisi
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        <div class="invalid-feedback">  
                                            Kolom Ini Harus Diisi
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Nomor Handphone</label>
                                        <input type="number" name="no_hp" class="form-control" placeholder="Nomor Handphone" value="{{ old('no_hp') }}" required>
                                        <div class="invalid-feedback">  
                                            Kolom Ini Harus Diisi
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Jabatan</label>
                                        <select class="form-control select-jabatan" id="id_jabatan" name="id_jabatan" value="{{ old('id_jabatan') }}" required>
                                            <option value="0" selected disabled>-- Pilih Jabatan --</option>
                                            @foreach ($jabatan as $item)
                                                <option value={{ $item->id }}>
                                                    {{ $item->nama_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Hak Akses</label>
                                        <select class="form-control select-role" id="id_role" name="id_role" value="{{ old('id_role') }}" required>
                                            <option value="0" selected disabled>-- Pilih Hak Akses --</option>
                                            @foreach ($role as $item)
                                                <option value={{ $item->id }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-wth-icon btn-lg" id="btn-submit">
                                    <span class="icon-label"><span class="feather-icon"><i data-feather="save"></i></span> </span><span class="btn-text">Simpan</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

    <!-- Footer -->
    <div class="hk-footer-wrap container">
        <footer class="footer">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <p>Hak Cipta<a href="http://www.pta-bandung.go.id" class="text-dark" target="_blank">PTA Bandung</a> © 2022</p>
                </div>
                <div class="col-md-6 col-sm-12">
                    <p class="d-inline-block">Follow us</p>
                    <a href="https://www.facebook.com/pta.bandung" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-facebook"></i></span></a>
                    <a href="https://www.instagram.com/ptabandung/" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-instagram"></i></span></a>
                    <a href="https://www.youtube.com/channel/UCpPzjZIJqZixAg7ZWKLAORg" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-youtube"></i></span></a>
                </div>
            </div>
        </footer>
    </div>
    <!-- /Footer -->
</div>
<!-- /Main Content -->
</div>

@endsection

@section('toast')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select-jabatan').select2();
        $('.select-role').select2();
    });

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
            });
        }, false);
    })();
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script type="text/javascript">
    function pilihJabatan(data) {
        console.log(data);
        // var param = data.split('|');
        // cariPegawai(param);
        // $('#modal-atasan').modal('hide');
        // $("#id_jabatan").val(param[0]);
        // $("#nama_pejabat").val(param[1]);
        // $("#btn-pelaksana").removeAttr("disabled");
    }

    function cariPegawai(param) {
        $('.table-pegawai > tbody').empty();
        var tanggal_awal = $("#tanggal_awal").val();
        console.log(param, tanggal_awal);
        $.ajax({
            type:'POST',
            url:"{{ route('cari.pegawai.plh') }}",
            data:{
                id_jabatan:param[0],
                bagian:param[2],
                tanggal_awal
            },
            success:function(data){
                console.log(data);
                $('.table-pegawai > tbody').html(data);
            }
        });
    }
    function pilihPegawai(data) {
        var param = data.split('|');
        $("#nip").val(param[0]);
        $("#nama").val(param[1]);
        $('#modal-pegawai').modal('hide');
    }

    function hapusPejabat() {
        $("#btn-pelaksana").attr("disabled", true);
        $("#id_jabatan").val('');
        $("#nama_pejabat").val('');
        hapusPegawai();
    }
    function hapusPegawai() {
        $("#nip").val('');
        $("#nama").val('');
    }
</script>
@endsection
