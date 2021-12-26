@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Laporan Harian KKN
</div>
@endsection

@section('contentori')

<div class="card">
    <div class="card-header">
        Daftar Laporan Harian Pelaksanaan KKN
    </div>
    <div class="card-body">

        <div>
            <a type="button" class="btn btn-primary" href={{ route('student.proker-daily_report-add')}}>Buat Laporan Harian</a>
        </div>
        <br />
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
                        <a type="button" class="btn-sm btn-success" href="/student/proker/daily-report/detail/{{ $data->report_uid }}">Detail</a>
                        <a type="button" class="btn-sm btn-warning" href="/student/proker/daily-report/delete/{{ $data->report_uid }}">Hapus</a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection