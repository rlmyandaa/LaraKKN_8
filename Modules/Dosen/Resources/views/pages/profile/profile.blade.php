@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Profil Dosen
</div>
@endsection

@section('contentori')


<div>
    <table class="table">
        <thead></thead>
        @foreach($data as $d)
        <tbody>

            <tr>
                <td style="width: 15%">Nama</td>
                <td>{{ $d->name }}</td>
            </tr>
            <tr>
                <td style="width: 15%">NIM</td>
                <td>{{ $d->nip }}</td>
            </tr>
            <tr>
                <td style="width: 15%">Jenis Kelamin</td>
                <td>{{ $d->gender }}</td>
            </tr>
            <tr>
                <td style="width: 15%">Fakultas</td>
                <td>{{ $d->faculty }}</td>
            </tr>
            <tr>
                <td style="width: 15%">Departemen</td>
                <td>{{ $d->major }}</td>
            </tr>
            <tr>
                <td style="width: 15%">Telepon</td>
                <td>{{ $d->phone }}</td>
            </tr>
            <tr>
                <td style="width: 15%">Email</td>
                <td>{{ $d->email }}</td>
            </tr>
            <tr>
                <td style="width: 15%">Alamat Bandung</td>
                <td>{{ $d->address }}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
    <a type="button" class="btn btn-primary" href={{ route('dosen.profile-edit') }}>Edit Biodata</a>
</div>



@endsection

@section('footer_scripts')
@endsection