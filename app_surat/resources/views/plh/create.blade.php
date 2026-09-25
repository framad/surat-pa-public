@extends('layout.main')
@section('title', 'Catat Pelaksana Harian')

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
            <li class="breadcrumb-item active" aria-current="page">Pelaksana Harian</li>
            <li class="breadcrumb-item active" aria-current="page">Catat Pelaksana Harian</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="align-left"></i></span></span>Catat Pelaksana Harian</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="hk-sec-title">Catat Pelaksana Harian</h5>
                            <p class="mb-25">Silahkan masukkan data pelaksana harian yang akan dicatat</p>
                        </div>
                        <div class="col-sm d-flex justify-content-end align-items-start ">
                            <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/plh')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ url('/simpan_plh')}}" method="POST" id="form-surat" class="needs-validation" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="input_tags">Tanggal Awal</label>
                                        <input class="form-control" type="text" name="tanggal_awal" id="tanggal_awal" onchange="awal_change()" value="{{ old('tanggal_awal') }}" required/>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div> 
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="input_tags">Tanggal Akhir</label>
                                        <input class="form-control" type="text" name="tanggal_akhir" id="tanggal_akhir" value="{{ old('tanggal_akhir') }}" required/>
                                        @error ('id_jabatan')  
                                        <div class="invalid-feedback">
                                            {{$errors->first('id_jabatan')  }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Pejabat Yang Didelegasi</label>
                                        <div class="input-group mb-6">
                                            <input type="hidden" id="id_jabatan" name="id_jabatan" value="{{ old('id_jabatan') }}">
                                            <input type="text" class="form-control" placeholder="Nama Pejabat" id="nama_pejabat" name="nama_pejabat" value="{{ old('nama_pejabat') }}" readonly required>
                                            <div class="input-group-prepend">
                                                {{-- <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-atasan">Pilih</button> --}}
                                                <button class="btn btn-outline-primary" type="button" onclick="cariAtasan()">Pilih</button>
                                                <button class="btn btn-outline-danger" type="button" onclick="hapusPejabat()">Hapus</button>
                                              </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Nama Pelaksana</label>
                                        <div class="input-group mb-6">
                                            <input type="hidden" id="nip" name="nip" value="{{ old('nip') }}">
                                            <input type="text" class="form-control" placeholder="Nama Pegawai" id="nama" name="nama" value="{{ old('nama') }}" readonly required>
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-primary" id="btn-pelaksana" type="button" data-toggle="modal" data-target="#modal-pegawai" disabled>Pilih</button>
                                                <button class="btn btn-outline-danger" type="button" onclick="hapusPegawai()">Hapus</button>
                                              </div>
                                        </div>
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

{{-- Modal --}}
<div class="modal fade" id="modal-atasan" tabindex="-1" role="dialog" aria-labelledby="modal-atasan" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Pejabat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <br/>
                <table id="datable_1" class="table table-hover w-100 display pb-30 table-atasan">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($atasan as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->nama_jabatan}}</td>
                            <td>
                                <button class="btn btn-primary" onclick="pilihAtasan(`{{json_encode($item)}}`)">Pilih</button>
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Jabatan</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-pegawai" tabindex="-1" role="dialog" aria-labelledby="modal-pegawai" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <br/>
                <table id="datable_1" class="table table-hover w-100 display pb-30 table-pegawai">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Jabatan</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}

@endsection

@section('toast')
<script>
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
    function cariAtasan() {
        $('.table-atasan > tbody').empty();
        var tanggal_awal = $("#tanggal_awal").val();
        $.ajax({
            type:'POST',
            url:"{{ route('cari.atasan.plh') }}",
            data:{tanggal_awal},
            success:function(data){
                $('.table-atasan > tbody').html(data);
                $('#modal-atasan').modal('show');
            }
        });
    }
    function pilihAtasan(data) {
        var param = data.split('|');
        cariPegawai(param);
        $('#modal-atasan').modal('hide');
        $("#id_jabatan").val(param[0]);
        $("#nama_pejabat").val(param[1]);
        $("#btn-pelaksana").removeAttr("disabled");
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

    $('#tanggal_awal').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 2016,
        locale: {
			format: 'DD-MM-YYYY'
		}
	});
    $('#tanggal_akhir').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 2016,
        locale: {
			format: 'DD-MM-YYYY'
		}
	});
    
    function awal_change() {
        hapusPejabat();
        var tanggal_awal = new Date($("#tanggal_awal").val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
        var tanggal_akhir = new Date($("#tanggal_akhir").val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
        if (tanggal_akhir < tanggal_awal) {
            $('#tanggal_akhir').val($('#tanggal_awal').val());
            // $('#tanggal_akhir').daterangepicker("setDate", tanggal_awal);
        }
    }
</script>
@endsection
