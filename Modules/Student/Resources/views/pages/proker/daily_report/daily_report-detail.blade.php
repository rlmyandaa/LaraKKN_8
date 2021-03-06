@extends('Modules.layouts.app-f')

@section('pagetittle')
<div>
    Laporan Harian KKN
</div>
@endsection

@section('contentori')

<div>
    <div class="card">
        <div class="card-header">
            Detail Laporan Harian Pelaksanaan KKN
        </div>
        <div class="card-body">
            <table class="table">
                <thead></thead>
                <tbody>
                    @foreach($data as $data)
                    <tr>
                        <td style="width: 15%">Kelompok KKN</td>
                        <td>{{ $gname }}</td>
                    </tr>
                    <tr>
                        <td style="width: 15%">Tanggal Kegiatan</td>
                        <td>{{ Carbon\Carbon::parse($data->report_date)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 15%">Tanggal Pelaporan</td>
                        <td>{{ Carbon\Carbon::parse($data->report_date_submitted)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 15%">Pembuat Laporan</td>
                        <td>{{ $student }}</td>
                    </tr>
                    <tr>
                        <td style="width: 15%">Detail Kegiatan</td>
                        <td>{{ $data->report_detail }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
</div>
<br />
<div>
    <div class="card">
        <div class="card-header">
            File Dokumentasi
        </div>
        <div class="card-body">
            <table class="table">
                <thead></thead>
                <tbody>

                    @for ($i = 0; $i < $fileCount; $i++) <tr>
                        <a href="/student/proker/daily-report/detail/file/{{ $files[$i][0] }}">{{ $files[$i][1] }}</a> <br />
                        </tr>
                        @endfor



                </tbody>

            </table>

        </div>
    </div>
</div>

@endsection