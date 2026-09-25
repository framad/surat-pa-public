{{-- @dd($data) --}}
@extends('layout.main')
@section('title', 'Tambah Disposisi')
@section('css')
    <!-- Data Table CSS -->
    <link href="{{ asset('style/marvin/html') }}/vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('style/marvin/html') }}/vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- select2 CSS -->
    <link href="{{ asset('style/marvin/html') }}/vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />


    <link href="{{ asset('style/chosen.css') }}" rel="stylesheet" type="text/css" />

    <style>

    </style>
@endsection

@section('content')
    <div class="hk-pg-wrapper">
        <!-- Breadcrumb -->
        <nav class="hk-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light bg-transparent">
                <li class="breadcrumb-item"><a href="#">Surat Masuk / Kotak Surat</a></li>
                <li class="breadcrumb-item active" aria-current="page">Disposisi</li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Disposisi</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <!-- Container -->
        <div class="container">
            <!-- Title -->
            <div class="hk-pg-header">
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                data-feather="mail"></i></span></span>Tambah Disposisi</h4>
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
                                <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left"
                                    href="{{ url('/disposisi/' . $id_surat_enc . '/' . $id) }}"><span class="btn-text">Kembali</span>
                                    <span class="icon-label"><span class="feather-icon"><i
                                                data-feather="arrow-left-circle"></i></span> </span></a>
                            </div>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success alert-wth-icon alert-dismissible fade show" role="alert">
                                <span class="alert-icon-wrap"><i class="zmdi zmdi-check-circle"></i></span>
                                {{ session()->get('status') }}.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
                                <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> ERROR data tidak
                                tersimpan.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h6> Surat Dari :</h6>
                                <span class="pl-10 text-dark">{{ $data->dari }}</span>
                            </div>
                            <div class="col-md-6">
                                <h6> Tanggal Diterima :</h6>
                                <span class="pl-10 text-dark">{{ date('d-m-Y', strtotime($data->tgl_diterima)) }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h6> Nomor Surat :</h6>
                                <span class="pl-10 text-dark">{{ $data->no_surat }}</span>
                            </div>
                            <div class="col-md-6">
                                <h6> Tanggal Surat :</h6>
                                <span class="pl-10 text-dark">{{ date('d-m-Y', strtotime($data->tgl_surat)) }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6> Isi ringkas :</h6>
                                <span class="pl-10 text-dark">{{ $data->isi_ringkas }}</span>
                            </div>
                            <div class="col-md-6">
                                <a href="" data-toggle="modal" data-target="#modalPdf">
                                    <image src="{{ asset('images/pdf.png') }}" width="50">
                                </a>
                            </div>
                        </div>
                        <hr>
                    </section>

                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <h5 class="hk-sec-title">Tambah Disposisi Baru</h5>
                                <p class="mb-25">Silahkan masukan data disposisi yang akan dicatat</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                {{-- <form action="{{ url('/disposisi/store') }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate> --}}
                                {{-- @csrf --}}
                                <form class="needs-validation" enctype="multipart/form-data" novalidate>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input type="hidden" id="id_disposisi" name="id_disposisi" value="{{ $id }}">
                                            <input type="hidden" id="id_surat" name="id_surat" value="{{ $data->id }}">
                                            <label for="kepada">Disposisi Ke :</label>
                                            <select class="form-control select-pegawai" placeholder="disposisi kepada" id="kepada" name="kepada">
                                                <option disabled>Pilih</option>
                                                @foreach ($pegawai as $peg)
                                                    <option value="{{ $peg->nip }}">
                                                        {{ $peg->nama_jabatan . " (" . $peg->name . ")" }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="invalid-feedback">
                                                Perbaiki inputan
                                            </div>
                                        </div>
                                    </div>

                                    {{-- tembusan --}}
                                    <div class="form-group">
                                        <label for="address">Tembusan</label>
                                        <select data-placeholder="-Pilih Tembusan-" multiple class="chosen-select" tabindex="8">
                                            @foreach ($tembusan as $opsi)
                                                <option>{{ $opsi->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Pesan Disposisi</label>
                                        {{-- <input class="form-control" id="isi_disposisi" placeholder="Pesan Disposisi" type="text" name="isi_disposisi" required> --}}
                                        <textarea class="form-control" placeholder="Isi Disposisi" id="isi_disposisi" name="isi_disposisi" rows="3"></textarea>

                                        <div class="invalid-feedback">
                                            Perbaiki inputan
                                        </div>
                                    </div>

                                    <button class="btn btn-primary btn-wth-icon btn-lg" onclick="simpan(event)">
                                        <span class="icon-label">
                                            <span class="feather-icon"><i data-feather="save"></i></span>
                                        </span>
                                        <span class="btn-text">Simpan</span>
                                    </button>
                                    {{-- <button class="btn btn-primary" type="submit">Simpan</button> --}}
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-purple-dark-4">
                        <h5 class="modal-title text-white">File Surat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe src="{{ asset('dok') . '/' . $data->file }}" width="100%" height="600px"></iframe>
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
                        <a href="https://www.facebook.com/pta.bandung"
                            class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span
                                class="btn-icon-wrap"><i class="fa fa-facebook"></i></span></a>
                        <a href="https://www.instagram.com/ptabandung/"
                            class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span
                                class="btn-icon-wrap"><i class="fa fa-instagram"></i></span></a>
                        <a href="https://www.youtube.com/channel/UCpPzjZIJqZixAg7ZWKLAORg"
                            class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span
                                class="btn-icon-wrap"><i class="fa fa-youtube"></i></span></a>
                    </div>
                </div>
            </footer>
        </div>
        <!-- /Footer -->
    </div>

    <!-- Toastr JS -->

    <!-- Modal -->
    {{-- @foreach ($data as $data) --}}
    <div class="modal fade" id="modalPdf{{ $data->id_disposisi }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-purple-dark-4">
                    <h5 class="modal-title text-white">File Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="{{ asset('dok') . '/' . $data->file }}" width="100%" height="600px"></iframe>
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
    <div class="modal fade" id="ModalHapus{{ $data->id_disposisi }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Surat Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    {{-- <form method="GET" action="/sm/{{$data->id}}/hapus"> --}}
                    <form method="GET" action="{{ url('/sm/' . $data->id . '/hapus') }}">
                        <button type="sumbit" class="btn btn-primary"><i class="fa fa-exclamation-triangle"></i>
                            Hapus</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Hapus-->
    {{-- @endforeach --}}
    <!-- Modal -->
    <div class="modal fade" id="modalDisposisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-purple-dark-4">
                    <h5 class="modal-title text-white">File Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <iframe src ="{{ asset('dok').'/'.$data->file}}" width="100%" height="600px"></iframe> --}}
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

@section('toast')
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
    <script src="{{ asset('style/marvin/html') }}/vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/dist/js/toast-data.js"></script>

    <!-- Data Table JavaScript -->
    <script src="{{ asset('style/marvin/html') }}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js">
    </script>
    <script src="{{ asset('style/marvin/html') }}/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/jszip/dist/jszip.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('style/marvin/html') }}/dist/js/dataTables-data.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- multi select tembusan --}}
    <script src="{{ asset('js/chosen.jquery.min.js')}}"></script>


    <script>
        $(document).ready(function() {
            $('.select-pegawai').select2();
        });

        $(function(){
            $(".chosen-select").chosen();
        })
    </script>

    <script>
        function simpan(event) {
            event.preventDefault();

            // ajax submit
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var id_disposisi = $("#id_disposisi").val();
            var kepada = $("#kepada").val();
            var id_surat = $("#id_surat").val();
            var isi_disposisi = $("#isi_disposisi").val();
            var tembusan = [];
            $(".search-choice span").each(function() {
                var row = $(this).text();
                tembusan.push(row);
            });

            $.ajax({
                type:'POST',
                url:"{{ route('simpan_disposisi') }}",
                data:{
                    id_disposisi,
                    kepada,
                    id_surat,
                    isi_disposisi,
                    tembusan
                },
                success:function(data) {
                    console.log(data);
                    window.location = data;
                    // session(['status' => data.message]);
                    // return redirect("{{ route('disposisi') }}");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    // session(['error' => textStatus]);
                    // return redirect("{{ route('disposisi') }}");
                }
            });
        }
    </script>

    @if (session()->has('status'))
        <script>
            $(document).ready(function() {
                "use strict";
                $.toast({
                    heading: 'Berhasil',
                    text: '<i class="jq-toast-icon ti-light-bulb"></i><p>Data telah berhasil disimpan.</p>',
                    position: 'top-right',
                    loaderBg: '#7a5449',
                    class: 'jq-has-icon jq-toast-info',
                    hideAfter: 3500,
                    stack: 6,
                    showHideTransition: 'fade'
                });
            });
        </script>
    @endif
@endsection
