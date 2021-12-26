@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Detail Kelompok KKN
</div>
@endsection

@section('contentori')


<div>
    <table class="table">
        <thead></thead>
        @foreach($data as $d)
        <tbody>

            <tr>
                <td style="width: 15%">Nama Kelompok</td>
                <td> {{ $d-> group_name}}</td>
            </tr>
            <tr>
                <td style="width: 15%">Lokasi Desa Penempatan</td>
                <td>{{ $d-> village_name}}</td>
            </tr>
            <tr>
                <td style="width: 15%">Total Anggota</td>
                <td>{{ $d-> member_count}}</td>
            </tr>
            <tr>
                <td style="width: 15%">Alamat Kantor Desa</td>
                <td>{{ $d-> village_center_address}}</td>
            </tr>
            <tr>
                <td style="width: 15%">Nama Kepala Desa</td>
                <td>{{ $d-> village_head_name}}</td>
            </tr>
            <tr>
                <td style="width: 15%">No. Telepon Kepala Desa</td>
                <td>{{ $d-> village_head_phone}}</td>
            </tr>
            @foreach($dosen as $m)
            <tr>
                <td style="width: 15%">Pembimbing Kelompok</td>
                <td>{{ $m-> name}}</td>
            </tr>
            <tr>
                <td style="width: 15%">No. Telepon Pembimbing</td>
                <td>{{ $m-> phone}}</td>
            </tr>
            @endforeach
            <tr>
                <td style="width: 15%">Pembimbing Babinsa</td>
                <td>{{ $d-> babinsa_name}}</td>
            </tr>
            <tr>
                <td style="width: 15%">No. Telepon Babinsa</td>
                <td>{{ $d-> babinsa_phone}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
    <a type="button" class="btn btn-primary" href="/dosen/student/detail/edit/{{ $d->unique_id }}">Edit Detail</a>
</div>
<br />
<div class="card">
    <div class="card-header">
        Anggota Kelompok
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <th>No</th>
                <th>Nama</th>
                <th>No. Telepon</th>
            </thead>
            <?php
            $count = 0;
            ?>

            <tbody>
                @foreach($member_data as $md)
                <tr>
                    <td>
                        <?php
                        echo ($count = $count + 1);
                        ?>
                    </td>
                    <td>{{ $md->name }}</td>
                    <td>{{ $md->phone }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>


@endsection

@section('footer_scripts')
@endsection