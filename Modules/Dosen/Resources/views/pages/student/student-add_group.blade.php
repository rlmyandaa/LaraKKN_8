@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Tambah Kelompok KKN
</div>
@endsection

@section('contentori')
<div>

    <form form action={{ route('dosen.student-group-store') }} method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>Kelompok</label>
            <input type="text" class="form-control" name="group_name" required="required" placeholder="Masukkan Nama Kelompok"> <br />
        </div>
        <div class="form-group">
            <label>Desa Penempatan</label>
            <input type="text" class="form-control" name="group_location" required="required" placeholder="Masukkan Lokasi Penempatan Kelompok"> <br />
        </div>
        <div class="form-group">
            <label>Total Anggota</label>
            <input type="number" class="form-control" name="member_count" required="required" placeholder="Masukkan Jumlah Anggota"> <br />
        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
    </form>
</div>
@endsection