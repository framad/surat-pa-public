<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Surat PTA Bandung</title>

    <link href="{{ asset('style/tracker/site.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cutive+Mono|Open+Sans:300,400&display=swap">
    <link href="{{ asset('style/tracker/progress-tracker.css')}}" rel="stylesheet" type="text/css" />
  </head>
  
  <body>

    <header class="header">
      <nav class="container">

        <h1 class="logo-text">E-Surat Tracker</h1>

        <nav class="header-links">
          <a href="http://pta-bandung.go.id" class="btn-demo btn-demo--white" target="_blank">PTA Bandung</a>
          <a href="{{ url('/')}}" class="btn-demo btn-demo--white">E-surat PTA Bandung</a>
        </nav>
      </div>
    </header>

    @if ($surat_masuk)
        <div class="fullwidth">
            <div class="container separator">
                <h3 class="m-0">
                    Nomor Surat {{ $surat_masuk['no_surat'] }}
                </h3>

                @if($surat_masuk['sifat_surat']<3)
                <h3 class="m-0">
                    Perihal {{ $surat_masuk['isi_ringkas'] }}
                </h3>
                <h3 class="m-0">
                    Dikirim Oleh {{ $surat_masuk['dari'] }}
                </h3>
                @endif

                <h3 class="m-0">
                    Tanggal Diterima, {{ $surat_masuk['tgl_diterima'] }}
                </h3>
            </div>
        </div>

        <div class="fullwidth"> 
            <div class="container separator">
                <ul class="progress-tracker progress-tracker--vertical">
                    @php $no = 1; @endphp 
                    @foreach ($disposisi as $item)
                        <li class="progress-step is-complete">
                            <div class="progress-marker"></div>
                            <div class="progress-text">
                            <h4 class="progress-title">{{ $loop->iteration. '. ' .$item['jenis_text'] }}</h4>
                            {{ $item['disposisi'] }} <br/>
                            
                            @if($item['pelaksana'])
                                {{ $item['pelaksana'] }} <br/>
                            @endif
                            
                            @if ($item['tindaklanjut'] != '-' && $surat_masuk['sifat_surat']<3)
                                Tindak Lanjut: {{ $item['tindaklanjut'] }} <br/>
                            @endif

                            Pada: {{ $item['tgl_terima'] . ' ' . $item['jam_terima']}}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        <div class="fullwidth">
            <div class="container separator">
                <h2 class="m-0">Data Tidak Ditemukan</h2>
            </div>
        </div>
    @endif

    <footer class="fullwidth fullwidth--sm footer">
      <div class="container">
        <a href="http://www.pta-bandung.go.id" class="text-dark" target="_blank">PTA Bandung</a> &copy; 2022
      </div>
    </footer>

    <!-- This is just required for the fill path demo. -->
    <script src="{{ asset('style/tracker/site.js')}}"></script>

  </body>
</html>
