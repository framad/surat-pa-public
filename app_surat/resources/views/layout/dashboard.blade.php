@extends('layout.main')
@section('title', 'Dashboard')

@section('content')

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
			<!-- Container -->
            <div class="container mt-xl-50 mt-sm-30 mt-15">
                <!-- Title -->
                <div class="hk-pg-header align-items-top">
                    <div>
						<h2 class="hk-pg-title font-weight-600 mb-10">Selamat Datang</h2>
						<p>Aplikasi pencatatan surat masuk dan surat keluar</p>
						{{-- <p>{{ $last_active }}</p>
						<p>{{ $time }}</p>
						<p>{{ $dif }}</p> --}}
					</div>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row bordered">
                    <div class="col-xl-12 ">
						<div class="hk-row ">
                            @if($role!=5) 
                                <div class="col-sm-3">
                                    <div class="card text-white bg-primary card-sm">
                                        <a href="{{ url('sm') }}" class='card-btn'>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 font-weight-500">Surat Masuk Bulan Ini</span>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-primary badge-sm">
                                                            <i class="feather-size" data-feather="mail"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="d-block display-5 mb-5">
                                                        {{-- {{ $dashboard->surat_masuk_bulan_ini }} --}}
                                                        {{ $role==2 ? $dashboard->surat_masuk_user_bulan_ini : $dashboard->surat_masuk_bulan_ini }}
                                                    </span>
                                                    <small class="d-block">
                                                        {{-- @if($role==2) --}}
                                                        {{ $role==2 ? $dashboard->surat_masuk_user : $dashboard->total_surat_masuk }} Total Surat Masuk
                                                    </small>
                                                </div>
                                                {{-- surat_masuk_user --}}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($role!=2 && $role!=5) 
                                <div class="col-sm-3">
                                    <div class="card text-white bg-success card-sm">
                                        <a href="{{ url(date('Y') < 2024 ? 'surat_keluar':'surat_keluar_baru') }}" class='card-btn'>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div>
                                                        <span class="d-block font-15 font-weight-500">Surat keluar Bulan Ini</span>
                                                    </div>
                                                    <div>
                                                        <span class="badge badge-success badge-sm">
                                                            <i class="feather-size" data-feather="send"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="d-block display-5 mb-5">{{ $dashboard->surat_keluar_bulan_ini }}</span>
                                                    <small class="d-block">{{ $dashboard->total_surat_keluar }} Total Surat Keluar</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-3">
                                <div class="card text-white bg-info card-sm">
                                    <a href="{{ url('disposisi') }}" class='card-btn'>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 font-weight-500">Disposisi Masuk</span>
                                            </div>
                                            <div>
                                                <span class="badge badge-info badge-sm">
                                                    <i class="feather-size" data-feather="inbox"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="d-block display-5 mb-5">{{ $dashboard->disposisi_masuk }}</span>
                                            <small class="d-block">Silahkan cek pada menu inbox</small>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
						</div>
					</div>

                    @if ((Auth::user()->role==4))
                    <div class="col-xl-5 mt-50">
						<div class="row">
                            <div class="col-md-12">
                                <label>Surat Masuk Tahun Ini</label>
                            </div>

                            <div class="col-sm">
                                <div class="table-wrap">
                                    <table id="table-masuk" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Bulan</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sm_tahun as $item) 
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->bulan}}</td>
                                                    <td>{{$item->jumlah}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="col-xl-1 mt-50"></div>

                    <div class="col-xl-5 mt-50">
						<div class="row">
                            <div class="col-md-12">
                                <label>Surat Keluar Tahun Ini</label>
                            </div>

                            <div class="col-sm">
                                <div class="table-wrap">
                                    <table id="table-keluar" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Bulan</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $jml_sk=0 @endphp
                                            @foreach ($sk_tahun as $item) 
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->bulan}}</td>
                                                    <td>{{$item->jumlah}}</td>
                                                </tr>
                                                @php $jml_sk.=$item->jumlah @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="col-xl-1 mt-50"></div>

                    <div class="col-xl-5 mt-50">
						<div class="row">
                            <div class="col-md-12">
                                <label>Surat Masuk Rahasia Tahun Ini</label>
                            </div>

                            <div class="col-sm">
                                <div class="table-wrap">
                                    <table id="table-masuk" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Bulan</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sm_rhs_tahun as $item) 
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->bulan}}</td>
                                                    <td>{{$item->jumlah}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="col-xl-1 mt-50"></div>

                    <div class="col-xl-5 mt-50">
						<div class="row">
                            <div class="col-md-12">
                                <label>Surat Keluar Rahasia Tahun Ini</label>
                            </div>

                            <div class="col-sm">
                                <div class="table-wrap">
                                    <table id="table-keluar" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Bulan</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $jml_sk=0 @endphp
                                            @foreach ($sk_rhs_tahun as $item) 
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->bulan}}</td>
                                                    <td>{{$item->jumlah}}</td>
                                                </tr>
                                                @php $jml_sk.=$item->jumlah @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="col-xl-1 mt-50"></div>

                    <div class="col-xl-5 mt-50">
						<div class="row">
                            <div class="col-md-12 form-group">
                                <label>Klasifikasi Surat Masuk Bulan Ini</label>
                            </div>

                            <div class="col-sm">
                                <div class="table-wrap">
                                    <table id="table-masuk" class="table table-hover w-100 display pb-30 table-masuk">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($statistik_masuk as $item) 
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->parent}}</td>
                                                    <td>{{$item->jumlah}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="col-xl-1 mt-50"></div>

                    <div class="col-xl-5 mt-50">
						<div class="row">
                            <div class="col-md-12 form-group">
                                <label>Klasifikasi Surat Keluar Bulan Ini</label>
                            </div>

                            <div class="col-sm">
                                <div class="table-wrap">
                                    <table id="table-keluar" class="table table-hover w-100 display pb-30 table-keluar">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($statistik_keluar as $item) 
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->parent}}</td>
                                                    <td>{{$item->jumlah}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="col-xl-1 mt-50"></div>

                    <div class="col-xl-5 mt-50">
						<div class="row">
                            <div class="col-md-12 form-group">
                                <label>Klasifikasi Surat Masuk Rahasia Bulan Ini</label>
                            </div>

                            <div class="col-sm">
                                <div class="table-wrap">
                                    <table id="table-masuk" class="table table-hover w-100 display pb-30 table-masuk">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($statistik_masuk_rhs as $item) 
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->parent}}</td>
                                                    <td>{{$item->jumlah}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="col-xl-1 mt-50"></div>

                    <div class="col-xl-5 mt-50">
						<div class="row">
                            <div class="col-md-12 form-group">
                                <label>Klasifikasi Surat Keluar Rahasia Bulan Ini</label>
                            </div>

                            <div class="col-sm">
                                <div class="table-wrap">
                                    <table id="table-keluar" class="table table-hover w-100 display pb-30 table-keluar">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($statistik_keluar_rhs as $item) 
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$item->parent}}</td>
                                                    <td>{{$item->jumlah}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="col-xl-1 mt-50"></div>
                    @endif
                </div>
                <!-- /Row -->
            </div>
            <!-- /Container -->

            <div>

            </div>
			
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

@endsection

@section('toast')
<script src="{{ asset('style/marvin/html')}}/vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
<script src="{{ asset('style/marvin/html')}}/dist/js/dashboard-data.js"></script>
@endsection

@section('style')
<style>
    .feather-size {
        width: 18px;
        height: 18px;
    }
    .card-btn {
        text-decoration: none;
        color: white;
    }
    a:hover, a:active {
        color: rgb(237, 237, 237);
    }
</style>
@endsection