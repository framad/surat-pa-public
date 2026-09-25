{{-- @dd(Auth::user()->role) --}}
@extends('layout.main')
@section('title', 'Surat Masuk Rahasia')
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
            <li class="breadcrumb-item active" aria-current="page">Surat Masuk Rahasia</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="mail"></i></span></span>Surat Masuk Rahasia</h4>
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
                                <h5 class="hk-sec-title">Data Surat Masuk Rahasia</h5>
                                <p class="mb-40"></p>
                            </div>
                            @if(Auth::user()->role==1)
                            <div class="col-sm d-flex justify-content-end align-items-start ">
                                @if ($editable)
                                    <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="{{ url('/catat_sm/rhs')}}">
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
                                        <table id="datable_1" class="table table-hover w-100 display pb-30">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No Agenda</th>
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
                                                        <td>{{$item->no_agenda}}</td>
                                                        <td>{{$item->isi_ringkas}}
                                                        @php
                                                            $value = DB::table('t_surat_masuk')
                                                            ->join('t_disposisi','t_surat_masuk.id','=','t_disposisi.id_surat_masuk')
                                                            ->select('t_surat_masuk.*','t_disposisi.*')
                                                            ->where('t_surat_masuk.id',$item->id)  
                                                            ->get(); 
                                                            
                                                            if($value->isEmpty())
                                                            {
                                                                echo '<span class="badge badge-warning badge-pill mb-15 mr-10">Baru</span>';
                                                            }
                                                            if($item->sifat_surat>2)
                                                            {
                                                                echo '<span class="badge badge-danger badge-pill mb-15 mr-10">Rahasia</span>';
                                                            }
                                                            if($item->belum_selesai_8_jam > 0)
                                                            {
                                                                echo '<br/><span class="badge badge-danger badge-pill mb-15 mr-10">>8 jam</span>';
                                                            }
                                                        @endphp</td>
                                                        <td>{{$item->dari}}</td>
                                                        <td>
                                                            {{$item->no_surat}}
                                                            <br>
                                                            {{-- date('Y-m-d', strtotime($request->tgl_surat)); --}}
                                                            {{ date('d-m-Y', strtotime($item->tgl_surat))}}
                                                        </td>
                                                        <td>
                                                            @if (!empty($item->file))
                                                                <a href="{{ asset('dok/' . '/' . $item->file) }}" target="_blank"><image src="{{ asset('images/pdf.png')}}" width="50" ></a>
                                                                {{-- <a href="" data-toggle="modal" data-target="#modalPdf{{$item->id}}"><image src="{{ asset('images/pdf.png')}}" width="50" ></a>  --}}
                                                                {{-- <button type="button" data-toggle="modal" data-target="#modalPdf"><image src="{{ asset('images/pdf.png')}}" width="50" ></button>  --}}
                                                            @else
                                                                <image src="{{ asset('images/nopdf.webp')}}" width="50">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            

                                                            <div class="btn-group">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                  <i data-feather="list"></i>
                                                                </button>
                                                                {{-- <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button> --}}
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                  
                                                                    @if(Auth::user()->role==1 || Auth::user()->role==4)
                                                                        <a class="dropdown-item" href="{{ url('/sm/'.$item->enc_id.'/cetak') }}" target="_blank">
                                                                            <i class="dropdown-icon" data-feather="printer"></i>
                                                                            <span>Cetak Tanda Terima</span>
                                                                        </a>
                                                                        
                                                                        <div class="dropdown-divider"></div>

                                                                        @if ($editable)
                                                                            <a class="dropdown-item" href="{{ url('/sm/'.$item->enc_id.'/edit') }}">
                                                                                <i class="dropdown-icon" data-feather="edit-3"></i>
                                                                                <span>Edit</span>
                                                                            </a>

                                                                            <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalHapus{{$item->id}}">
                                                                                <i class="dropdown-icon" data-feather="trash"></i>
                                                                                <span>Delete</span>
                                                                            </a>
                                                                            <div class="dropdown-divider"></div>
                                                                        @endif
                                                                    @endif
                                                                    
                                                                    @if($value->isEmpty())
                                                                        <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalTeruskan{{$item->id}}" >
                                                                            <i class="dropdown-icon" data-feather="arrow-right"></i>
                                                                            <span>Teruskan</span>
                                                                        </a>
                                                                    @endif

                                                                    <a class="dropdown-item" href="{{ url('/sm/'.$item->enc_id.'/lacak') }}">
                                                                        <i class="dropdown-icon" data-feather="search"></i>
                                                                        <span>Lihat Detil</span>
                                                                    </a>

                                                                  {{-- <a class="dropdown-item" href="/izbel/{{$item->id}}/historyuser"><i data-feather="clock" class="wd-15 mg-r-5"></i>History Usulan</a> --}}
                                                                  {{-- <a class="dropdown-item" href="/izbel/{{$item->id}}/waizbel"><i data-feather="send" class="wd-15 mg-r-5"></i>Kirim Whatsapp</a> --}}
                                                                </div>
                                                              </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
                            {{-- <iframe src ="{{ asset('dok').'/'.$item->file}}" width="100%" height="600px"></iframe> --}}
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
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Surat Masuk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Anda yakin menghapus data ini ?</p>
                        </div>
                        <div class="modal-footer">
                            {{-- <form method="GET" action="/sm/{{$item->id}}/hapus"> --}}
                            <form method="GET" action="{{ url('/sm/'.$item->id.'/hapus') }}">
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
                            <h5 class="modal-title" id="exampleModalLabel">Teruskan Surat Masuk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {{-- <form method="POST" action="/disposisi/teruskan/{{$item->id}}  "> --}}
                        <form method="POST" action="{{ url('/disposisi/teruskan/'.$item->id) }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleDropdownFormEmail1">Teruskan Ke :</label>
                                    <select class="form-control" name="kepada">
                                        <option disabled>Pilih</option>
                                        @foreach ($pegawai as $peg)
                                            {{-- <optgroup label=""> --}}
                                            <option value="{{$peg->nip}}">{{$peg->name.' - '. $peg->nama_jabatan }}</option>
                                            {{-- <option value="HI">Hawaii</option> --}}
                                        @endforeach
                                            {{-- </optgroup> --}}
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
        <!-- Modal Hapus-->
        @endforeach
        <!-- Modal -->    
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
@endsection
