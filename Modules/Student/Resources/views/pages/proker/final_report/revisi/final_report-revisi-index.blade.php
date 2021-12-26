@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Laporan Akhir KKN
</div>
@endsection

@section('contentori')

<table class="table">
    <thead>
        <th>Revisi ke-</th>
        <th>Tanggal Submit</th>
        <th>Status Revisi</th>
        <th>Option</th>
    </thead>
    <?php
    $count = 0;
    ?>
    <tbody>
        @foreach($data as $data)
        <tr>
            <td>
                {{ $data->fr_rev_count}}
            </td>
            <td>
                {{ $data->fr_submitted_date }}
            </td>
            @if($data->fr_revised == 1)
            <td style="color: orange;"> Revisi Diajukan</td>
            @else
            @switch($data->fr_rev_stat)
            @case(2)
            <td style="color: orange;"> Menunggu Tinjauan</td>
            @break
            @case(4)
            <td style="color: orange;"> Revisi selesai ditinjau. Cek hasil tinjauan.</td>
            @break

            @case(5)
            <td style="color: green;"> Laporan telah selesai.</td>
            @break

            @default
            @endswitch
            @endif

            <td>
                <a type="button" class="btn btn-primary" href='/student/proker/final-report/revisi/detail/{{ $data->fr_uid }}'>Detail</a>
            </td>


        </tr>
        @endforeach

    </tbody>

</table>




@endsection