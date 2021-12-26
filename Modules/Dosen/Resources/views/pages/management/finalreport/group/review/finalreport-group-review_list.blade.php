@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Program Kerja Kelompok KKN
</div>
@endsection

@section('contentori')
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<div class="card">
    <div class="card-header text-center" style="font-weight:bold;">
        Laporan Akhir KKN<br />
        Kelompok {{ $gname }}
        <div class="card">
            <div class="card-header">
                @include('dosen::pages.management.finalreport.nav.finalreport-nav')
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header text-center" style="font-weight: bold;">
                Daftar Revisi
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="text-center">
                        <th style="width: 5%;">
                            Revisi ke-
                        </th>
                        <th>
                            Tanggal Penyerahan
                        </th>
                        <th>
                            Status Revisi
                        </th>
                        <th>
                            Option
                        </th>
                    </thead>
                    <tbody>
                        @foreach($data as $data)
                        <tr>
                            <td>
                                {{ $data->fr_rev_count }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($data->fr_submitted_date)->translatedFormat('d F Y') }}
                            </td>
                            @switch($data->fr_rev_stat)
                            @case(0)
                            <td style="color: red;"> Belum Mengajukan Laporan</td>
                            @break

                            @case(1)
                            <td style="color: orange;"> Laporan diserahkan, perlu ditinjau.</td>
                            @break

                            @case(2)
                            <td style="color: orange;"> Revisi Diajukan, perlu ditinjau.</td>
                            @break

                            @case(3)
                            <td style="color: orange;"> Revisi Diajukan, sedang ditinjau.</td>
                            @break

                            @case(4)
                            <td style="color: orange;"> Revisi selesai ditinjau. Revisi ditugaskan.</td>
                            @break

                            @case(5)
                            <td style="color: green;"> Laporan telah selesai.</td>
                            @break

                            @default
                            @endswitch
                            <td>
                                @switch($data->fr_rev_stat)
                                @case(1)
                                <a type="button" class="btn btn-warning" href={{ route('dosen.management-finalreport-group-review-detail', ['id'=>$data->fr_uid]) }}>Tinjau</a>
                                @break
                                @case(2)
                                <a type="button" class="btn btn-warning" href={{ route('dosen.management-finalreport-group-review-detail', ['id'=>$data->fr_uid]) }}>Tinjau</a>
                                @break

                                @default
                                <a type="button" class="btn btn-primary" href={{ route('dosen.management-finalreport-group-review-detail', ['id'=>$data->fr_uid]) }}>Detail</a>
                                @break
                                @endswitch
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




@endsection