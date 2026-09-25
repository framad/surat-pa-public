@extends('layout.main')
@section('title', 'Catat Surat Keluar')
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
            <li class="breadcrumb-item"><a href="#">Surat Keluar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Catat Surat Keluar</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="mail"></i></span></span>Catat Surat Keluar</h4>
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
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif

         
                        @if (session('error'))
                            <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
                                <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> ERROR data tidak tersimpan.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm">
                                <h5 class="hk-sec-title">Catat Surat Keluar</h5>
                                <p class="mb-40">Pencatatan Surat Keluar</p>
                            </div>
                            <div class="col-sm d-flex justify-content-end align-items-start ">
                                @if (Auth::user()->role!=5 && Auth::user()->role!=3)
                                    <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="{{ url('/catat_sk')}}"><span class="btn-text">Catat Surat Baru</span> <span class="icon-label"><span class="feather-icon"><i data-feather="plus-circle"></i></span> </span></a>
                                @endif
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-sm">

                                    <div class="table-wrap">
                                        <table id="datatable_1" class="table table-hover w-100 display pb-30">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Isi Ringkas</th>
                                                    <th>Asal Surat</th>
                                                    <th>Nomor, Tgl Surat</th>
                                                    <th>File</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item) 
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$item->isi_ringkas}}
                                                            {{-- @php
                                                                $value = DB::table('t_surat_keluar')
                                                                ->join('t_disposisi','t_surat_keluar.id','=','t_disposisi.id_surat_keluar')
                                                                ->select('t_surat_keluar.*','t_disposisi.*')
                                                                ->where('t_surat_keluar.id',$item->id)  
                                                                ->get();
                                                                
                                                                if($value->isEmpty())
                                                                {
                                                                    echo '<span class="badge badge-warning badge-pill mb-15 mr-10">Baru</span>';
                                                                }
                                                            @endphp --}}
                                                        </td>
                                                        <td>{{$item->tujuan_surat}}</td>
                                                        <td>
                                                            {{$item->nomor_surat}}
                                                            <br>
                                                            {{-- date('Y-m-d', strtotime($request->tgl_surat)); --}}
                                                            {{ date('d-M-Y', strtotime($item->tanggal_surat))}}
                                                        </td>
                                                        <td>
                                                            @if (!empty($item->file))
                                                                <a href="{{ asset('dok/keluar').'/'.$item->file}}" target="_blank"><image src="{{ asset('images/pdf.png')}}" width="50" ></a> 
                                                                {{-- <a href="" data-toggle="modal" data-target="#modalPdf{{$item->id}}"><image src="{{ asset('images/pdf.png')}}" width="50" ></a>  --}}
                                                                {{-- <button type="button" data-toggle="modal" data-target="#modalPdf"><image src="{{ asset('images/pdf.png')}}" width="50" ></button>  --}}
                                                            @else
                                                            <image src="{{ asset('images/nopdf.webp')}}" width="50">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (Auth::user()->role!=5 && Auth::user()->role!=3)
                                                                <div class="btn-group">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i data-feather="list"></i>
                                                                    </button>
                                                                    {{-- <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button> --}}
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" href="{{ url('/surat_keluar/'.$item->enc_id.'/lihat') }}"><i class="dropdown-icon" data-feather="eye"></i><span>Lihat</span></a>
                                                                        <a class="dropdown-item" href="{{ url('/surat_keluar/'.$item->enc_id.'/edit') }}"><i class="dropdown-icon" data-feather="edit-3"></i><span>Edit</span></a>
                                                                        <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalHapus{{$item->id}}"><i class="dropdown-icon" data-feather="trash"></i><span>Hapus</span></a>
                                                                        <div class="dropdown-divider"></div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
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
   
    
    
        <!-- Modal -->
        @foreach ($data as $item)
            <div class="modal fade" id="modalPdf{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-purple-dark-4">
                            <h5 class="modal-title text-white">File Surat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- <iframe src ="{{ asset('dok/keluar').'/'.$item->file}}" width="100%" height="600px"></iframe> --}}
                            {{-- <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p> --}}
                        </div>
                        {{-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div> --}}
                    </div>
                </div>
            </div>
            
            {{-- modal hapus --}}
            <div class="modal fade" id="ModalHapus{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Surat Keluar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Anda yakin menghapus data ini ?</p>
                        </div>
                        <div class="modal-footer">
                            <form method="GET" action="{{ url('/surat_keluar/'.$item->enc_id.'/hapus') }}">
                                <button type="sumbit" class="btn btn-primary"><i class="fa fa-exclamation-triangle"></i> Hapus</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ModalTeruskan{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Teruskan Surat Keluar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="/disposisi/teruskan/{{$item->id}}  ">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleDropdownFormEmail1">Teruskan Ke :</label>
                                        <select class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com" name="kepada">
                                            <option disabled>Pilih</option>
                                            @foreach ($pegawai as $peg)
                                                <option value="{{$peg->nip}}">{{$peg->name.' - '. $peg->nama_jabatan }}</option>
                                            @endforeach
                                        </select>
                                </div>                      
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Teruskan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
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
@endsection