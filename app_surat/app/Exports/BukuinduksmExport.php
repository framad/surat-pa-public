<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuinduksmExport implements FromView, WithColumnWidths, WithStyles // FromArray, WithHeadings, WithColumnWidths, 
{
    protected $bulan;
    protected $tahun;
    protected $rahasia;
    protected $row = 0;
    function __construct($bln, $thn, $rhs) {
        $this->bulan = sprintf("%02d", $bln);
        $this->tahun = sprintf($thn);
        $this->rahasia = $rhs;
    }

    public function view(): View
    {
        $table = "";
        if ($this->tahun > 2023) {
            $table = "_baru";
        }

        $sql = 'SELECT sm.id, sm.no_agenda, k.kode klasifikasi, sm.isi_ringkas, sm.dari, sm.no_surat,
                sm.tgl_surat, sm.tgl_diterima, u.name,
                CASE
                    WHEN sm.sifat_surat=1 THEN "Biasa"
                    WHEN sm.sifat_surat=2 THEN "Penting"
                    WHEN sm.sifat_surat=3 THEN "Rahasia (Pengaduan)"
                    WHEN sm.sifat_surat=4 THEN "Rahasia (Kepegawaian)"
                    ELSE "Rahasia (Perkara Banding)"
                END sifat
                FROM t_surat_masuk sm LEFT JOIN ref_klasifikasi'.$table.' k ON sm.id_klasifikasi=k.id
                LEFT JOIN users u ON sm.user_id=u.nip';
        if ($this->rahasia != NULL) {
            $sql .= " WHERE sifat_surat > 2";
        } else {
            $sql .= " WHERE sifat_surat < 3";
        }

        if ($this->bulan!="00" || $this->tahun!="NULL") {
            if ($this->bulan!="00") {
                $sql .= " AND MONTH(tgl_diterima)=".$this->bulan;
            }
            $this->tahun = $this->tahun!="NULL" ? $this->tahun : date('Y');
            $sql .= " AND YEAR(tgl_diterima)=".$this->tahun;
        }
        $sql .= " ORDER BY tgl_diterima";
        
        $data = DB::select($sql);
        $this->row = count($data) + 5;
        $nama_satker = "PENGADILAN TINGGI AGAMA BANDUNG"; 

        return view('statistik_surat.export_buku_sm', [
            'data' => $data,
            'bulan' => $this->get_bulan_indo($this->bulan),
            'tahun' => $this->tahun,
            'rhs' => $this->rahasia!=NULL ? "Rahasia" : "",
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

    public function columnWidths(): array {
        return [
            'A' => 7,
            'B' => 12,
            'C' => 12,
            'D' => 50,
            'E' => 30,
            'F' => 30,
            'G' => 15,
            'H' => 30,
            'I' => 15,
            'J' => 23,
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getStyle('A4:J'.$this->row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:J'.$this->row)->getAlignment()->setVertical('center');
        
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
            $sheet->getStyle('F'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('F'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('F'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('F'.$i)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('G'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('G'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('G'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('G'.$i)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('H'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('H'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('H'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('H'.$i)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('I'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('I'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('I'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('I'.$i)->getBorders()->getRight()->setBorderStyle('thin');
            $sheet->getStyle('J'.$i)->getBorders()->getTop()->setBorderStyle('thin');
            $sheet->getStyle('J'.$i)->getBorders()->getBottom()->setBorderStyle('thin');
            $sheet->getStyle('J'.$i)->getBorders()->getLeft()->setBorderStyle('thin');
            $sheet->getStyle('J'.$i)->getBorders()->getRight()->setBorderStyle('thin');
        }
        
        return [
            // Style the first row as bold text.
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
