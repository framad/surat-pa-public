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
                    Nomor Surat {{ $surat_masuk->no_surat }}
                </h3>

                @if($surat_masuk->sifat_surat<3)
                <h3 class="m-0">
                    Perihal {{ $surat_masuk->isi_ringkas }}
                </h3>
                <h3 class="m-0">
                    Dikirim Oleh {{ $surat_masuk->dari }}
                </h3>
                @endif

                <h3 class="m-0">
                    Tanggal Diterima, {{ $surat_masuk->tgl_diterima }}
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
                            <h4 class="progress-title">{{ $loop->iteration. '. ' .$item->jenis_text }}</h4>
                            {{ $item->disposisi }} <br/>
                            
                            @if($item->pelaksana)
                                {{ $item->pelaksana }} <br/>
                            @endif

                            {{-- @if ($item->isi_disposisi != '-' && $surat_masuk->sifat_surat<3)
                                Isi Disposisi: {{ $item->isi_disposisi }} <br/>
                            @endif --}}
                            
                            @if ($item->tindaklanjut != '-' && $surat_masuk->sifat_surat<3)
                                Tindak Lanjut: {{ $item->tindaklanjut }} <br/>
                            @endif

                            Pada: {{ $item->tgl_terima . ' ' . $item->jam_terima}}
                            </div>
                        </li>
                    @endforeach
                    
                    {{-- <li class="progress-step is-complete">
                        <div class="progress-marker"></div>
                        <div class="progress-text">
                        <h4 class="progress-title">1. Meneruskan</h4>
                        OPERATOR SURAT Meneruskan Ke REZA M SAJIDIN, S.Sy. <br/>
                        Pada: 2022-08-29 09:29:22
                        </div>
                    </li>

                    <li class="progress-step is-complete">
                        <div class="progress-marker"></div>
                        <div class="progress-text">
                        <h4 class="progress-title">2. Meneruskan</h4>
                        REZA M SAJIDIN, S.Sy. Meneruskan Ke FARIDL MUZAKY, S.Kom. <br/>
                        (PLH: DESYANA RAHMA YUSTINI, S.I.A.) <br/>
                        Pada: 2022-08-29 09:40:41
                        </div>
                    </li>

                    <li class="progress-step is-complete" aria-current="step">
                        <div class="progress-marker"></div>
                        <div class="progress-text">
                        <h4 class="progress-title">3. Disposisi</h4>
                        FARIDL MUZAKY, S.Kom. Disposisi Ke DESYANA RAHMA YUSTINI, S.I.A. <br/>
                        Disposisi: Mohon Ditindaklanjuti. Terimakasih. <br/>
                        Pada: 2022-08-29 11:57:36
                        </div>
                    </li>

                    <li class="progress-step is-active">
                        <div class="progress-marker"></div>
                        <div class="progress-text">
                        <h4 class="progress-title">4. Tindak Lanjut</h4>
                        DESYANA RAHMA YUSTINI, S.I.A. (TINDAK LANJUT) <br/>
                        Tindak Lanjut: Sudah dilaksanakan <br/>
                        Pada: 2022-08-29 11:57:36
                        </div>
                    </li> --}}
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
