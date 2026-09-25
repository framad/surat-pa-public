<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>e-Surat | History Disposisi </title>

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
    <table class="tbl-header" style="width: 100%;">
        <tbody>
            <tr class="tbl-header">
                <td class="tbl-header" style="width: 20%; text-align: center;" rowspan="2"><image src="{{ asset('images/logo.png')}}" width='50'></image></td>
                <td class="tbl-header" style="width: 80%; text-align: center;" colspan="3">
                    <h5>PENGADILAN TINGGI AGAMA BANDUNG</h5>
                </td>
            </tr>
            <tr class="tbl-header">
                <td class="tbl-header" style="text-align: center;" colspan="3">
                    <h5>HISTORI DISPOSISI SURAT MASUK</h5>
                </td>
            </tr>
            {{-- <tr class="tbl-header">
                <td class="tbl-header" style="text-align: center;">
                    Kode Dokumen <br/>
                    FM/AS/21/2
                </td>
                <td class="tbl-header" style="text-align: center;">
                    Tanggal Pembuatan <br/>
                    01/03/2018
                </td>
                <td class="tbl-header" style="text-align: center;">
                    Tanggal Revisi <br/>
                    08/06/2018
                </td>
                <td class="tbl-header" style="text-align: center;">
                    Tanggal Efektif <br/>
                    08/06/2018
                </td>
            </tr> --}}
        </tbody>
    </table>
        
    <table style="width: 100%;" class="mt-3">
        <tr>
            <td class="tbl-surat" style="width: 18%;">Nomor Agenda</td>
            <td class="tbl-surat" style="width: 2%;">:</td>
            <td class="tbl-surat" style="width: 43%;">{{ $surat->no_agenda }}</td>
            <td class="tbl-surat" style="width: 15%;">Sifat Surat</td>
            <td class="tbl-surat" style="width: 2%;">:</td>
            <td class="tbl-surat" style="width: 20%;">{{ $surat->sifat_surat }}</td>
        </tr>
        <tr>
            <td class="tbl-surat">Nomor Surat</td>
            <td class="tbl-surat">:</td>
            <td class="tbl-surat">{{ $surat->no_surat }}</td>
            <td class="tbl-surat">Tanggal Surat</td>
            <td class="tbl-surat">:</td>
            <td class="tbl-surat">{{ date('d-m-Y', strtotime($surat->tgl_surat)) }}</td>
        </tr>
        <tr>
            <td class="tbl-surat">Perihal</td>
            <td class="tbl-surat">:</td>
            <td class="tbl-surat">{{ $surat->isi_ringkas }}</td>
            <td class="tbl-surat">Asal Surat</td>
            <td class="tbl-surat">:</td>
            <td class="tbl-surat">{{ $surat->dari }}</td>
        </tr>
    </table>

    <div class="row mt-2">
      <div class="col-12 table-responsive">
        <table>
            <thead>
                <tr class="tbl-header">
                    <th class="tbl-surat tbl-header" style="width: 5%; text-align: center;">No.</th>
                    <th class="tbl-surat tbl-header" style="width: 25%; text-align: center;">Disposisi</th>
                    <th class="tbl-surat tbl-header" style="width: 30%; text-align: center;">Isi Disposisi</th>
                    <th class="tbl-surat tbl-header" style="width: 15%; text-align: center;">Dikirim</th>
                    <th class="tbl-surat tbl-header" style="width: 15%; text-align: center;">Ditindaklanjuti</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($disposisi as $item)
                    <tr>
                        <td class="tbl-header" style="text-align: center;">{{ $loop->iteration }}</td>
                        <td class="tbl-header">
                            {{ $item->oleh }} <br/>
                            {{ $item->jenis_text }} <br/>
                            {{ $item->jenis_text!="Tindak Lanjut" ? $item->kepada : "" }}
                        </td>
                        <td class="tbl-header">{{ $item->jenis_text=="Tindak Lanjut" ? $item->tindaklanjut : $item->isi_disposisi }}</td>
                        <td class="tbl-header" style="text-align: center;">
                            {{ $item->tgl_terima }} <br/>
                            {{ $item->jam_terima }}
                        </td>
                        <td class="tbl-header" style="text-align: center;">
                            {{ $item->tgl_selesai }} <br/>
                            {{ $item->jam_selesai }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

    <script>
        window.addEventListener("load", window.print());
        
        // var css = '@page { size: landscape; }',
        //     head = document.head || document.getElementsByTagName('head')[0],
        //     style = document.createElement('style');
        // style.type = 'text/css';
        // style.media = 'print';
        // if (style.styleSheet){
        //     style.styleSheet.cssText = css;
        // } else {
        //     style.appendChild(document.createTextNode(css));
        // }
        // head.appendChild(style);
        // window.print();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>
        body {
            font-size:12px;
        }
        .tbl-header {
            border: 1px solid black;
        }
        .tbl-surat {
            vertical-align:top;
        }
    </style>
</body>
</html>
