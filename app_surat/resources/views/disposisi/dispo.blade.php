@extends('layout.main')
@section('title', 'History Disposisi')
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
            <li class="breadcrumb-item"><a href="#">Surat Masuk / Kotak Surat</a></li>
            <li class="breadcrumb-item active" aria-current="page">Disposisi</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="mail"></i></span></span>Disposisi {{ $tembusan ? " (Tembusan)" : "" }}</h4>
        </div>
        <!-- /Title -->
        {{-- {{ session()->get('tahun_anggaran') }} --}}
        {{-- {{ session()->all() }} --}}

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
                                <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/disposisi')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a>
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
                                <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> ERROR data tidak tersimpan.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif
                        {{-- <div class="row">
                            <div class="col-sm">
                                <h5 class="hk-sec-title">Disposisi / Teruskan</h5>
                                <p class="mb-40">Disposis / Teruskan Surat Masuk</p>
                            </div>
                            <div class="col-sm d-flex justify-content-end align-items-start ">
                                <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="{{ url('/catat_sm')}}"><span class="btn-text">Catat Surat Baru</span> <span class="icon-label"><span class="feather-icon"><i data-feather="plus-circle"></i></span> </span></a>
                            </div>
                        </div> --}}
                        {{-- @foreach ($suratmasuk as $suratmasuk)  --}}
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h6> Surat Dari :</h6>
                                <span class="pl-10 text-dark">{{$suratmasuk->dari}}</span>
                            </div>
                            <div class="col-md-6">
                                <h6> Tanggal Diterima :</h6>
                                <span class="pl-10 text-dark">{{date('d-m-Y', strtotime($suratmasuk->tgl_diterima))}}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h6> Nomor Surat :</h6>
                                <span class="pl-10 text-dark">{{$suratmasuk->no_surat}}</span>
                            </div>
                            <div class="col-md-6">
                                <h6> Tanggal Surat :</h6>
                                <span class="pl-10 text-dark">{{date('d-m-Y', strtotime($suratmasuk->tgl_surat))}}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6> Isi ringkas :</h6>
                                <span class="pl-10 text-dark">{{$suratmasuk->isi_ringkas}}</span>
                            </div>
                            <div class="col-md-6">
                                {{-- <a href="" data-toggle="modal" data-target="#modalPdf"><image src="{{ asset('images/pdf.png')}}" width="50" ></a>  --}}
                                @if (!empty($suratmasuk->file))
                                    <a href="{{ asset('dok/' . '/' . $suratmasuk->file) }}" target="_blank"><image src="{{ asset('images/pdf.png')}}" width="50" ></a>
                                @else
                                    <image src="{{ asset('images/nopdf.webp')}}" width="50">
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6> No Agenda :</h6>
                                <span class="pl-10 text-dark">{{$suratmasuk->no_agenda}}</span>
                            </div>
                        </div>
                        <hr>
                        {{-- @endforeach --}}

                    </section>

                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col">
                                <h5 class="hk-sec-title">History Disposisi</h5>
                                <p class="mb-25">History disposisi yang telah direkam</p>
                            </div>

                            @if (!$tembusan)
                                <div class="col-sm d-flex justify-content-end align-items-start ">
                                    {{-- @dd($disposisi->plh) --}}
                                    @if($level <= 4 && (!$disposisi->plh || ($disposisi->plh==Auth::user()->nip)))
                                        <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="{{ url('/disposisi/create/'.$id_surat_enc.'/'.$id)}}"><span class="btn-text">
                                            Tambah Disposisi</span> <span class="icon-label"><span class="feather-icon"><i data-feather="plus-circle"></i></span></span></a>
                                    @elseif($disposisi->plh == Auth::user()->nip)
                                        <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="{{ url('/disposisi/create/'.$id_surat_enc.'/'.$id)}}"><span class="btn-text">
                                            Tambah Disposisi</span> <span class="icon-label"><span class="feather-icon"><i data-feather="plus-circle"></i></span></span></a>
                                        &nbsp; <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="" data-toggle="modal" data-target="#ModalTindakLanjut"><span class="btn-text">
                                            Tindak Lanjut</span><span class="icon-label"><span class="feather-icon"><i data-feather="book-open"></i></span></span></a>
                                    @endif
                                    @if($level >=3 && !$disposisi->plh)
                                        &nbsp; <a class="btn btn-primary btn-wth-icon btn-rounded icon-right" href="" data-toggle="modal" data-target="#ModalTindakLanjut"><span class="btn-text">
                                            Tindak Lanjut</span><span class="icon-label"><span class="feather-icon"><i data-feather="book-open"></i></span></span></a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <!-- Button trigger modal -->
                                <div class="table-wrap" style="overflow-x: scroll;">
                                     <table id="table" class="table table-hover w-100 display pb-30">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Disposisi</th>
                                                <th>Isi Disposisi</th>
                                                <th>Tindaklanjut</th>
                                                <th>Diterima</th>
                                                <th>Selesai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($history as $row)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
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
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-purple-dark-4">
                        <h5 class="modal-title text-white">File Surat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <iframe src ="{{ asset('dok').'/'.$suratmasuk->file}}" width="100%" height="600px"></iframe> --}}
                    </div>
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
        <div class="modal fade" id="modalPdf{{$suratmasuk->id_disposisi}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-purple-dark-4">
                        <h5 class="modal-title text-white">File Surat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <iframe src ="{{ asset('dok').'/'.$suratmasuk->file}}" width="100%" height="600px"></iframe> --}}
                        {{-- <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p> --}}
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalTindakLanjut" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tindaklanjut Surat Masuk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ url('/disposisi_tindaklanjut/'.$id) }}">
                        @csrf
                        <input type="hidden" name="id_surat" id="id_surat" value="{{  $id_surat = $suratmasuk->id }}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tindaklanjut"></label>
                                <select onchange="onTLChange()" class="custom-select" id="tindaklanjut" name="tindaklanjut">
                                    <option value="">--Pilih Tindakan--</option>
                                    <option value="P" {{ $disposisi->tindaklanjut=='P' ? 'selected':'' }}>On Progress</option>
                                    <option value="F" {{ $disposisi->tindaklanjut=='F' ? 'selected':'' }}>Selesai</option>
                                </select>
                                <div class="invalid-feedback" id="tindaklanjut_invalid">
                                    Tindakan harus dipilih
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="catatan">Catatan Tindak Lanjut</label>
                                <input class="form-control" type="text" placeholder="Catatan Tindak Lanjut" required
                                        id="catatan_disposisi" name="catatan_disposisi" value="{{ $disposisi->catatan_disposisi }}">
                                <div class="invalid-feedback">
                                    Catatan harus diisi
                                </div>
                            </div>

                            <div id="arsip" style="display:none;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="arsipkan" name="arsipkan"
                                        {{ $suratmasuk->arsipkan ? 'checked':'' }}>
                                    <label class="form-check-label" for="arsipkan">
                                        Arsipkan
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_arsip"></label>
                                    <select onchange="jenisChange()" class="custom-select" id="jenis_arsip" name="jenis_arsip">
                                        <option value="">--Pilih Jenis Arsip--</option>
                                        <option value="S" {{ $disposisi->jenis_arsip=='S' ? 'selected':'' }}>Kesekretariatan</option>
                                        <option value="P" {{ $disposisi->jenis_arsip=='K' ? 'selected':'' }}>Kepaniteraan</option>
                                    </select>
                                    <div class="invalid-feedback" id="arsip_invalid">
                                        Jenis arsip harus dipilih
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="catatan">Lokasi Arsip</label>
                                    <input class="form-control" type="text" placeholder="Lokasi Arsip"
                                            id="lokasi_arsip" name="lokasi_arsip" value="{{ $disposisi->lokasi_arsip }}">
                                    <div class="invalid-feedback">
                                        Lokasi arsip harus diisi
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnTindakLanjut" disabled>
                                <i class="fa fa-arrow-right"></i> Simpan
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
        <div class="modal fade" id="modalDisposisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-purple-dark-4">
                        <h5 class="modal-title text-white">File Surat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <iframe src ="{{ asset('dok').'/'.$suratmasuk->file}}" width="100%" height="600px"></iframe> --}}
                        {{-- <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p> --}}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

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
        function onTLChange() {
            var val = $("#tindaklanjut").val();
            if (val=='') {
                $("#btnTindakLanjut").attr("disabled", true);
                $("#tindaklanjut_invalid").show();
                $("#arsipkan").prop("checked", false);
                $("#arsip").hide();
                clearArsipkan();
            } else {
                $("#btnTindakLanjut").attr("disabled", false);
                $("#tindaklanjut_invalid").hide();

                if (val=='F') {
                    $("#arsip").show();
                    $("#jenis_arsip").attr("disabled", true);
                    $("#lokasi_arsip").attr("disabled", true);
                } else {
                    $("#arsip").hide();
                    clearArsipkan();
                }
            }
        }

        $('#arsipkan').change(function(){
            if($(this).is(':checked')){
                $("#btnTindakLanjut").attr("disabled", true);
                $("#arsip_invalid").show();
                $("#jenis_arsip").attr("disabled", false);
                $("#lokasi_arsip").attr("disabled", false);
            } else {
                clearArsipkan();
                $("#btnTindakLanjut").attr("disabled", false);
                $("#arsip_invalid").hide();
                $("#jenis_arsip").attr("disabled", true);
                $("#lokasi_arsip").attr("disabled", true);
            }
        });

        function jenisChange() {
            var jenis = $("#jenis_arsip").val();
            if (jenis=='') {
                $("#btnTindakLanjut").attr("disabled", true);
                $("#arsip_invalid").show();
            } else {
                $("#btnTindakLanjut").attr("disabled", false);
                $("#arsip_invalid").hide();
            }
        }

        function clearArsipkan() {
            $("#arsipkan").prop("checked", false);
            $("#jenis_arsip").val('');
            $("#lokasi_arsip").val('');
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

@section('style')
<style>
    #table > tbody > tr {
        font-size: 12px;
    }
</style>
@endsection
