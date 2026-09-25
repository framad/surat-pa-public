@extends('layout.main')
@section('title', 'Catat Surat Keluar')

@section('css')
    <!-- select2 CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Pickr CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/pickr-widget/dist/pickr.min.css" rel="stylesheet" type="text/css" />

    <!-- Daterangepicker CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="hk-pg-wrapper">
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Surat Keluar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Catat Surat Keluar {{ $rhs ? 'Rahasia' : '' }}</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="align-left"></i></span></span>Catat Surat Keluar {{ $rhs ? 'Rahasia' : '' }}</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="hk-sec-title">Catat Surat Keluar {{ $rhs ? 'Rahasia' : '' }}</h5>
                            <p class="mb-25">Silahkan masukan data surat keluar yang akan dicatat</p>
                        </div>
                        <div class="col-sm d-flex justify-content-end align-items-start ">
                            <button class="btn btn-primary btn-wth-icon btn-rounded icon-left" id="btnBackdate" onclick="togglebackdate()">
                                <span class="btn-text">Nomor Back Date</span><span class="icon-label"><span class="feather-icon"><i data-feather="calendar"></i></span> </span>
                            </button> &nbsp;
                            <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/surat_keluar')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    Gagal Menyimpan Data:
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <form action="{{ url('/simpan_sk')}}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row" id="backdate" style="display: none;">
                                    <div class="col-md-6 form-group">
                                        <label>Nomor Backdate</label>
                                        <div class="input-group mb-6">
                                            <input type="text" class="form-control" placeholder="Nomor Backdate" id="nomor-backdate" name="nomor_backdate" readonly>
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#modal-backdate">Cari Nomor</button>
                                                <button class="btn btn-outline-danger" type="button" onclick="hapusNomor()">Hapus</button>
                                              </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Kode Klasifikasi</label>
                                        {{-- <input class="form-control" id="klasifikasi" name="klasifikasi" placeholder="Kode Klasifikasi" value="" type="text" required> --}}
                                        {{-- <input id="kode" name="kode" value="" type="hidden" > --}}
                                        {{-- <div id="kodelist" ></div> --}}
                                        
                                        <select class="form-control select-kode" id="kode" name="kode" required>
                                            <option value="0" selected disabled>--Pilih Klasifikasi--</option>
                                            @foreach ($klasifikasi as $item)
                                                <option value={{ $item->id.'-'.$item->kode.'-'.$item->nama }}>
                                                    {{ $item->kode.' ('.$item->nama.')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div> 
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="indek_berkas">Tujuan Surat</label>
                                        <input class="form-control" id="tujuan_surat" name="tujuan_surat" placeholder="Tujuan Surat" value="" type="text" required>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- <div class="col-md-6 form-group">
                                        <label for="lastName">Nomor Surat</label>
                                        <input class="form-control" id="nomor_surat" name="nomor_surat" placeholder="Nomor Surat" value="" type="text" required>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div> 
                                    </div> --}}
                                    <div class="col-md-6 form-group">
                                        <label for="input_tags">Tanggal Surat</label>
                                        <input class="form-control" type="text" name="tgl_surat" id="tgl_surat" value="" required/>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div> 
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sifat_surat">Sifat Surat</label>
                                        <select class="custom-select" id="sifat_surat" name="sifat_surat" required>
                                            <option selected>--Pilih Sifat--</option>
                                            @if ($rhs==NULL)
                                                <option value="1">Biasa</option>
                                                <option value="2">Penting</option>
                                            @elseif ($rhs!=NULL)
                                                <option value="3">Rahasia (Pengaduan)</option>
                                                <option value="4">Rahasia (Kepegawaian)</option>
                                                <option value="5">Rahasia (Perkara Banding)</option>
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div> 
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Isi Ringkas</label>
                                        <textarea class="form-control" placeholder="isi ringkas" name="isi_ringkas" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Nama Penerima</label>
                                        <input class="form-control" id="nama_penerima" name="nama_penerima" placeholder="Nama Penerima" value="" type="text">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="indek_berkas">Jabatan Penerima</label>
                                        <input class="form-control" id="jabatan_penerima" name="jabatan_penerima" placeholder="Jabatan Penerima" value="" type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 ">
                                        <label for="inputPassword3" >File Surat (PDF)</label>
                                            <div class="custom-file mb-3">
                                              <input type="file" class="custom-file-input @error ('file') is-invalid @enderror" id="file" name="file" :value="old('file')" accept="application/pdf">
                                              <label class="custom-file-label" for="customFile">Choose File</label>
                                              @error ('file')  
                                                  <div id="validationServer03Feedback" class="invalid-feedback">
                                                      {{$errors->first('file')  }}
                                                  </div>
                                              @enderror
                                            </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Penandatangan</label>
                                        <input class="form-control" id="penandatangan_surat" name="penandatangan_surat" placeholder="Penandatangan Surat" value="" type="text">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="indek_berkas">Jabatan Penandatangan</label>
                                        <input class="form-control" id="jabatan_penandatangan_surat" name="jabatan_penandatangan_surat" placeholder="Jabatan Penandatangan" value="" type="text">
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-wth-icon btn-lg"> <span class="icon-label"><span class="feather-icon"><i data-feather="save"></i></span> </span><span class="btn-text">Simpan</span></button>
                                {{-- <button class="btn btn-primary" type="submit">Simpan</button> --}}
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

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
<!-- /Main Content -->
</div>

{{-- Modal --}}
<div class="modal fade" id="modal-backdate" tabindex="-1" role="dialog" aria-labelledby="modal-backdate" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-backdate">Pilih Nomor Back Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Cari Nomor Berdasarkan Tanggal Surat</p>
                <br/>
                <div class="input-group mb-3">
                    <input class="form-control" type="text" name="cari_tgl" id="cari_tgl" value=""/>
                    <div class="input-group-append">
                      <button class="btn btn-outline-primary" type="button" onclick="cariNomor('{{ $rhs }}')">Cari</button>
                    </div>
                </div>
                <br/>
                <table id="datable_1" class="table table-hover w-100 display pb-30">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nomor Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Jumlah</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="list-nomor-backdate">
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nomor</th>
                            <th>Tgl Surat</th>
                            <th>Jumlah</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
{{-- End Modal --}}

@endsection



@section('toast')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select-kode').select2();
    });

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#klasifikasi').on('keyup', function(){
        search();
    });
    $('#klasifikasi').on('change', function(){
        var arr = $('#klasifikasi').val().split('-');
        $('#kode').val(arr[0]);
    });

    // search();
    function search(){
        var kode = $('#klasifikasi').val();
        $.ajax({
           type:'POST',
           url:"{{ route('klasifikasi.cari') }}",
           data:{kode:kode},
           success:function(data){
                // console.log(data);
                $('#kodelist').fadeIn();  
                $('#kodelist').html(data);
           }
        });
    }

    $(document).on('click', 'li', function(){
        var text = $(this).text();
        var arr = text.split('-');
        $('#klasifikasi').val(text);
        $('#kode').val(arr[0]);
        $('#kodelist').fadeOut();  
    });
</script>


<script type="text/javascript">
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    function togglebackdate() {
        var visible = $('#backdate').is(":visible");
        if(visible) {
            $('#backdate').hide();
        } else {
            $('#backdate').show();
            $('#btnBackdate').hide();
        }
    }

    function cariNomor(rhs) {
        console.log(rhs);
        var tanggal = $('#cari_tgl').val();
        $.ajax({
           type:'POST',
           url:"{{ route('nomor.cari') }}",
           data:{tanggal,rhs},
           success:function(data) {
                console.log(data);
                $('#list-nomor-backdate').html(data);
           }
        });
    }

    function pilihNomor(param) {
        console.log('pilihnomor', param);
        var split = param.split('|');
        $('#nomor-backdate').val(split[0]);
        $('#tgl_surat').val(split[1]);
        $('#modal-backdate').modal('hide');
        $('#list-nomor-backdate').empty();
    }
    function hapusNomor() {
        $('#nomor-backdate').val('');
        $('#backdate').hide();
        $('#btnBackdate').show();
        $('#list-nomor-backdate').empty();
    }
</script>

<script type="text/javascript">
    $('input[name="tgl_surat"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 2016,
        locale: {
			format: 'DD-MM-YYYY'
		}
	});

    $('input[name="cari_tgl"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 2016,
        locale: {
			format: 'DD-MM-YYYY'
		}
	});
</script>

@endsection
