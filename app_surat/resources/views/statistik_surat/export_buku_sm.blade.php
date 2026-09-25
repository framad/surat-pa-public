<table border="1">
    <tr>
        <td align="center" colspan="10">
            LAPORAN SURAT MASUK {{ $rhs }}
        </td>
    </tr>
    <tr>
        <td align="center" colspan="10">
            {{ $nama_satker }}
        </td>
    </tr>
    <tr>
        <td align="center" colspan="10">
            @if ($bulan=='-' && $tahun=='NULL')
                SEMUA DATA
            @else
                {{ $bulan=='-' ? "SEMUA DATA" : "BULAN ".$bulan }} - {{ $tahun=='NULL' ? "SEMUA TAHUN" : "TAHUN ".$tahun }}
            @endif
        </td>
    </tr>
    <tr>
        <td align="center" colspan="10"></td>
    </tr>
    <tr>
        <th style="text-align:center">No.</th>
        <th style="text-align:center">No. Agenda</th>
        <th style="text-align:center">Kode Surat</th>
        <th style="text-align:center">Perihal</th>
        <th style="text-align:center">Dari</th>
        <th style="text-align:center">No. Surat</th>
        <th style="text-align:center">Tgl Surat</th>
        <th style="text-align:center">Pengolah</th>
        <th style="text-align:center">Tgl Masuk</th>
        <th style="text-align:center">Jenis Surat</th>
    </tr>
    @foreach($data as $row)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td align="center">{{ $row->no_agenda }}</td>
            <td>{{ $row->klasifikasi }}</td>
            <td>{{ $row->isi_ringkas }}</td>
            <td>{{ $row->dari }}</td>
            <td>{{ $row->no_surat }}</td>
            <td align="center">{{ date('d-M-Y', strtotime($row->tgl_surat))}}</td>
            <td>{{ $row->name }}</td>
            <td align="center">{{ date('d-M-Y', strtotime($row->tgl_diterima))}}</td>
            <td>{{ $row->sifat }}</td>
        </tr>
    @endforeach
</table>