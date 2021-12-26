@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Edit Detail Kelompok
</div>
@endsection

@section('contentori')


@foreach ($data as $d)
<form action={{ route('dosen.student-group-detail-update') }} method="post">
    {{ csrf_field() }}
    <input type="hidden" name="unique_id" value="{{ $d->unique_id }}"> <br />
    <div class="form-group">
        <label>Nama Kelompok</label>
        <input type="text" class="form-control" name="group_name" required="required" placeholder="Masukkan Nama Kelompok" value="{{ $d->group_name }}"> <br />
    </div>
    <div class="form-group">
        <label>Lokasi Penempatan Desa</label>
        <input type="text" class="form-control" name="village_name" required="required" placeholder="Masukkan Lokasi Penempatan" value="{{ $d->village_name }}"> <br />
    </div>
    <div class="form-group">
        <label>Total Anggota</label>
        <input type="number" class="form-control" name="member_count" required="required" placeholder="Masukkan Jumlah Anggota" value="{{ $d->member_count }}"> <br />
    </div>
    <div class="form-group">
        <label>Alamat Kantor Desa</label>
        <input type="text" class="form-control" name="village_center_address" required="required" placeholder="Masukkan Alamat Kantor Desa" value="{{ $d->village_center_address }}"> <br />
    </div>
    <div class="form-group">
        <label>Nama Kepala Desa</label>
        <input type="text" class="form-control" name="village_head_name" required="required" placeholder="Masukkan Nama Kepala Desa" value="{{ $d->village_head_name }}"> <br />
    </div>
    <div class="form-group">
        <label>No. Telepon Kepala Desa</label>
        <input type="text" class="form-control" name="village_head_phone" required="required" placeholder="Masukkan No. Telepon Kepala Desa" value="{{ $d->village_head_phone }}"> <br />
    </div>
    <div class="form-group">
        <label>Pembimbing Babinsa</label>
        <input type="text" class="form-control" name="babinsa_name" required="required" placeholder="Masukkan Nama Pembimbing Babinsa" value="{{ $d->babinsa_name }}"> <br />
    </div>
    <div class="form-group">
        <label>No. Telepon Pembimbing Babinsa</label>
        <input type="text" class="form-control" name="babinsa_phone" required="required" placeholder="Masukkan No. Telepon Pembimbing Babinsa" value="{{ $d->babinsa_phone }}"> <br />
    </div>
    <input type="submit" class="btn btn-primary" value="Submit">
</form>
@endforeach
</div>



@endsection

@section('footer_scripts')
@endsection