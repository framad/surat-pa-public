@extends('layout.main')
@section('title', 'Edit Data Pengguna')

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
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="align-left"></i></span></span>Pengguna</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="hk-sec-title">Edit Data Pengguna</h5>
                            <p class="mb-25"></p>
                        </div>
                        <div class="col-sm d-flex justify-content-end align-items-start ">
                            <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/users')}}">
                                <span class="btn-text">Kembali</span> <span class="icon-label">
                                    <span class="feather-icon"><i data-feather="arrow-left-circle"></i></span>
                                </span>
                            </a>
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

                            <form action="{{ url('/update_user')}}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nama" value="{{ $user->name }}" required>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>NIP / Username</label>
                                        <input type="text" name="nip" class="form-control" placeholder="NIP / Username" value="{{ $user->nip }}" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Nomor Handphone</label>
                                        <input type="text" name="no_hp" class="form-control" placeholder="Nomor Handphone" value="{{ $user->no_hp }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Jabatan</label>
                                        <select class="form-control select-jabatan" id="id_jabatan" name="id_jabatan">
                                            <option value="0" disabled>-- Pilih Jabatan --</option>
                                            @foreach ($jabatan as $item)
                                                <option value={{ $item->id }} {{ $user->id_jabatan==$item->id ? 'selected':'' }}>
                                                    {{ $item->nama_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Hak Akses</label>
                                        <select class="form-control select-role" id="id_role" name="id_role">
                                            <option value="0" selected disabled>-- Pilih Hak Akses --</option>
                                            @foreach ($role as $item)
                                                <option value={{ $item->id }} {{ $user->role==$item->id ? 'selected':'' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-wth-icon btn-lg">
                                    <span class="icon-label">
                                        <span class="feather-icon"><i data-feather="save"></i></span>
                                    </span>
                                    <span class="btn-text">Simpan</span>
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

    $('#klasifikasi').on('keyup', function(){
        search();
    });
    $('#klasifikasi').on('change', function(){
        var arr = $('#klasifikasi').val().split('-');
        $('#kode').val(arr[0]);
    });

    // search();
    function search(){
        var kode = $('#klasifikasi').val();
        $.ajax({
           type:'POST',
           url:"{{ route('klasifikasi.cari') }}",
           data:{kode:kode},
           success:function(data){
                // console.log(data);
                $('#kodelist').fadeIn();  
                $('#kodelist').html(data);
           }
        });
    }

    $(document).on('click', 'li', function(){
        var text = $(this).text();
        var arr = text.split('-');
        $('#klasifikasi').val(text);
        $('#kode').val(arr[0]);
        $('#kodelist').fadeOut();  
    });
</script>


<script type="text/javascript">

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

</script>

<script type="text/javascript">
    // $('input[name="tgl_surat"]').daterangepicker({
	// 	singleDatePicker: true,
	// 	showDropdowns: true,
	// 	minYear: 2016,
    //     locale: {
	// 		format: 'DD-MM-YYYY'
	// 	}
	// });
</script>


@endsection
