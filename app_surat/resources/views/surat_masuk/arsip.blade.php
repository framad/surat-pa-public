@extends('layout.main')
@section('title', 'Arsip Surat Masuk')
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
            <li class="breadcrumb-item active" aria-current="page">Arsip Surat Masuk</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="mail"></i></span></span>Arsip Surat Masuk</h4>
        </div>
        <!-- /Title -->
        
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                    <section class="hk-sec-wrapper">

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
                        <div class="row">
                            <div class="col-sm">
                                <h5 class="hk-sec-title">Arsip Surat Masuk</h5>
                                <p class="mb-40">Pencatatan Arsip Surat Masuk</p>
                            </div>
                            <div class="col-sm d-flex justify-content-end align-items-start ">
                                {{-- @if (Auth::user()->role!=5 && Auth::user()->role!=3)
                                    <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="{{ url('/catat_sk')}}"><span class="btn-text">Catat Surat Baru</span> <span class="icon-label"><span class="feather-icon"><i data-feather="plus-circle"></i></span> </span></a>
                                @endif --}}
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
                                                    <th>No Surat</th>
                                                    <th>Jenis Arsip</th>
                                                    <th>Lokasi Arsip</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No Agenda</th>
                                                    <th>No Surat</th>
                                                    <th>Jenis Arsip</th>
                                                    <th>Lokasi Arsip</th>
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
@endsection

@section('style')
<style>
    #datatable_1 > tbody {
        font-size: 14px;
    }
</style>
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

    <script>
        $(document).ready(function() {
            var table = $('#datatable_1').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('arsip_ajax') }}",
                    "type": "GET"
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'no_agenda', name: 'no_agenda'},
                    {data: 'no_surat', name: 'no_surat'},
                    {data: 'jenis_arsip', name: 'jenis_arsip'},
                    {data: 'lokasi_arsip', name: 'lokasi_arsip'},
                ]
            });
        });
    </script>
@endsection