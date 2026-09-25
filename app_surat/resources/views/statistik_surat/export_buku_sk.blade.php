<table border="1">
    <tr>
        <td align="center" colspan="8">
            LAPORAN SURAT KELUAR {{ $rhs }}
        </td>
    </tr>
    <tr>
        <td align="center" colspan="8">
            {{ $nama_satker }}
        </td>
    </tr>
    <tr>
        <td align="center" colspan="8">
            @if ($bulan=='-' && $tahun=='NULL')
                SEMUA DATA
            @else
                {{ $bulan=='-' ? "SEMUA DATA" : "BULAN ".$bulan }} - {{ $tahun=='NULL' ? "SEMUA TAHUN" : "TAHUN ".$tahun }}
            @endif
        </td>
    </tr>
    <tr>
        <td align="center" colspan="8"></td>
    </tr>
    <tr>
        <th style="text-align:center">No.</th>
        <th style="text-align:center">Tgl Surat</th>
        <th style="text-align:center">Klasifikasi</th>
        <th style="text-align:center">Nomor Surat</th>
        <th style="text-align:center">Isi Ringkas</th>
        <th style="text-align:center">Tujuan</th>
        <th style="text-align:center">Pengolah</th>
        <th style="text-align:center">Jenis Surat</th>
    </tr>
    @foreach($data as $row)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td align="center">{{ date('d-M-Y', strtotime($row->tanggal_surat))}}</td>
            <td>{{ $row->klasifikasi }}</td>
            <td>{{ $row->nomor_surat }}</td>
            <td>{{ $row->isi_ringkas }}</td>
            <td>{{ $row->tujuan_surat }}</td>
            <td>{{ $row->pengolah }}</td>
            <td>{{ $row->sifat }}</td>
        </tr>
    @endforeach
</table>