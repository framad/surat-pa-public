<table border="1">
    <tr>
        <td align="center" colspan="5">
            MONITORING DISPOSISI SURAT MASUK
        </td>
    </tr>
    <tr>
        <td align="center" colspan="5">
            {{ $nama_satker }}
        </td>
    </tr>
    <tr>
        <td align="center" colspan="5">
            @if ($bulan=='-' && $tahun=='NULL')
                SEMUA DATA
            @else
                {{ $bulan=='-' ? "SEMUA DATA" : "BULAN ".$bulan }} - {{ $tahun=='NULL' ? "SEMUA TAHUN" : "TAHUN ".$tahun }}
            @endif
        </td>
    </tr>
    <tr>
        <td align="center" colspan="5"></td>
    </tr>
    <tr>
        <th style="text-align:center">No.</th>
        <th style="text-align:center">No. Agenda</th>
        <th style="text-align:center">No. Surat</th>
        <th style="text-align:center">Tanggal Disposisi</th>
        <th style="text-align:center">History Disposisi</th>
    </tr>
    @foreach($data as $row)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td align="center">{{ $row['no_agenda'] }}</td>
            <td>{{ $row['no_surat'] }}</td>
            <td align="center">{{ date('d-M-Y', strtotime($row['tgl_disposisi']))}}</td>
            <td>
                {{ $row['hist_disposisi'] }}
            </td>
        </tr>
    @endforeach
</table>