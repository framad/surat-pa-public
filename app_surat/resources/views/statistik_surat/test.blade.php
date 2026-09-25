@extends('layout.main')
@section('title', 'Statistik Surat Masuk')
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
            <li class="breadcrumb-item active" aria-current="page">Statistik Surat</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="settings"></i></span></span>Statistik Surat Masuk</h4>
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
                                <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> ERROR.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-sm">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="bulan">Bulan: </label>
                                        <select class="custom-select" id="bulan" name="bulan">
                                            <option selected>--Pilih Bulan--</option>
                                            @foreach ($months as $item)
                                                <option value="{{ $item->m }}" {{ $bulan==$item->m ? 'selected' : '' }}>{{ $item->month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bulan">Tahun: </label>
                                        <select class="custom-select" id="tahun" name="tahun">
                                            <option selected>--Pilih Tahun--</option>
                                            @foreach ($years as $item)
                                                <option value="{{ $item }}" {{ $tahun==$item ? 'selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                            {{-- <option value="2018" {{ $tahun==2018 ? 'selected' : '' }}>2018</option>
                                            <option value="2019" {{ $tahun==2019 ? 'selected' : '' }}>2019</option>
                                            <option value="2020" {{ $tahun==2020 ? 'selected' : '' }}>2020</option>
                                            <option value="2021" {{ $tahun==2021 ? 'selected' : '' }}>2021</option>
                                            <option value="2022" {{ $tahun==2022 ? 'selected' : '' }}>2022</option> --}}
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group d-flex justify-content-end align-items-start ">
                                        <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="#" onclick="tampilkan()"><span class="btn-text">Tampilkan</span> <span class="icon-label"><span class="feather-icon"><i data-feather="plus-circle"></i></span> </span></a> &nbsp;
                                        <a class="btn btn-success btn-wth-icon btn-rounded icon-right" href="{{ url('/download_statistik_sm')}}"><span class="btn-text">Download</span> <span class="icon-label"><span class="feather-icon"><i data-feather="plus-circle"></i></span> </span></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">

                                <div class="table-wrap">
                                    <table id="example" class="table table-hover w-100 display pb-30 table-statistik">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode</th>
                                                <th>Klasifikasi</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode</th>
                                                <th>Klasifikasi</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>

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
                        <p>Hak Cipta<a href="http://www.pta-bandung.go.id" class="text-dark" target="_blank">PTA Bandung</a> &copy; 2022</p>
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

@section('style')
<style>
    #datable_1 > tbody {
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

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // function tampilkan() {
        //     $('.table-statistik > tbody').empty();
        //     var bulan = $("#bulan").val();
        //     var tahun = $("#tahun").val();
        //     $.ajax({
        //         type:'POST',
        //         url:"{{ route('statistik.masuk.tampil') }}",
        //         data:{bulan, tahun},
        //         success:function(data){
        //             $('.table-statistik > tbody').html(data);
        //         }
        //     });
        // }
       
        // $(function() {
        //     var bulan = $("#bulan").val();
        //     var tahun = $("#tahun").val();
            
        //     $('.table-statistik').DataTable({
        //         "processing": true,
        //         "serverSide": true,
        //         "ajax":{
        //                 "url": "{{ route('statistik.masuk.tampil') }}",
        //                 "data": {bulan, tahun},
        //                 "dataType": "json",
        //                 "type": "POST"
        //         },
        //         "columns": [
        //             { "data": "no" },
        //             { "data": "kode" },
        //             { "data": "nama" },
        //             { "data": "jumlah" },
        //         ]
        //     });
        // });
    </script>
@endsection
