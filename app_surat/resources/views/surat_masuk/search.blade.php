@extends('layout.main')
@section('title', 'Cari Surat Masuk')
@section('css')
    <!-- Data Table CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style/marvin/html')}}/vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />

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
            <li class="breadcrumb-item active" aria-current="page">Cari Surat Masuk</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title">
                <span class="pg-title-icon"><span class="feather-icon"><i data-feather="mail"></i></span></span>
                Cari Surat Masuk
            </h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <h5 class="hk-sec-title">Data Surat Masuk</h5>
                                <p class="mb-40"></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dari">Keyword:</label>
                                    <input type="text" class="form-control" id="keyword" placeholder="Cari surat">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dari">Dari:</label>
                                    <input type="date" class="form-control" id="tgl_awal">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="dari">Sampai:</label>
                                    <input type="date" class="form-control" id="tgl_akhir">
                                </div>
                            </div>

                            <div class="col-md-3 d-flex justify-content-start align-items-start">
                                <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="#" onclick="cari()">
                                    <span class="btn-text">Cari</span>
                                    <span class="icon-label">
                                        <span class="feather-icon">
                                            <i data-feather="search"></i>
                                        </span>
                                    </span>
                                </a>
                            </div>
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
            //
        });

        function carii() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('sm_ajax_search') }}",
                type: "GET",
                data: {
                    search: $("#search").val(),
                    tgl_awal: $("#tgl_awal").val(),
                    tgl_akhir: $("#tgl_akhir").val(),
                },
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                }
            });
        }

        function cari() {
            $("#datatable_1").dataTable().fnDestroy();

            var table = $('#datatable_1').DataTable({
                searching: false,
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('sm_ajax_search') }}",
                    "type": "GET",
                    "data": {
                        search: $("#keyword").val(),
                        tgl_awal: $("#tgl_awal").val(),
                        tgl_akhir: $("#tgl_akhir").val(),
                    }
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
        }
    </script>

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
@endsection
