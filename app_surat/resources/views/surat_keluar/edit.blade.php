@extends('layout.main')
@section('title', 'Edit Surat Keluar')

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
            <li class="breadcrumb-item active" aria-current="page">Edit Surat Keluar</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="align-left"></i></span></span>Edit Surat Keluar</h4>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <h5 class="hk-sec-title">Edit Surat Keluar</h5>
                            <p class="mb-25"></p>
                        </div>
                        <div class="col-sm d-flex justify-content-end align-items-start ">
                            <a class="btn btn-indigo btn-wth-icon btn-rounded icon-left" href="{{ url('/surat_keluar')}}"><span class="btn-text">Kembali</span> <span class="icon-label"><span class="feather-icon"><i data-feather="arrow-left-circle"></i></span> </span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <form action="{{ url('/surat_keluar/'.$surat->id.'/update')}}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                                @csrf
                                {{-- Input hidden untuk menyimpan variable id --}}
                                <input type="hidden" name="id" value="{{ $surat->id }}">
                                
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Kode Klasifikasi</label>
                                        {{-- <input class="form-control" id="klasifikasi" name="klasifikasi" placeholder="Kode Klasifikasi" value="{{ $surat->klasifikasi }}" type="text" required>
                                        <input id="kode" name="kode" value="{{ $surat->kode }}" type="hidden" >
                                        <div id="kodelist" ></div> --}}
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
                                    <div class="col-md-6 form-group">
                                        <label for="indek_berkas">Tujuan Surat</label>
                                        <input class="form-control" id="tujuan_surat" name="tujuan_surat" placeholder="Tujuan Surat" value="{{ $surat->tujuan_surat }}" type="text" >
                                    </div>
                                </div>

				<div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="input_tags">Tanggal Surat</label>
                                        <input class="form-control" type="text" name="tanggal_surat" id="tanggal_surat" value="{{ $surat->tanggal_surat }}" required/>
                                        <div class="invalid-feedback">  
                                            Perbaiki inputan
                                        </div> 
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Isi Ringkas</label>
                                        <textarea class="form-control" placeholder="isi ringkas" name="isi_ringkas" rows="3">{{ $surat->isi_ringkas }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Nama Penerima</label>
                                        <input class="form-control" id="nama_penerima" name="nama_penerima" placeholder="Nama Penerima" value="{{ $surat->nama_penerima }}" type="text">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="indek_berkas">Jabatan Penerima</label>
                                        <input class="form-control" id="jabatan_penerima" name="jabatan_penerima" placeholder="Jabatan Penerima" value="{{ $surat->jabatan_penerima }}" type="text">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Penandatangan</label>
                                        <input class="form-control" id="penandatangan_surat" name="penandatangan_surat" placeholder="Penandatangan Surat" value="{{ $surat->penandatangan_surat }}" type="text">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="indek_berkas">Jabatan Penandatangan</label>
                                        <input class="form-control" id="jabatan_penandatangan_surat" name="jabatan_penandatangan_surat" placeholder="Jabatan Penandatangan" value="{{ $surat->jabatan_penandatangan_surat }}" type="text">
                                    </div>
                                </div>

                                <div class="row">
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

</script>

<script type="text/javascript">
    $('input[name="tanggal_surat"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 2016,
        locale: {
			// format: 'DD-MM-YYYY'
			format: 'YYYY-MM-DD'
		}
	});
</script>


@endsection
