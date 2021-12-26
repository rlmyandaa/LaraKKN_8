@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Program Kerja Kelompok KKN
</div>
@endsection

@section('contentori')
<div>
    <div class="card">
        <div class="card-header text-center" style="font-weight:bold;">
            Detail Laporan Harian Kelompok {{ $gname }}

        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>No</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Tanggal Pelaporan</th>
                    <th>Keterangan</th>
                    <th>Option</th>
                </thead>
                <?php
                $count = 0;
                ?>
                <tbody>
                    @foreach($daily_data as $data)
                    <tr>
                        <td>
                            <?php
                            echo ($count = $count + 1);
                            ?>
                        </td>
                        <td>{{ Carbon\Carbon::parse($data->report_date)->translatedFormat('d F Y') }}</td>
                        <td>{{ Carbon\Carbon::parse($data->report_date_submitted)->translatedFormat('d F Y') }}</td>
                        <td>{{ $data->report_detail }}</td>
                        <td>
                            <a type="button" class="btn-sm btn-success" href="/dosen/dailyreport/ddetail/{{ $data->report_uid }}">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection