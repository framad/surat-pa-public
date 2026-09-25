@extends('layout.main')
@section('title', 'Surat Masuk')
@section('css')
    <!-- Data Table CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style/marvin/html')}}/vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css"> --}}

    {{-- https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css
    https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css
    https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css --}}

    <style>
        div.dataTables_scrollBody {
            min-height: 190px;
        }
    </style>
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Surat Masuk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Surat Masuk</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="mail"></i></span></span>Surat Masuk</h4>
        </div>
        <!-- /Title -->
        {{-- {{ session()->get('tahun_anggaran') }} --}}
        {{-- {{ session()->all() }} --}}

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                    <section class="hk-sec-wrapper">

                        @if (session('status'))
                            <div class="alert alert-success alert-wth-icon alert-dismissible fade show" role="alert">
                                <span class="alert-icon-wrap"><i class="zmdi zmdi-check-circle"></i></span> {{ session()->get('status')}}.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
                                <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> ERROR data tidak tersimpan.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm">
                                <h5 class="hk-sec-title">Data Surat Masuk</h5>
                                <p class="mb-40"></p>
                            </div>
                            @if(Auth::user()->role==1 || Auth::user()->role==4)
                            <div class="col-sm d-flex justify-content-end align-items-start ">
                                @if ($editable)
                                    <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="{{ url('/catat_sm')}}">
                                        <span class="btn-text">Surat Baru</span> 
                                        <span class="icon-label">
                                            <span class="feather-icon">
                                                <i data-feather="plus-circle"></i>
                                            </span> 
                                        </span>
                                    </a>
                                @endif
                            </div>
                            @endif
                        </div>
                            <div class="row">
                                <div class="col-sm">

                                    <div class="table-wrap">
                                        <table id="datatable_1" class="table table-hover w-100 display pb-30">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No Agenda</th>
                                                    <th>Isi Ringkas</th>
                                                    <th>Asal Surat</th>
                                                    <th>Nomor, Tgl, Posisi Surat</th>
                                                    <th>File</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No Agenda</th>
                                                    <th>Isi Ringkas</th>
                                                    <th>Asal Surat</th>
                                                    <th>Nomor, Tgl Surat</th>
                                                    <th>File</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
            </div>
        </div>


        <!-- Footer -->
        <div class="hk-footer-wrap container">
            <footer class="footer">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <p>Hak Cipta<a href="http://www.pta-bandung.go.id" class="text-dark" target="_blank">PTA Bandung</a> &copy 2022</p>
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

    <div class="modal fade" id="ModalArsipkan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Arsipkan Surat Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ url('/sm/arsipkan') }}">
                    @csrf
                    <input type="hidden" name="id_surat_arsip" id="id_surat_arsip">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jenis_arsip"></label>
                            <select onchange="jenisChange()" class="custom-select" id="jenis_arsip" name="jenis_arsip">
                                <option value="">--Pilih Jenis Arsip--</option>
                                <option value="S" {{ false ? 'selected':'' }}>Kesekretariatan</option>
                                <option value="P" {{ false ? 'selected':'' }}>Kepaniteraan</option>
                            </select>
                            <div class="invalid-feedback" id="arsip_invalid">
                                Jenis arsip harus dipilih
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="catatan">Lokasi Arsip</label>
                            <input class="form-control" type="text" placeholder="Lokasi Arsip"
                                id="lokasi_arsip" name="lokasi_arsip" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnArsipkan" disabled>
                            <i class="fa fa-arrow-right"></i> Arsipkan
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    {{-- modal hapus --}}
    <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Surat Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin menghapus data ini ?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ url('/hapus_sm') }}">
                        @csrf
                        <input type="hidden" id="id_surat" name="id_surat">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-exclamation-triangle"></i> Hapus</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- @foreach ($data as $item) --}}
        {{-- <div class="modal fade" id="ModalHapus{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Surat Masuk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Anda yakin menghapus data ini ?</p>
                    </div>
                    <div class="modal-footer">
                        <form method="GET" action="{{ url('/sm/'.$item->id.'/hapus') }}">
                            <button type="sumbit" class="btn btn-primary"><i class="fa fa-exclamation-triangle"></i> Hapus</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    {{-- @endforeach --}}
    <!-- Modal Hapus-->
    <!-- Modal -->
@endsection

@section('style')
<style>
    #datatable_1 > tbody {
        font-size: 14px;
    }
</style>
@endsection

@section ('toast')
    <script>
        $(document).ready(function() {
            var table = $('#datatable_1').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('sm_ajax') }}",
                    "type": "GET"
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'no_agenda', name: 'no_agenda'},
                    {
                        data: 'isi_ringkas',
                        name: 'isi_ringkas',
                        orderable: true,
                        searchable: true
                    },
                    {data: 'dari', name: 'dari'},
                    {
                        data: 'no_surat',
                        name: 'no_surat',
                        orderable: true,
                        searchable: true
                    },
                    {data: 'file', name: 'file'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        });
    </script>

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
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>

    {{-- https://code.jquery.com/jquery-3.5.1.js
    https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js
    https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js
    https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js
    https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js --}}

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
        function arsipkan(id_surat) {
            $('#id_surat_arsip').val(id_surat);
            $('#ModalArsipkan').modal('toggle');
            $('#ModalArsipkan').modal('show');
        }

        function jenisChange() {
            var jenis = $("#jenis_arsip").val();
            if (jenis=='') {
                $("#btnArsipkan").attr("disabled", true);
                $("#arsip_invalid").show();
            } else {
                $("#btnArsipkan").attr("disabled", false);
                $("#arsip_invalid").hide();
            }
        }

        function hapus(id) {
            $('#id_surat').val(id);
            $('#ModalHapus').modal('toggle');
            $('#ModalHapus').modal('show');
        }
    </script>
@endsection
