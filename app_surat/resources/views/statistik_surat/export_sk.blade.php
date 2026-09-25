<table>
    <tr>
        <td align="center" colspan="4">
            KLASIFIKASI SURAT KELUAR
        </td>
    </tr>
    <tr>
        <td align="center" colspan="4">
            {{ $nama_satker }}
        </td>
    </tr>
    <tr>
        <td align="center" colspan="4">
            BULAN {{ $bulan }} TAHUN {{ $tahun }}
        </td>
    </tr>
    <tr>
        <td align="center" colspan="4"></td>
    </tr>
    <tr>
        <th style="text-align:center">No.</th>
        <th style="text-align:center">Kode Surat</th>
        <th style="text-align:center">Jumlah</th>
        <th style="text-align:center"></th>
    </tr>
    @foreach($data_parent as $row)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td>{{ $row->parent }}</td>
            <td align="center">{{ $row->jumlah }}</td>
            <td></td>
        </tr>
    @endforeach
</table>

<table>
    <tr>
        <td align="center" colspan="4"></td>
    </tr>
    <tr>
        <td align="center" colspan="4">
            KLASIFIKASI SURAT KELUAR DETAIL
        </td>
    </tr>
    <tr>
        <td align="center" colspan="4"></td>
    </tr>
    <tr>
        <th style="text-align:center">No.</th>
        <th style="text-align:center">Kode Surat</th>
        <th style="text-align:center">Jumlah</th>
        <th style="text-align:center">Keterangan</th>
    </tr>
    @foreach($data as $row)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td>{{ $row->kode }}</td>
            <td align="center">{{ $row->jumlah }}</td>
            <td>{{ $row->nama }}</td>
        </tr>
    @endforeach
</table>