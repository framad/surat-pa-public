<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonitoringDisposisiExport implements FromView, WithColumnWidths, WithStyles // FromArray, WithHeadings, WithColumnWidths, 
{
    protected $bulan;
    protected $tahun;
    protected $row = 0;
    function __construct($bln, $thn) {
        $this->bulan = sprintf("%02d", $bln);
        $this->tahun = sprintf($thn);
    }

    public function view(): View
    {
        $cur_id = 0;
        $last_date = '';
        $hist_dispo = '';

        $sql = "SELECT m.id, m.no_agenda, m.no_surat, u.name, m.tgl_diterima, 
                DATE_FORMAT(d.created_at,'%Y-%m-%d') tgl_disposisi FROM t_surat_masuk m 
                JOIN t_disposisi d ON m.id=d.id_surat_masuk JOIN users u ON d.disposisi_kepada=u.nip 
                WHERE MONTH(m.tgl_diterima)=? AND YEAR(m.tgl_diterima)=? ORDER BY m.id, d.id";
        $data = DB::select($sql, [$this->bulan, $this->tahun]);
        
        $arr_obj = [];
        $obj = [];
        $count = 0;
        foreach ($data as $row) {
            // $obj = [
                // 'someName' => 'someClass',
                // 'someOtherName' => 'someOtherClass'
            // ];
            
            if ($count == 0) {
                $cur_id = $row->id;
                $hist_dispo = $hist_dispo=='' ? $row->name : $hist_dispo . ' -> ' . $row->name;

                $obj['id'] = $row->id;
                $obj['no_agenda'] = $row->no_agenda;
                $obj['no_surat'] = $row->no_surat;
                $obj['tgl_disposisi'] = $row->tgl_disposisi;
                $obj['hist_disposisi'] = $hist_dispo;
            } else if ($row->id==$cur_id) {
                $last_date = $row->tgl_disposisi;
                $hist_dispo = $hist_dispo . ' -> ' . $row->name;

                $obj['tgl_disposisi'] = $last_date;
                $obj['hist_disposisi'] = $hist_dispo;
            } else {
                array_push($arr_obj, $obj);
                $obj = [];
                $hist_dispo = '';

                $cur_id = $row->id;
                $last_date = $row->tgl_disposisi;
                $hist_dispo = $hist_dispo=='' ? $row->name : $hist_dispo . ' -> ' . $row->name;

                $obj['id'] = $row->id;
                $obj['no_agenda'] = $row->no_agenda;
                $obj['no_surat'] = $row->no_surat;
                $obj['tgl_disposisi'] = $row->tgl_disposisi;
                $obj['hist_disposisi'] = $hist_dispo;
            }

            $count = $count + 1;

            if ($count == count($data)) {
                array_push($arr_obj, $obj);
                $obj = [];
                $hist_dispo = '';
            }
        }
        
        $this->row = count($arr_obj) + 5;
        $nama_satker = "PENGADILAN TINGGI AGAMA BANDUNG"; 

        return view('surat_masuk.export_monitoring_disposisi', [
            'data'        => $arr_obj,
            'bulan'       => $this->get_bulan_indo($this->bulan),
            'tahun'       => $this->tahun,
            'nama_satker' => $nama_satker,
        ]);
    }

    function get_bulan_indo() {
        switch ($this->bulan) {
            case '01':
                return "JANUARI";
                break;
            case '02':
                return "FEBRUARI";
                break;
            case '03':
                return "MARET";
                break;
            case '04':
                return "APRIL";
                break;
            case '05':
                return "MEI";
                break;
            case '06':
                return "JUNI";
                break;
            case '07':
                return "JULI";
                break;
            case '08':
                return "AGUSTUS";
                break;
            case '09':
                return "SEPTEMBER";
                break;
            case '05':
                return "OKTOBER";
                break;
            case '11':
                return "NOVEMBER";
                break;
            case '12':
                return "DESEMBER";
                break;
            default:
                return "-";
                break;
        }
    }

    function tgl_indo($tanggal){
        $bulan = array (
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    public function columnWidths(): array {
        return [
            'A' => 7,
            'B' => 12,
            'C' => 30,
            'D' => 15,
            'E' => 100,
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getStyle('A4:E'.$this->row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:E'.$this->row)->getAlignment()->setVertical('center');
        
        for ($i=5; $i <= $this->row; $i++) { 
            $sheet->getStyle('A'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('A'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('A'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('A'.$i)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('B'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('B'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('B'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('B'.$i)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('C'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('C'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('C'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('C'.$i)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('D'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('D'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('D'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('D'.$i)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('E'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('E'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('E'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('E'.$i)->getBorders()->getRight()->setBorderStyle('thin');
        }
        
        return [
            // Style the row as bold text 12.
            1 => ['font' => ['bold' => true, 'size' => 12]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            3 => ['font' => ['bold' => true, 'size' => 12]],
            5 => ['font' => ['bold' => true, 'size' => 12]],
            
            // Styling an entire column.
            // 'E'  => ['font' => ['size' => 16]],
            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],
        ];
    }
}
