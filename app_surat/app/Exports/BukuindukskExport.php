<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuindukskExport implements FromView, WithColumnWidths, WithStyles // FromArray, WithHeadings, WithColumnWidths, 
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

        $sql = 'SELECT sk.tanggal_surat, k.nama klasifikasi, sk.nomor_surat, sk.isi_ringkas, sk.tujuan_surat, u.name pengolah,
                CASE
                    WHEN sk.sifat_surat=1 THEN "Biasa"
                    WHEN sk.sifat_surat=2 THEN "Penting"
                    WHEN sk.sifat_surat=3 THEN "Rahasia (Pengaduan)"
                    WHEN sk.sifat_surat=4 THEN "Rahasia (Kepegawaian)"
                    ELSE "Rahasia (Perkara Banding)"
                END sifat
                FROM t_surat_keluar'.$table.' sk LEFT JOIN ref_klasifikasi'.$table.' k ON sk.id_klasifikasi=k.id
                LEFT JOIN users u ON sk.user_input=u.nip';
        if ($this->rahasia != NULL) {
            $sql .= " WHERE sifat_surat > 2";
        } else {
            $sql .= " WHERE sifat_surat < 3";
        }
        $sql .= " AND sk.deleted=0 ";

        if ($this->bulan!="00" || $this->tahun!="NULL") {
            if ($this->bulan!="00") {
                $sql .= " AND MONTH(tanggal_surat)=".$this->bulan;
            }
            $this->tahun = $this->tahun!="NULL" ? $this->tahun : date('Y');
            $sql .= " AND YEAR(tanggal_surat)=".$this->tahun;
        }
        $sql .= " ORDER BY sk.no_agenda, sk.id, tanggal_surat";
        // dd($sql);
        $data = DB::select($sql);
        $this->row = count($data) + 5;
        
        $nama_satker = "PENGADILAN TINGGI AGAMA BANDUNG"; 

        return view('statistik_surat.export_buku_sk', [
            'data'        => $data,
            'nama_satker' => $nama_satker,
            'bulan'       => $this->get_bulan_indo($this->bulan),
            'tahun'       => $this->tahun,
            'rhs'         => $this->rahasia!=NULL ? "Rahasia" : "",
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
            'B' => 15,
            'C' => 30,
            'D' => 35,
            'E' => 50,
            'F' => 30,
            'G' => 30,
            'H' => 23,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A5:H'.$this->row)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:H'.$this->row)->getAlignment()->setVertical('center');
        
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
        }
        
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true, 'size' => 12]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            3 => ['font' => ['bold' => true, 'size' => 12]],
            5 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
