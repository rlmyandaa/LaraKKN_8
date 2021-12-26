@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Laporan Akhir KKN
</div>
@endsection

@section('contentori')
<div class="card">
    <div class="card-header text-center">
        Pengumpulan Laporan Akhir KKN<br />
        
    </div>
    <div class="card-body">
        <table class="table">
            <thead></thead>
            <tbody>
                <tr>
                    <td style="width: 40%; font-weight:bold;">Nama Kelompok</td>
                    <td>{{ $groupName }}</td>
                </tr>
                <tr>
                    <td style="width: 40%; font-weight:bold;">Desa Penempatan</td>
                    <td>{{ $groupLocation }}</td>
                </tr>
                <tr>
                    <td colspan="2"> </td>
                </tr>
                <tr>
                    <td class="text-center" style="width: 40%; font-weight:bold;" colspan="2">Anggota Kelompok</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table table-bordered">
                            <thead>
                                <th style="width: 5%">
                                    No
                                </th>
                                <th style="width: 40%">
                                    Nama
                                </th>
                                <th style="width: 25%">
                                    NIM
                                </th>
                                <th style="width: 30%">
                                    Jurusan
                                </th>
                            </thead>
                            <?php
                            $count = 0;
                            ?>
                            <tbody>
                                @foreach($member_data as $member_data)
                                <tr>
                                    <td>
                                        <?php
                                        echo ($count = $count + 1);
                                        ?>
                                    </td>
                                    <td>{{ $member_data->name }}</td>
                                    <td>{{ $member_data->nim }}</td>
                                    <td>{{ $member_data->faculty.('-').$member_data->major }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="width: 40%; font-weight:bold;">Nama Pembimbing</td>
                    <td>{{ $mentor }}</td>
                </tr>
                <tr>
                    <td colspan="2"> </td>
                </tr>
                <tr>
                    <td class="text-center" style="width: 40%; font-weight:bold;" colspan="2">Status Program Kerja</td>
                <tr>
                    <td colspan="2">
                        <table class="table table-bordered">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 35%; font-weight:bold;">Jumlah Program Kerja : {{ $proker_count }} Program Kerja</td>

                                </tr>
                                <tr>
                                    <td>
                                        <table class="table table-bordered">
                                            <thead>
                                                <th style="width: 5%">
                                                    No
                                                </th>
                                                <th style="width: 40%">
                                                    Judul Program Kerja
                                                </th>
                                                <th style="width: 25%">
                                                    Kategori
                                                </th>
                                            </thead>
                                            <?php
                                            $count = 0;
                                            ?>
                                            <tbody>
                                                @foreach($proker_data as $pd)
                                                <tr>
                                                    <td>
                                                        <?php
                                                        echo ($count = $count + 1);
                                                        ?>
                                                    </td>
                                                    <td> {{ $pd->proker_name }}</td>
                                                    <td> {{ $pd->proker_category }}</td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tr>
                <tr>
                    <td class="text-center" style="width: 40%; font-weight:bold;" colspan="2">Status Laporan Harian</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table table-bordered">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 35%">Jumlah Laporan Harian</td>
                                    <td>{{ $dailyReportCount }} Laporan</td>
                                </tr>
                                <tr>
                                    <td style="width: 35%">Laporan Harian Terakhir</td>
                                    <td>{{ Carbon\Carbon::parse($dailyReportLast)->translatedFormat('d F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 40%; font-weight:bold;">Status Laporan Akhir</td>
                    @if ($fr_stat == 1)
                    <td style="color:green;">Laporan ACC dan Selesai</td>
                    @else
                    <td>Laporan Belum ACC/Selesai</td>
                    @endif
                </tr>
                <tr>
                    <td colspan="2">
                        <div>

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        @if ($kkn_finish_stat == 1)
        <div class="alert alert-success text-center">
            <b>KKN TELAH SELESAI</b>
        </div>
        @else
        @if ($fr_stat ==1)
        <div>
            <form action="{{ route('student.proker-final_report-final_submission-submit') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group alert alert-warning">

                    <input type="checkbox" name="agree" value="1">
                    <label> Dengan ini menyatakan laporan yang telah dibuat sudah benar dan segala kelengkapan data yang di submit telah sesuai.</label><br>

                </div>
                <input type="submit" value="Serahkan Laporan" class="btn btn-primary">

            </form>
        </div>
        @endif

    </div>
    @endif
</div>

@endsection