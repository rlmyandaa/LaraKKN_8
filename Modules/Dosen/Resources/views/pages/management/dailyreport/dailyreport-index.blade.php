@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Laporan Harian Kelompok
</div>
@endsection

@section('contentori')

<div>
    <div class="card">
        <div class="card-header">
            Daftar Kelompok
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Nama Kelompok</th>
                        <th>Jumlah Laporan</th>
                        <th>Laporan Terakhir</th>
                        <th>Option</th>
                    </thead>
                    <?php
                    $count = 0;
                    ?>

                    <tbody>
                        @foreach($data as $data)
                        <tr>
                            <td>
                                <?php
                                echo ($count + 1);
                                ?>
                            </td>
                            <td>
                                {{ $data->group_name }}
                            </td>

                            <td>
                                {{ $dailyReportCount[$count] }}
                            </td>
                            <td>
                                {{ $dailyReportLast[$count] }}
                            </td>
                            <td>
                                <a type="button" class="btn btn-primary" href="/dosen/dailyreport/gdetail/{{ $data->unique_id }}">Detail</a>
                            </td>
                            <?php
                            ($count = $count + 1);
                            ?>
                        </tr>
                        @endforeach

                    </tbody>


                </table>
            </div>



        </div>
    </div>

</div>

@endsection