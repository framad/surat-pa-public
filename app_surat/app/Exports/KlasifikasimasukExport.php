<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KlasifikasimasukExport implements FromView, WithColumnWidths, WithStyles // FromArray, WithHeadings, WithColumnWidths, 
{
    protected $bulan;
    protected $tahun;
    protected $row = 0;
    protected $row_2_start = 0;
    protected $row_2_end = 0;
    function __construct($bln, $thn) {
        $this->bulan = sprintf("%02d", $bln);
        $this->tahun = sprintf($thn);
    }

    public function view(): View
    {
        $table = "";
        if ($this->tahun > 2023) {
            $table = "_baru";
        }

        $sql_detail = "SELECT p.kode parent, k.kode, k.nama, k.uraian, count(k.id) jumlah
                FROM t_surat_masuk sm JOIN ref_klasifikasi".$table." k ON sm.id_klasifikasi=k.id 
                JOIN ref_klasifikasi".$table." p ON k.parent_id=p.id
                WHERE LEFT(sm.tgl_diterima, 7)=? GROUP BY k.id, k.kode, k.nama, k.uraian, p.kode ORDER BY k.kode";
        
        
        $sql_parent = "SELECT parent, SUM(jumlah) jumlah FROM (";
        $sql_parent .= $sql_detail;
        $sql_parent .= ") A GROUP BY parent";

        $tgl_surat = $this->tahun .'-'. $this->bulan;

        $data_parent = DB::select($sql_parent, [$tgl_surat]);
        $this->row = count($data_parent) + 5;

        $data = DB::select($sql_detail, [$tgl_surat]);
        $this->row_2_start = $this->row + 5;
        $this->row_2_end = $this->row_2_start + count($data_parent);

        $nama_satker = "PENGADILAN TINGGI AGAMA BANDUNG";

        return view('statistik_surat.export_sm', [
            'data' => $data,
            'data_parent' => $data_parent,
            'bulan' => $this->get_bulan_indo($this->bulan),
            'tahun' => $this->tahun,
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

    public function columnWidths(): array
    {
        return [
            'A' => 7,
            'B' => 13,
            'C' => 10,
            'D' => 30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D'.$this->row_2_end)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:D'.$this->row_2_end)->getAlignment()->setVertical('center');
        
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
        }

        for ($j=$this->row_2_start; $j <= $this->row_2_end+1; $j++) { 
            $sheet->getStyle('A'.$j)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('A'.$j)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('A'.$j)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('A'.$j)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('B'.$j)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('B'.$j)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('B'.$j)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('B'.$j)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('C'.$j)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('C'.$j)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('C'.$j)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('C'.$j)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('D'.$j)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('D'.$j)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('D'.$j)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('D'.$j)->getBorders()->getRight()->setBorderStyle('thin');
        }
        
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true, 'size' => 12]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            3 => ['font' => ['bold' => true, 'size' => 12]],
            5 => ['font' => ['bold' => true, 'size' => 12]],

            $this->row_2_start - 2 => ['font' => ['bold' => true, 'size' => 12]],
            $this->row_2_start => ['font' => ['bold' => true, 'size' => 12]],
            
            // Styling an entire column.
            // 'E'  => ['font' => ['size' => 16]],
            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],
        ];
    }
}
