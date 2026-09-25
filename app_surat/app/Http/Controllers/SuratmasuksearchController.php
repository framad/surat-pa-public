<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratmasukModel;
use App\Models\EncryptHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Session;
use DataTables;

class SuratmasuksearchController extends Controller
{
    protected $sm_model;
    protected $enc_helper;
    public function __construct(
        SuratmasukModel $sm,
        EncryptHelper $enc)
    {
        $this->sm_model = $sm;
        $this->enc_helper = $enc;
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $role_id = auth::user()->role;
        if (false) {
            return redirect('/dashboard');
        }

        return view('surat_masuk.search');
    }

    public function get_data_ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->sm_model->get_data_ajax_search($request);
            foreach ($data as $row) {
                $row->enc_id = $this->enc_helper->encrypt($row->id);
            }

            $totalRecords = $this->sm_model->get_data_ajax($request, '*'); // ini yg ori
	        // $totalRecords = $this->sm_model->get_total_records(); // ini lagi diupdate
            $filteredRecords = $this->sm_model->get_data_ajax_search($request, 'filter');

            return Datatables::of($data)
                ->skipPaging()
                // ->setTotalRecords($totalRecords)
                ->setTotalRecords(count($totalRecords))
                ->setFilteredRecords(count($filteredRecords))
                ->addIndexColumn()
                ->addColumn('dari', function($row) {
                    $dari = '';
                    if ($row->sifat_surat < 3) {
                        $dari = $row->dari;
                    }
                    return $dari;
                })
                ->addColumn('no_surat', function($row) {
                    $no_surat = '';
                    if ($row->sifat_surat < 3) {
                        $no_surat = $row->no_surat . '<br/>' . $row->tgl_surat . '<br/>' . $row->posisi;
                    }
                    return $no_surat;
                })
                ->addColumn('isi_ringkas', function($row) {
                    $isi_ringkas = $row->sifat_surat>2 ? 'SURAT RHS' : $row->isi_ringkas;

                    if ($row->sifat_surat > 2)
                    {
                        $isi_ringkas .= '<span class="badge badge-danger badge-pill mb-15 mr-10">Rahasia</span>';
                    }
                    if ($row->belum_selesai_8_jam > 0)
                    {
                        $isi_ringkas .= '<br/><span class="badge badge-danger badge-pill mb-15 mr-10">>8 jam</span>';
                    }

                    return $isi_ringkas;
                })
                ->addColumn('action', function($row) {
                    $button = '';
                    if ($row->sifat_surat < 3) {
                        $button = '<div class="btn-group">';
                        $button .= '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>';
                        $button .= '</button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">';
                        if (Auth::user()->role==1 || Auth::user()->role==4) {
                            $url = url('/sm/'.$row->enc_id.'/cetak');
                            $button .= '<a class="dropdown-item" href="'.$url.'" target="_blank">';
                            $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer dropdown-icon"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>';
                            $button .= '<span>Cetak Tanda Terima</span></a>';
                            $button .= '<div class="dropdown-divider"></div>';
                        }

                        $url = url('/sm/'.$row->enc_id.'/lacak');
                        $button .= '<a class="dropdown-item" href="'.$url.'" target="_blank">';
                        $button .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search dropdown-icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';
                        $button .= '<span>Lihat Detil</span></a></div></div>';
                    }
                    return $button;
                })
                ->addColumn('file', function($row) {
                    $file = '';
                    if ($row->sifat_surat < 3) {
                        $gambar = asset('images/nopdf.webp');
                        $file = '<image src="'. $gambar .'" width="50">';
                        if (!empty($row->file)) {
                            $path = asset('dok/' . $row->file);
                            $gambar = asset('images/pdf.png');
                            $file = '<a href="'. $path .'" target="_blank"><image src="'. $gambar .'" width="50" ></a>';
                        }
                    }
                    return $file;
                })
                ->rawColumns(['dari','isi_ringkas','no_surat','file','action'])
                ->make(true);
        }
    }
}
