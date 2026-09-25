@extends('layout.main')
@section('title', 'Detail Surat Masuk')
@section('css')
    <!-- Data Table CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style/marvin/html')}}/vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Surat Masuk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Surat Masuk</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="mail"></i></span></span>Detail Surat Masuk</h4>
        </div>
        <!-- /Title -->
        
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="hk-sec-title">Informasi Detail Surat Masuk</h5>
                            <p class="mb-25">Berikut informasi surat masuk</p>
                        </div>
                        <div class="col-sm d-flex justify-content-end align-items-start ">
                            @if($surat_masuk->sifat_surat < 3)
                                <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/sm')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a>
                            @else
                                <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/sm_rhs')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a>
                            @endif
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success alert-wth-icon alert-dismissible fade show" role="alert">
                            <span class="alert-icon-wrap"><i class="zmdi zmdi-check-circle"></i></span> {{ session()->get('status')}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

        
                    @if (session('error'))
                        <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
                            <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> {{ session()->get('error')}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    
                    {{-- @foreach ($data as $data)  --}}
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h6> Surat Dari :</h6>
                            <span class="pl-10 text-dark">{{$surat_masuk->dari}}</span>
                        </div>
                        <div class="col-md-6">
                            <h6> Tanggal Diterima :</h6>
                            <span class="pl-10 text-dark">{{date('d-m-Y', strtotime($surat_masuk->tgl_diterima))}}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h6> Nomor Surat :</h6>
                            <span class="pl-10 text-dark">{{$surat_masuk->no_surat}}</span>
                        </div>
                        <div class="col-md-6">
                            <h6> Tanggal Surat :</h6>
                            <span class="pl-10 text-dark">{{date('d-m-Y', strtotime($surat_masuk->tgl_surat))}}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6> Isi ringkas :</h6>
                            <span class="pl-10 text-dark">{{$surat_masuk->isi_ringkas}}</span>
                        </div>
                        <div class="col-md-6">
                            <h6> File :</h6>
                            <a href="{{ asset('dok/' . '/' . $surat_masuk->file) }}" target="_blank"><image src="{{ asset('images/pdf.png')}}" width="50" ></a> 
                            {{-- <a href="" data-toggle="modal" data-target="#modalPdf"><image src="{{ asset('images/pdf.png')}}" width="50" ></a>  --}}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6> No Agenda :</h6>
                            <span class="pl-10 text-dark">{{$surat_masuk->no_agenda}}</span>
                        </div>
                    </div>
                    <hr>
                    @if ($surat_masuk->arsipkan==1)
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6> Jenis Arsip :</h6>
                                <span class="pl-10 text-dark">{{$surat_masuk->jenis_arsip=="K" ? "Kepaniteraan" : "Kesekretariatan"}}</span>
                            </div>
                            <div class="col-md-6">
                                <h6> Lokasi Arsip :</h6>
                                <span class="pl-10 text-dark">{{$surat_masuk->lokasi_arsip}}</span>
                            </div>
                        </div>
                    @endif
                    {{-- @endforeach --}}
                </section>

                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col">
                            <h5 class="hk-sec-title">History Disposisi</h5>
                            <p class="mb-25">History disposisi yang telah direkam</p>
                        </div>
                        
                        <div class="col-sm d-flex justify-content-end align-items-start ">
                            <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="{{ url('/cetak_disposisi/'.$surat_masuk->enc_id)}}" target="_blank">
                                <span class="btn-text">Cetak Disposisi</span> <span class="icon-label">
                                    <span class="feather-icon"><i data-feather="printer"></i></span> 
                                </span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm">
                            <!-- Button trigger modal -->
                            <div class="table-wrap" style="overflow-x: scroll;">
                            {{-- <div class="table-responsive"> --}}
                                <table id="table" class="table table-hover w-100 display pb-30">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Disposisi</th>
                                            <th>Isi Disposisi</th>
                                            <th>Tindaklanjut</th>
                                            <th>Diterima</th>
                                            <th>Selesai</th>
                                            <th>Kirim WA</th>
					    @if (Auth::user()->role==1)
                                                <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($disposisi as $row) 
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($row->jenis!=3)
                                                    {{ $row->jabatan_oleh }} <br>
                                                    {{ "(".$row->oleh.")" }}
                                                    <br/>
                                                    <b>{{ $row->jenis==1 ? '== Meneruskan Ke ==':'== Disposisi Ke ==' }}</b>
                                                    <br/>
                                                    {{ $row->nama_jabatan }} <br>
                                                    {{ "(".$row->kepada.")" }}
                                                    @if($row->pelaksana)
                                                        <br/>
                                                        {{ $row->pelaksana }}
                                                    @endif
                                                @else
                                                    {{ $row->oleh }}
                                                    <br/> (TINDAK LANJUT)
                                                @endif
                                            </td>
                                            <td>{{ $row->isi_disposisi }}</td>
                                            <td>{{ $row->tindaklanjut }}</td>
                                            <td>
                                                {{ $row->tgl_terima }}
                                                <br/>
                                                {{ $row->jam_terima }}
                                            </td>
                                            <td>
                                                {{ $row->tgl_selesai }}
                                                <br/>
                                                {{ $row->jam_selesai }}
                                            </td>
                                            <td>
                                                @if($loop->iteration == count($disposisi) && $row->tgl_selesai=='-')
                                                    {{-- <a class="dropdown-item" href="{{ url('sm_send_wa/'.$row->id) }}"><i data-feather="send"></i></a> --}}
                                                    <a class="dropdown-item" href="#" onclick="send_wa({{ $row->id }})"><i data-feather="send"></i></a>
                                                @endif
                                            </td>
					    @if (Auth::user()->role==1)
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i data-feather="list"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="#" onclick="hapus({{ $row->id_surat_masuk }}, {{ $row->id }})">
                                                                <i class="dropdown-icon" data-feather="trash"></i><span>Hapus</span>
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table> 
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="modalPdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-purple-dark-4">
                    <h5 class="modal-title text-white">File Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src ="{{ asset('dok').'/'.$surat_masuk->file}}" width="100%" height="600px"></iframe>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Disposisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin menghapus data ini ?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ url('/disposisi/hapusDisposisi') }}">
                        @csrf
                        <input type="hidden" id="id_dispo_hapus" name="id_dispo_hapus">
                        <input type="hidden" id="id_surat_hapus" name="id_surat_hapus">
                        <button type="sumbit" class="btn btn-primary"><i class="fa fa-exclamation-triangle"></i> Hapus</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
    <!-- Toastr JS -->  
@endsection

@section ('toast')
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
    <script src="{{ asset('style/marvin/html')}}/vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/dist/js/toast-data.js"></script>

    <!-- Data Table JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/jszip/dist/jszip.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/dist/js/dataTables-data.js"></script>

    @if(session()->has('status'))
        <script>
            $(document).ready(function() {
                "use strict";
                    $.toast({
                        heading: 'Berhasil',
                        text: '<i class="jq-toast-icon ti-light-bulb"></i><p>Data telah berhasil disimpan.</p>',
                        position: 'top-right',
                        loaderBg:'#7a5449',
                        class: 'jq-has-icon jq-toast-info',
                        hideAfter: 3500, 
                        stack: 6,
                        showHideTransition: 'fade'
                });
            });
        </script>
    @endif

    <script>
        function send_wa(id) {
            var url = "{{ url('sm_send_wa') }}/" + id;
            console.log(url);
            window.location.href = url;
        }

        function hapus(id_surat, id_dispo) {
            $('#id_dispo_hapus').val(id_dispo);
            $('#id_surat_hapus').val(id_surat);
            $('#ModalHapus').modal('toggle');
            $('#ModalHapus').modal('show');
        }
    </script>
@endsection

@section('style')
<style>
    #table > tbody > tr {
        font-size: 12px;
    }
</style>
@endsection
