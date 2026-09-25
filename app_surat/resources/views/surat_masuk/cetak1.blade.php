
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>e-Surat | Cetak Tanda Terima </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css"> --}}
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    
    <!-- info row -->
    <table style="border-collapse: collapse; width: 100%;">
        <tbody>
            <tr >
                <td style="width: 15%;"><image src="{{ asset('images/logo.png')}}" width='100'></image></td>
                <td style="width: 85%; text-align: center;">
                <h2>PENGADILAN TINGGI AGAMA BANDUNG</h2>
                Jl. Soekarno-Hatta No. 714 - Telp. (022) 7810365 Kode Pos 40293 <br>Home Page : <a href="http://www.pta-bandung.go.id">www.pta-bandung.go.id</a> / email : surat.ptajawabarat@gmail.com</td>
            </tr>
        </tbody>
    </table>
    {{-- <span class="border-bottom-1"></span> --}}
    <table border="1" width="100%" class="mt-3">
        <tr>
            <td>    </td>
        </tr>
    </table>
    <div class="row mt-5">
        <div class="col-12" style="text-align: center;">
          <h4 class="page-header">
            <i class="fas fa-globe"></i> TANDA TERIMA SURAT MASUK
            
          </h4>
        </div>
        <!-- /.col -->
      </div>
    <div class="row">
      <div class="col-sm-4 invoice-col">
        Telah diterima dari :
        <address>
          <strong>@foreach ($surat as $item) {{$item->dari}}</strong><br>
          {{-- 795 Folsom Ave, Suite 600<br>
          San Francisco, CA 94107<br>
          Phone: (555) 539-1037<br>
          Email: john.doe@example.com --}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Diterima Tanggal : {{date('d-m-Y', strtotime($item->tgl_diterima))}} @endforeach</b><br>
        {{-- <br>
        <b>Order ID:</b> 4F3S8J<br>
        <b>Payment Due:</b> 2/22/2014<br>
        <b>Account:</b> 968-34567 --}}
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row mt-2">
      <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
          <tr>
            <th>NO</th>
            <th>NO SURAT & TANGGAL</th>
            <th>ISI RINGKAS</th>
            <th>PENGIRIM</th>
            <th>KETERANGAN</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($surat as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->no_surat}}<br>{{date('d-m-Y', strtotime($item->tgl_surat))}}</td>
                    <td>{{$item->isi_ringkas}}</td>
                    <td>{{$item->dari}}</td>
                    <td>{{$item->keterangan}}</td>
                </tr>
            @endforeach
         
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
       
      </div>
      <!-- /.col -->
      <div class="col-6">
        <p class="">Diterima Oleh</p>
        <p style="text-align: justify;">&nbsp;</p>
        <p class="">@foreach ($surat as $item) {{$item->name}} @endforeach</p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
