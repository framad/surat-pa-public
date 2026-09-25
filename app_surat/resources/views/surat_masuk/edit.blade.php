@extends('layout.main')
@section('title', 'Edit Surat Masuk')

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
            <li class="breadcrumb-item"><a href="#">Surat Masuk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Surat Masuk</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="align-left"></i></span></span>Edit Surat Masuk</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="hk-sec-title">Edit Surat Masuk</h5>
                            <p class="mb-25">Silahkan masukan data surat masuk yang akan diedit</p>
                        </div>
                        <div class="col-sm d-flex justify-content-end align-items-start ">
                            {{-- <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/sm')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a> --}}
                            @if($surat->sifat_surat < 3)
                                <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/sm')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a>
                            @else
                                <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/sm_rhs')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a>
                            @endif
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

                            <form action="{{ url('/sm/'.$surat->id.'/update') }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                                @csrf
                                {{-- Input hidden untuk menyimpan variable id --}}
                                <input type="hidden" name="id" value="{{$surat->id}}">

                                <div class="row">                                
                                    <div class="col-md-6 form-group">
                                        <label for="firstName">Asal Surat</label>
                                        <input class="form-control" id="asal" name="asal" placeholder="Pengirim Surat" value="{{$surat->dari}}" type="text" required>
                
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div> 
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="lastName">Nomor Surat</label>
                                        <input class="form-control" id="nomor_surat" name="nomor_surat" placeholder="Nomor Surat" value="{{$surat->no_surat}}" type="text" required>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div> 
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <label for="address">Isi Ringkas</label>
                                    {{-- <input class="form-control" id="isi_ringkas" placeholder="isi ringkas" type="text" name="isi_ringkas" value="{{$surat->isi_ringkas}}" required> --}}
                                    <textarea class="form-control" placeholder="Isi Ringkas" name="isi_ringkas" rows="3" required>{{ $surat->isi_ringkas }}</textarea>
                                    <div class="invalid-feedback">  
                                        Perbaiki inputan
                                    </div> 
                                </div>


                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="kode">Kode Klasifikasi</label>
                                        {{-- <input class="form-control" id="kode" name="kode" placeholder="Kode Klasifikasi" value="{{$surat->kode}}" type="text" required> --}}
                                        <select class="form-control select-kode" id="kode" name="kode">
                                            <option value="0" disabled>--Pilih Klasifikasi--</option>
                                            @foreach ($klasifikasi as $item)
                                                <option value={{ $item->id.'-'.$item->kode.'-'.$item->nama }}
                                                    {{ $surat->id_klasifikasi==$item->id ? 'selected':'' }}>
                                                    {{ $item->kode.' ('.$item->nama.')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label for="inputPassword3" >File Surat (PDF)</label>
                                        <div class="custom-file mb-3">
                                            <input type="file" class="custom-file-input @error ('file') is-invalid @enderror" id="file" name="file" :value="old('file')" accept="application/pdf" value="{{$surat->file}}">
                                            <label class="custom-file-label" for="customFile">Choose File</label>
                                            <div id="invalid-file" class="invalid-feedback">
                                                <p id="file-error">Perbaiki inputan</p>
                                                {{$errors->first('file')  }}
                                            </div>
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
                                        <label for="input_tags">Tanggal Surat</label>
                                        <input class="form-control" type="text" name="tgl_surat" value="{{ $surat->tgl_surat }}" required/>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div> 
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="sifat_surat">Sifat Surat</label>
                                        <select class="custom-select" id="sifat_surat" name="sifat_surat">
                                            <option value="NULL" {{ $surat->sifat_surat==0 ? 'selected' : '' }}>--Pilih Sifat--</option>
                                            <option value="1" {{ $surat->sifat_surat==1 ? 'selected' : '' }}>Biasa</option>
                                            <option value="2" {{ $surat->sifat_surat==2 ? 'selected' : '' }}>Penting</option>
                                            <option value="3" {{ $surat->sifat_surat==3 ? 'selected' : '' }}>Rahasia (Pengaduan)</option>
                                            <option value="4" {{ $surat->sifat_surat==4 ? 'selected' : '' }}>Rahasia (Kepegawaian)</option>
                                            <option value="5" {{ $surat->sifat_surat==5 ? 'selected' : '' }}>Rahasia (Perkara Banding)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="indek_berkas">Keterangan</label>
                                        <input class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" value="{{$surat->keterangan}}" type="text">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="indek_berkas">No Agenda</label>
                                        <input class="form-control" id="no_agenda" name="no_agenda" placeholder="No Agenda" value="{{$surat->no_agenda}}" type="text" required>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-wth-icon btn-lg" id="btn-submit">
                                    <span class="icon-label"><span class="feather-icon"><i data-feather="save"></i></span> </span><span class="btn-text">Simpan</span>
                                </button>
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

    (function() {
      'use strict';

        let fileInput = document.getElementById("file");
        let fileSubmit = document.getElementById("btn-submit");
        fileInput.addEventListener("change", function () {
            if (fileInput.files.length > 0) {
                const fileSize = fileInput.files.item(0).size;
                const fileMb = fileSize / 1024 ** 2;
                //console.log('file Mb', fileMb);
                if (fileMb >= 5) {
                    $("#invalid-file").show();
                    $("#file-error").text("Maximum file size 5 MB");
                    alert("Maximum file size 5 MB");
                    fileSubmit.disabled = true;
                } else {
                    $("#invalid-file").hide();
                    $("#file-error").text("");
                    fileSubmit.disabled = false;
                }
            }
        });

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

    $('#kode').on('keyup', function(){
        search();

        
    });
    // search();
    function search(){

        var kode = $('#kode').val();
        $.ajax({
           type:'POST',
           url:"{{ route('klasifikasi.cari') }}",
           data:{kode:kode},
           success:function(data){
            //   alert(data.success);
                // console.log(data);
                $('#kodelist').fadeIn();  
                $('#kodelist').html(data);

                
              
           }
        });
        
        
        
    }

    $(document).on('click', 'li', function(){  
        $('#kode').val($(this).text());  
        $('#kodelist').fadeOut();  
    });  
    
    
</script>


<script type="text/javascript">

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

</script>

<script type="text/javascript">
    
    $('input[name="tgl_surat"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 2016,
        locale: {
			// format: 'DD-MM-YYYY'
			format: 'YYYY-MM-DD'
		}
	});

    $('#nomor_surat').on("input", function () {
        $(this).val($(this).val().replace(/ /g, ""));
    });
</script>


@endsection
