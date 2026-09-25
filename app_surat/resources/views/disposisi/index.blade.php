@extends('layout.main')
@section('title', 'Kotak Surat Masuk')
@section('css')
    <!-- Data Table CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style/marvin/html')}}/vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- select2 CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Kotak Surat Masuk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kotak Surat Masuk</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="mail"></i></span></span>Kotak Surat Masuk</h4>
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
                                <h5 class="hk-sec-title">Kotak Surat Masuk</h5>
                                <p class="mb-40">Disposisi Surat Masuk </p>
                            </div>
                            <div class="col-sm d-flex justify-content-end align-items-start ">
                                {{-- <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="{{ url('/catat_sm')}}"><span class="btn-text">Catat Surat Baru</span> <span class="icon-label"><span class="feather-icon"><i data-feather="plus-circle"></i></span> </span></a> --}}
                            </div>
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
                                                            if ($item->tembusan) {
                                                                echo '<span class="badge badge-info badge-pill mb-15 mr-10">tembusan</span>';
                                                            } else {
                                                                if($item->teruskan <>1)
                                                                {
                                                                    echo '<span class="badge badge-warning badge-pill mb-15 mr-10">Baru</span>';
                                                                }
                                                                if($item->plh)
                                                                {
                                                                    echo '<span class="badge badge-info badge-pill mb-15 mr-10">PLH</span>';
                                                                }
                                                            }

                                                            if ($item->sifat_surat>2) {
                                                                echo '<span class="badge badge-danger badge-pill mb-15 mr-10">Rahasia</span>';
                                                            }

                                                        @endphp</td>
                                                        <td>{{$item->dari}}</td>
                                                        <td>
                                                            {{$item->no_surat}}
                                                            <br>
                                                            {{-- date('Y-m-d', strtotime($request->tgl_surat)); --}}
                                                            {{ date('d-m-Y', strtotime($item->tgl_surat))}}
                                                        </td>

                                                        {{-- <td>
                                                            @if (!empty($item->file))
                                                                <a href="{{ asset('dok/' . '/' . $item->file) }}" target="_blank"><image src="{{ asset('images/pdf.png')}}" width="50" ></a>
                                                            @else
                                                                <image src="{{ asset('images/nopdf.webp')}}" width="50">
                                                            @endif
                                                        </td> --}}
                                                        <td>
                                                            {{-- sifat surat: 1=biasa,2=penting,3=rhs pengaduan,4=rhs kepeg,5=rhs banding --}}
                                                            @if (!empty($item->file))
                                                                @if ($role==5 && $item->sifat_surat>2)
                                                                    Surat Rahasia
                                                                @else
                                                                    <a href="{{ asset('dok/' . '/' . $item->file) }}" target="_blank"><image src="{{ asset('images/pdf.png')}}" width="50" ></a>
                                                                @endif
                                                                {{-- <a href="" data-toggle="modal" data-target="#modalPdf{{$item->id}}"><image src="{{ asset('images/pdf.png')}}" width="50" ></a>  --}}
                                                                {{-- <button type="button" data-toggle="modal" data-target="#modalPdf"><image src="{{ asset('images/pdf.png')}}" width="50" ></button>  --}}
                                                            @else
                                                                <image src="{{ asset('images/nopdf.webp')}}" width="50">
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if ($role!=5)
                                                                <div class="btn-group">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i data-feather="list"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                        @if(isset($item->sifat_surat) && $item->sifat_surat > 0)
                                                                            <a class="dropdown-item" href="{{ url('/disposisi/'.$item->enc_id.'/'.$item->id) }}"><i class="dropdown-icon" data-feather="eye"></i><span>Lihat Disposisi</span></a>

                                                                            @if(!$item->tembusan)
                                                                                @if($item->teruskan <> 1 and $level <= 4)
                                                                                    {{-- @if(($item->jenis<2 && !$item->plh))  --}}
                                                                                    @if($item->jenis < 2)
                                                                                        {{-- jenis 2 = sudah di-disposisi --}}
                                                                                        {{-- <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalTeruskan{{$item->id}}" ><i class="dropdown-icon" data-feather="arrow-right"></i><span>Teruskan</span></a> --}}
                                                                                        <a class="dropdown-item" href="#" onclick="teruskan({{ $item->id_surat }}, {{ $item->id }})"><i class="dropdown-icon" data-feather="arrow-right"></i><span>Teruskan</span></a>
                                                                                    @endif
                                                                                @else
                                                                                    @if($item->jenis<2)
                                                                                        {{-- <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalTeruskan{{$item->id}}" ><i class="dropdown-icon" data-feather="arrow-right"></i><span>Teruskan</span></a> --}}
                                                                                        <a class="dropdown-item" href="#" onclick="teruskan({{ $item->id_surat }}, {{ $item->id }})"><i class="dropdown-icon" data-feather="arrow-right"></i><span>Teruskan</span></a>
                                                                                    @endif
                                                                                    {{-- <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalTindakLanjut{{$item->id}}" ><i class="dropdown-icon" data-feather="book-open"></i><span>Tindak Lanjut</span></a> --}}
                                                                                @endif
                                                                                
                                                                                {{-- Tambahan Faridl 28 Agustus --}}
                                                                                {{-- <a class="dropdown-item" href="#" onclick="teruskan({{ $item->id_surat }}, {{ $item->id }})"><i class="dropdown-icon" data-feather="arrow-right"></i><span>Teruskan</span></a> --}}                                                                            @endif
                                                                        @else
                                                                            <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalReview{{$item->id}}" ><i class="dropdown-icon" data-feather="arrow-right"></i><span>Sifat Surat</span></a>
                                                                        @endif
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
                            <form method="GET" action="/sm/{{$item->id}}/hapus">
                                <button type="sumbit" class="btn btn-primary"><i class="fa fa-exclamation-triangle"></i> Hapus</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="modal fade" id="ModalTindakLanjut{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tindaklanjut Surat Masuk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ url('/disposisi_tindaklanjut/'.$item->id) }}">
                            @csrf
                            <input type="hidden" name="id_surat" id="id_surat" value="{{  $id_surat = $item->id_surat }}">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="sifat_surat"></label>
                                    <select class="custom-select" id="tindaklanjut" name="tindaklanjut" required>
                                        <option>--Pilih Tindakan--</option>
                                        <option value="P" {{ $item->tindaklanjut=='P' ? 'selected':'' }}>On Progress</option>
                                        <option value="F" {{ $item->tindaklanjut=='F' ? 'selected':'' }}>Selesai</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Perbaiki inputan
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Catatan Tindaklanjut</label>
                                    <input class="form-control" type="text" placeholder="Catatan Tindak Lanjut"
                                            id="catatan_disposisi" name="catatan_disposisi" value="{{ $item->catatan_disposisi }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}

            <div class="modal fade" id="ModalReview{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pilih Sifat Surat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ url('/disposisi/updateSifatSurat/'.$item->id_surat_masuk) }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="sifat_surat"></label>
                                    <select class="custom-select" id="sifat_surat" name="sifat_surat">
                                        <option>--Pilih Sifat--</option>
                                        <option value="1">Biasa</option>
                                        <option value="2">Penting</option>
                                        <option value="3">Rahasia (Pengaduan)</option>
                                        <option value="4">Rahasia (Kepegawaian)</option>
                                        <option value="5">Rahasia (Perkara Banding)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">

                                <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <!-- Modal Hapus-->
        @endforeach

        <div class="modal fade" id="ModalTeruskan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Teruskan Surat Masuk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <form method="POST" action="/disposisi/teruskanDisposisi/{{$item->id}}"> --}}
                    <form method="POST" action="{{ url('/disposisi/teruskanDisposisi/') }}">
                        @csrf
                        <input type="hidden" name="id_dispo_teruskan" id="id_dispo_teruskan">
                        <input type="hidden" name="id_surat_teruskan" id="id_surat_teruskan">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleDropdownFormEmail1">Teruskan Ke :</label>
                                <select class="form-control select-pegawai" name="kepada">
                                    <option disabled>Pilih</option>
                                    @foreach ($pegawai as $peg)
                                        <option value="{{$peg->nip}}">{{ $peg->nama_jabatan .' ('. $peg->name .')' }}</option>
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
        <!-- Modal -->
@endsection

@section ('style')
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-pegawai').select2();
        });

        function teruskan(id_surat, id_dispo) {
            $('#id_dispo_teruskan').val(id_dispo);
            $('#id_surat_teruskan').val(id_surat);
            $('#ModalTeruskan').modal('toggle');
            $('#ModalTeruskan').modal('show');
        }
    </script>
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
