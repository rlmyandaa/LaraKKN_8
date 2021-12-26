@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Laporan Akhir Kelompok
</div>
@endsection

@section('contentori')

<div>
    <div class="card">
        <div class="card-header text-center" style="font-weight: bold;">
            Daftar Kelompok
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Nama Kelompok</th>
                        <th>Status Laporan Akhir</th>
                        <th>Option</th>
                    </thead>
                    <?php
                    $count = 0;
                    ?>

                    <tbody>
                        @foreach ($data as $data)
                        <tr>
                            <td>
                                <?php echo ($count + 1); ?>
                            </td>
                            <td>
                                {{ $data->group_name }}
                            </td>

                            @switch($lr_stat[$count])
                            @case(0)
                            <td style="color: red;"> Belum Mengajukan Laporan</td>
                            @break

                            @case(1)
                            <td style="color: orange;"> Laporan diserahkan, perlu ditinjau.</td>
                            @break

                            @case(2)
                            <td style="color: orange;"> Revisi Diajukan, belum ditinjau.</td>
                            @break

                            @case(3)
                            <td style="color: orange;"> Revisi Diajukan, sedang ditinjau.</td>
                            @break

                            @case(4)
                            <td style="color: orange;"> Revisi selesai ditinjau, cek hasil tinjauan.</td>
                            @break

                            @case(5)
                            <td style="color: green;"> Laporan telah selesai.</td>
                            @break

                            @default

                            @endswitch

                            <td>
                                <a type="button" class="btn btn-primary" href="/dosen/finalreport/group/{{ $data->unique_id }}">
                                    Manage
                                </a>
                            </td>
                            <?php $count = $count = 1; ?>
                        </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>



        </div>
    </div>

</div>

@endsection