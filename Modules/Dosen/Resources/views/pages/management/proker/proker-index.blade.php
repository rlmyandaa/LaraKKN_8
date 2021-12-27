@extends('Modules.layouts.app-f')

@section('pagetittle')
<div>
    Program Kerja Kelompok KKN
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
                        <th>Proposal Proker ACC</th>
                        <th>Proposal Proker Pending</th>
                        <th>Option</th>
                    </thead>
                    <?php
                    $count = 0;
                    ?>
                    @foreach($data as $data)
                    <tbody>

                        <tr>
                            <td>
                                <?php
                                echo ($count = $count + 1);
                                ?>
                            </td>
                            <td>
                                {{ $data->group_name }}
                            </td>

                            @if($data->proker_acc_count===NULL)
                            @if($data->proker_pending_count>0)
                            <td style="color: orange;">
                                Proker diajukan, sedang/belum ditinjau.
                            </td>
                            @elseif($data->proker_pending_count===NULL)
                            <td style="color: orange;">
                                Belum mengajukan proker.
                            </td>
                            @endif
                            @else
                            <td>
                                {{ $data->proker_acc_count }}
                            </td>
                            @endif
                            @if($data->proker_pending_count===NULL)
                            <td style="color: orange;">
                                Belum mengajukan proker.
                            </td>
                            @else
                            <td>


                                {{ $data->proker_pending_count }}
                            </td>
                            @endif
                            <td>
                                <a type="button" class="btn btn-sm btn-primary" href="/dosen/proker/group-detail/{{ $data->unique_id }}">Detail</a>
                            </td>
                        </tr>

                    </tbody>
                    @endforeach

                </table>
            </div>
            <div>
                <a type="button" class="btn btn-primary" href={{ route('dosen.student-group-add') }}>Tambah Kelompok</a>
            </div>


        </div>
    </div>

</div>
<br />
<div>
    <div class="card">
        <div class="card-header">
            Daftar Proker Pending
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Nama Kelompok</th>
                        <th>Judul Proposal</th>
                        <th>Option</th>
                    </thead>
                    <?php
                    $count = 0;
                    ?>

                    <tbody>
                        @foreach($groupPendingName as $pendingname)
                        <tr>
                            <td>
                                <?php
                                echo $count = $count + 1;
                                ?>
                            </td>
                            <td>
                                {{ $pendingname }}
                            </td>
                            <td>
                                {{ $prokerPendingName[$count-1] }}
                            </td>
                            <td>
                                <a type="button" class="btn btn-sm btn-primary" href="/dosen/proker/detail/{{ $prokerPendingUid[$count-1] }}">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>



        </div>
    </div>

</div>
<br />
<div>
    <div class="card">
        <div class="card-header">
            Daftar Proker Reject
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Nama Kelompok</th>
                        <th>Judul Proposal</th>
                        <th>Keterangan Ditolak</th>
                        <th>File Proker</th>
                    </thead>
                    <?php
                    $count = 0;
                    ?>
                    <tbody>
                        @foreach($groupRejectName as $pendingname)
                        <tr>
                            <td>
                                <?php
                                echo $count = $count + 1;
                                ?>
                            </td>
                            <td>
                                {{ $pendingname }}
                            </td>
                            <td>
                                {{ $prokerRejectName[$count-1] }}
                            </td>
                            <td>
                                {{ $prokerRejectComment[$count-1] }}
                            </td>
                            <td>
                                <a type="button" class="btn btn-sm btn-warning" href="/dosen/proker/detail/dlr/{{ $prokerRejectFileName[$count-1] }}">File Proker</a>
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