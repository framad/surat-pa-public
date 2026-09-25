
<!DOCTYPE html>
<!--
Template Name: Marvin - Responsive Bootstrap 4 Admin Dashboard Template
Author: Hencework
Contact: https://hencework.ticksy.com/

License: You must have a valid license purchased only from templatemonster to legally use the template for your project.
-->
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>e-Surat - @yield('title')</title>
    <meta name="description" content="Aplikasi Surat Elektronik" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

	<!-- vector map CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />

	<link href="{{ asset('style/marvin/html')}}/vendors/apexcharts/dist/apexcharts.css" rel="stylesheet" type="text/css" />

    <!-- Toggles CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('style/marvin/html')}}/vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">

	<!-- Toastr CSS -->
    <link href="{{ asset('style/marvin/html')}}/vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">

    @yield('css')

    <!-- Custom CSS -->
    <link href="{{ asset('style/marvin/html')}}/dist/css/style.css" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />


</head>

<body>
    <!-- Preloader
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    --><!-- /Preloader -->

	<!-- HK Wrapper -->
    <?php
        $tahun_anggaran = session()->get('tahun_anggaran');
        $nip = "'".Auth::user()->nip."'";
        $role = Auth::user()->role;
        if ($role==5) { // role ajudan, cari nip atasan nya
            $atasan = DB::select("select u.id_jabatan, j.id_atasan, atasan.nip, atasan.name from users u join t_jabatan j on u.id_jabatan=j.id
                                join users atasan on j.id_atasan=atasan.id_jabatan where atasan.active=1 and u.nip=".$nip);
            if ($atasan) {
                $nip = "'".$atasan[0]->nip."'";
            }
        }

        // $inbox =  DB::table('t_surat_masuk')
        //     ->join('t_disposisi', 't_surat_masuk.id', '=', 't_disposisi.id_surat_masuk')
        //     ->select('t_surat_masuk.id')
        //     ->whereRaw('(disposisi_kepada='.$nip.' OR plh='.$nip.')')
        //     ->where('t_disposisi.teruskan', '=', null)
        //     ->count();
        $sql = "SELECT m.id FROM t_surat_masuk m JOIN t_disposisi d ON m.id=d.id_surat_masuk
                WHERE (disposisi_kepada=".$nip." OR plh=".$nip.") AND d.teruskan IS NULL
                UNION
                SELECT m.id FROM t_disposisi d JOIN t_tembusan t ON d.id=t.id_disposisi JOIN t_surat_masuk m ON m.id=d.id_surat_masuk
                WHERE t.nip=".$nip." AND t.read=0";
        $data =  DB::select($sql);
        $inbox = count($data);
    ?>
	<div class="hk-wrapper hk-vertical-nav">

        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar">
            <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="menu"></i></span></a>
            <a class="navbar-brand font-weight-700" href="/">
                Nadine </a> <p class="fs-5">  - Naskah Dinas Elektronik -</p>
            </a>
            <ul class="navbar-nav hk-navbar-content">
                {{-- <li class="nav-item">
                    <a id="navbar_search_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="search"></i></span></a>
                </li> --}}
                <li class="nav-item">
                    {{-- <a id="settings_toggle_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span class="feather-icon"><i data-feather="settings"></i></span></a> --}}
                </li>
                <li class="nav-item dropdown dropdown-notifications">
                    {{-- <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="feather-icon"><i data-feather="bell"></i></span><span class="badge-wrap"><span class="badge badge-primary badge-indicator badge-indicator-sm badge-pill pulse"></span></span></a> --}}
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <h6 class="dropdown-header">Notifications <a href="javascript:void(0);" class="">View all</a></h6>
                        <div class="notifications-nicescroll-bar">

                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('images')}}/user.png" alt="user" class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Surat masuk baru <span class="text-dark text-capitalize">Kasubbag Umum</span></div>
                                            <div class="notifications-time">1h</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>


                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-warning rounded-circle">
													<span class="initial-wrap"><span><i class="zmdi zmdi-notifications font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Last 2 days left for the project</div>
                                            <div class="notifications-time">15d</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-authentication">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-img-wrap">
                                <div class="avatar">
                                    <img src="{{ asset('images')}}/user.png" alt="user" class="avatar-img rounded-circle">
                                </div>
                                <span class="badge badge-success badge-indicator"></span>
                            </div>
                            <div class="media-body">
                                <span>{{ Auth::user()->name}}<i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                        <a class="dropdown-item" href="profile.html"><i class="dropdown-icon zmdi zmdi-account"></i><span>Profile</span></a>
                        {{-- <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-inbox"></i><span>My balance</span></a> --}}
                        <a class="dropdown-item" href="/disposisi"><i class="dropdown-icon zmdi zmdi-email"></i><span>Inbox</span></a>
                        {{-- <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-settings"></i><span>Settings</span></a> --}}
                        <div class="dropdown-divider"></div>
                        <div class="sub-dropdown-menu show-on-hover">
                            <a href="#" class="dropdown-toggle dropdown-item no-caret"><i class="zmdi zmdi-check text-success"></i>Tahun Anggaran ({{ $tahun_anggaran }})</a>
                            <div class="dropdown-menu open-left-side">
                                @php
                                    $years = range(date('Y'), (date('Y')-4));
                                @endphp
                                @csrf
                                {{-- <a class="dropdown-item" href="#" onclick="tahun_anggaran(2022)"><i class="dropdown-icon zmdi zmdi-check text-success"></i><span>TA. 2022</span></a> --}}
                                @foreach($years as $item)
                                    <a class="dropdown-item" href="#" onclick="tahun_anggaran(`{{ $item }}`)">
                                        <i class="dropdown-icon zmdi {{ $tahun_anggaran==$item ? 'zmdi-check text-success' : 'zmdi-circle-o text-warning' }}"></i>
                                        <span>{{ 'TA. '.$item }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <form action="{{ url('/logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="dropdown-icon zmdi zmdi-power"></i><span>Log out</span></button>
                            {{-- <a class="dropdown-item" href="#"><i class="dropdown-icon zmdi zmdi-power"></i><span>Log out</span></a> --}}
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <form role="search" class="navbar-search">
            <div class="position-relative">
                <a href="javascript:void(0);" class="navbar-search-icon"><span class="feather-icon"><i data-feather="search"></i></span></a>
                <input type="text" name="example-input1-group2" class="form-control" placeholder="Type here to Search">
                <a id="navbar_search_close" class="navbar-search-close" href="#"><span class="feather-icon"><i data-feather="x"></i></span></a>
            </div>
        </form>
        <!-- /Top Navbar -->

        <!-- Vertical Nav -->
        <nav class="hk-nav hk-nav-dark">
            <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
            <div class="nicescroll-bar">
                <div class="navbar-nav-wrap">

                    {{-- <hr class="nav-separator"> --}}
                    <div class="nav-header">
                        <span>User Menu e-Surat</span>
                        <span></span>
                    </div>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link link-with-badge" href="{{ url('/dashboard') }}">
                                <span class="feather-icon"><i data-feather="home"></i></span>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item  {{ request()->is(['sm','catat_sm','disposisi', 'disposisi/*']) ? 'active' : '' }}">
                            <a class="nav-link link-with-badge" href="javascript:void(0);" data-toggle="collapse" data-target="#Components_drp">
                                <span class="feather-icon"><i data-feather="mail"></i></span>
                                <span class="nav-link-text">Surat Masuk</span>
                                <span class="badge badge-primary badge-pill">{{ $inbox }}</span>
                            </a>
                            <ul id="Components_drp" class="nav flex-column {{ request()->is(['sm','sm/*','sm_search','catat_sm','catat_sm/*','disposisi', 'disposisi/*', 'statistik_sm', 'sm_rhs', 'sm_register', 'arsip']) ? 'collapse-show' : 'collapse' }} collapse-level-1">
                                <li class="nav-item ">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ request()->is(['disposisi', 'disposisi/*']) ? 'active' : '' }}">
                                            <a class="nav-link link-with-badge" href="{{url('/disposisi')}}">
                                                {{-- <span class="feather-icon"><i data-feather="mail"></i></span> --}}
                                                <span class="nav-link-text">Inbox</span>
                                                <span class="badge badge-primary badge-pill">{{ $inbox }}</span>
                                            </a>
                                        </li>

                                        @if (Auth::user()->role!=5)
                                            <li class="nav-item {{ request()->is(['sm','catat_sm','sm/*']) ? 'active' : '' }}">
                                                <a class="nav-link " href="{{ url('/sm')}}">Surat Masuk</a>
                                            </li>

                                            <li class="nav-item {{ request()->is(['sm_rhs','catat_sm/*','sm_rhs/*']) ? 'active' : '' }}">
                                                <a class="nav-link " href="{{ url('/sm_rhs')}}">Surat Masuk Rahasia</a>
                                            </li>

                                            <li class="nav-item {{ request()->is(['sm_search']) ? 'active' : '' }}">
                                                <a class="nav-link link-with-badge" href="{{url('/sm_search')}}">
                                                    <span class="nav-link-text">Cari Surat Masuk</span>
                                                    <span class="badge badge-danger badge-pill">!</span>
                                                </a>
                                            </li>
                                        @endif

                                        @if (Auth::user()->role!=2 && Auth::user()->role!=3 && Auth::user()->role!=5)
                                            <li class="nav-item {{ request()->is(['sm_register']) ? 'active' : '' }}">
                                                <a class="nav-link " href="{{ url('/sm_register')}}">Buku Induk</a>
                                            </li>

                                            <li class="nav-item {{ request()->is(['statistik_sm']) ? 'active' : '' }}">
                                                <a class="nav-link " href="{{ url('/statistik_sm')}}">Statistik Surat</a>
                                            </li>

                                            <li class="nav-item {{ request()->is(['disposisi/monitoring']) ? 'active' : '' }}">
                                                <a class="nav-link " href="{{ url('/disposisi/monitoring')}}">Monitoring Disposisi</a>
                                            </li>
                                        @endif

                                        @if (Auth::user()->role==1 || Auth::user()->role==4)
                                            <li class="nav-item {{ request()->is(['arsip']) ? 'active' : '' }}">
                                                <a class="nav-link " href="{{ url('/arsip')}}">Arsip Surat</a>
                                            </li>
                                        @endif
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" href="images.html">Buku Induk</a>
                                        </li> --}}
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        @if (Auth::user()->role!=2)
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#content_drp">
                                    <span class="feather-icon"><i data-feather="send"></i></span>
                                    <span class="nav-link-text">Surat Keluar</span>
                                </a>
                                <ul id="content_drp" class="nav flex-column {{ request()->is([
                                            'surat_keluar','surat_keluar/*','catat_sk','catat_sk/*',
                                            'surat_keluar_baru','surat_keluar_baru/*','catat_sk_baru','catat_sk_baru/*',
                                            'surat_keluar_rhs','surat_keluar_rhs/*',
                                            'surat_keluar_rhs_baru','surat_keluar_rhs_baru/*',
                                            'statistik_sk','sk_register'
                                        ]) ? 'collapse-show' : 'collapse' }} collapse-level-1">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            {{-- <li class="nav-item {{ request()->is(['surat_keluar','surat_keluar/*','catat_sk']) ? 'active' : '' }}">
                                                <a class="nav-link " href="{{ url('/surat_keluar')}}">Surat Keluar (2023)</a>
                                            </li> --}}

                                            @if(Auth::user()->role==1 || Auth::user()->role==3)
                                                {{-- <li class="nav-item {{ request()->is(['surat_keluar_rhs','surat_keluar_rhs/*','catat_sk/*']) ? 'active' : '' }}">
                                                    <a class="nav-link " href="{{ url('/surat_keluar_rhs')}}">Surat Keluar RHS (2023)</a>
                                                </li> --}}
                                            @endif

                                            {{-- Surat Keluar Baru --}}
                                            <li class="nav-item {{ request()->is(['surat_keluar_baru','surat_keluar_baru/*','catat_sk_baru']) ? 'active' : '' }}">
                                                <a class="nav-link link-with-badge" href="{{url('/surat_keluar_baru')}}">
                                                    <span class="nav-link-text">Surat Keluar</span>
                                                    {{-- <span class="badge badge-danger badge-pill">!</span> --}}
                                                </a>
                                            </li>
                                            @if(Auth::user()->role==1 || Auth::user()->role==3)
                                            <li class="nav-item {{ request()->is(['surat_keluar_rhs_baru','surat_keluar_rhs_baru/*','catat_sk_baru/*']) ? 'active' : '' }}">
                                                <a class="nav-link link-with-badge" href="{{url('/surat_keluar_rhs_baru')}}">
                                                    <span class="nav-link-text">Surat Keluar RHS</span>
                                                    {{-- <span class="badge badge-danger badge-pill">!</span> --}}
                                                </a>
                                            </li>
                                            @endif
                                            {{-- End Surat Keluar Baru --}}
                                            
                                            @if (Auth::user()->role!=5 && Auth::user()->role!=3)
                                                <li class="nav-item {{ request()->is(['sk_register']) ? 'active' : '' }}">
                                                    <a class="nav-link " href="{{ url('/sk_register')}}">Buku Induk</a>
                                                </li>
                                                <li class="nav-item {{ request()->is(['statistik_sk']) ? 'active' : '' }}">
                                                    <a class="nav-link " href="{{ url('/statistik_sk')}}">Statistik Surat</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Auth::user()->role!=2 && Auth::user()->role!=3 && Auth::user()->role!=5)
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-toggle="collapse" data-target="#utilities_drp">
                                    <span class="feather-icon"><i data-feather="anchor"></i></span>
                                    <span class="nav-link-text">Pengaturan</span>
                                </a>
                                <ul id="utilities_drp" class="nav flex-column
                                    {{ request()->is(['plh', 'catat_plh', 'users', 'tambah_user', 'edit_user/*', 'klasifikasi', 'tambah_klasifikasi', 'edit_klasifikasi/*'])
                                    ? 'collapse-show' : 'collapse' }}
                                    collapse-level-1">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            <li class="nav-item {{ request()->is(['klasifikasi', 'tambah_klasifikasi', 'edit_klasifikasi/*']) ? 'active' : '' }}">
                                                <a href="{{ url('/klasifikasi')}}" class="nav-link">Klasifikasi Surat</a>
                                            </li>
                                            <li class="nav-item {{ request()->is(['users', 'tambah_user', 'edit_user/*']) ? 'active' : '' }}">
                                                <a href="{{ url('/users')}}" class="nav-link">Pengguna</a>
                                            </li>
                                            <li class="nav-item {{ request()->is(['plh', 'catat_plh']) ? 'active' : '' }}">
                                                <a href="{{ url('/plh')}}" class="nav-link">Pelaksana Harian</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->

        <!-- Setting Panel -->
        {{-- <div class="hk-settings-panel">
            <div class="nicescroll-bar position-relative">
                <div class="settings-panel-wrap">
                    <div class="settings-panel-head">
                        <a href="javascript:void(0);" id="settings_panel_close" class="settings-panel-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
                    </div>
                    <hr>

                    <h6 class="mb-5">Navigation</h6>
                    <p class="font-14">Menu comes in two modes: dark & light</p>
                    <div class="button-list hk-nav-select mb-10">
                        <button type="button" id="nav_light_select" class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-sun-o"></i> </span><span class="btn-text">Light Mode</span></button>
                        <button type="button" id="nav_dark_select" class="btn btn-outline-primary btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-moon-o"></i> </span><span class="btn-text">Dark Mode</span></button>
                    </div>
                    <hr>
                    <h6 class="mb-5">Top Nav</h6>
                    <p class="font-14">Choose your liked color mode</p>
                    <div class="button-list hk-navbar-select mb-10">
                        <button type="button" id="navtop_light_select" class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-sun-o"></i> </span><span class="btn-text">Light Mode</span></button>
                        <button type="button" id="navtop_dark_select" class="btn btn-outline-primary btn-sm btn-wth-icon icon-wthot-bg"><span class="icon-label"><i class="fa fa-moon-o"></i> </span><span class="btn-text">Dark Mode</span></button>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Scrollable Header</h6>
                        <div class="toggle toggle-sm toggle-simple toggle-light toggle-bg-primary scroll-nav-switch"></div>
                    </div>
                    <button id="reset_settings" class="btn btn-primary btn-block btn-reset mt-30">Reset</button>
                </div>
            </div>
            <img class="d-none" src="dist/img/logo-light.png" alt="brand" />
            <img class="d-none" src="dist/img/logo-dark.png" alt="brand" />
        </div> --}}
        <!-- /Setting Panel -->

        <!-- Main Content -->
        @yield('content')
        <!-- /Main Content -->
        {{-- @yield('footer') --}}

    </div>
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('style/marvin/html')}}/vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Slimscroll JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/dist/js/jquery.slimscroll.js"></script>


    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('style/marvin/html')}}/dist/js/dropdown-bootstrap-extended.js"></script>

    <!-- Daterangepicker JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/vendors/moment/min/moment.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/daterangepicker/daterangepicker.js"></script>
    <script src="{{ asset('style/marvin/html')}}/dist/js/daterangepicker-data.js"></script>

    @yield('toast')
    <!-- FeatherIcons JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/dist/js/feather.min.js"></script>

    <!-- Toggles JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/vendors/jquery-toggles/toggles.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/dist/js/toggle-data.js"></script>

	<!-- Counter Animation JavaScript -->
	<script src="{{ asset('style/marvin/html')}}/vendors/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="{{ asset('style/marvin/html')}}/vendors/jquery.counterup/jquery.counterup.min.js"></script>

	<!-- Morris Charts JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/vendors/raphael/raphael.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/morris.js/morris.min.js"></script>

	<!-- EChartJS JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/vendors/echarts/dist/echarts-en.min.js"></script>

	<!-- Sparkline JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>

	<!-- Vector Maps JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="{{ asset('style/marvin/html')}}/vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="{{ asset('style/marvin/html')}}/dist/js/vectormap-data.js"></script>


	<!-- Owl JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/vendors/owl.carousel/dist/owl.carousel.min.js"></script>


    <!-- Init JavaScript -->
    <script src="{{ asset('style/marvin/html')}}/dist/js/init.js"></script>
	{{-- <script src="{{ asset('style/marvin/html')}}/dist/js/validation-data.js"></script> --}}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function tahun_anggaran(tahun) {
            console.log('tahun_anggaran', tahun);
            $.ajax({
                type:'POST',
                url:"{{ route('set_tahun_anggaran') }}",
                data:{tahun},
                success:function(data) {
                    // console.log(data);
                    window.location =`{{ url('/dashboard') }}`;
                }
            });
        }
    </script>

   @yield('style')

</body>

</html>
