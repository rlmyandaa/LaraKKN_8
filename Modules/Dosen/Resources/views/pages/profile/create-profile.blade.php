@extends('modules.layouts.app-unregistered_profile')

@section('content')


<div>
    <div color="red">
        <p style="color:green">Isi Biodata Terlebih Dahulu</p>
    </div>
    <form action={{ route('dosen.profile-store') }} method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama" required="required" placeholder="Masukkan Nama"> <br />
        </div>
        <div class="form-group">
            <label>NIP</label>
            <input type="number" class="form-control" name="nip" required="required" placeholder="Masukkan NIP"> <br />
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select class="form-control form-control-md" name="gender">
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Fakultas</label>
            <select class="form-control form-control-md" name="faculty">
                <option value="FPTK">FPTK</option>
                <option value="FPMIPA">FPMIPA</option>
                <option value="FPIPS">FPIPS</option>
                <option value="FPBS">FPBS</option>
                <option value="FIP">FIP</option>
                <option value="FPOK">FPOK</option>
                <option value="FPEB">FPEB</option>
                <option value="FPSD">FPSD</option>
            </select>
        </div>
        <div class="form-group">
            <label>Departemen</label>
            <input type="text" class="form-control" name="jurusan" required="required" placeholder="Departemen"> <br />
        </div>
        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" class="form-control" name="telepon" required="required" placeholder="Nomor Telepon"> <br />
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control" name="alamat" required="required" placeholder="Alamat"> <br />
        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
    </form>
</div>

@endsection

@section('footer_scripts')
@endsection