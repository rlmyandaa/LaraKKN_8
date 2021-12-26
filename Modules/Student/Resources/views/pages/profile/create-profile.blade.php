@extends('modules.layouts.app-unregistered_profile')

@section('content')


                <div>
                    <div color="red">
                        <p style="color:green">Isi Biodata Terlebih Dahulu</p>
                    </div>
                    <form action={{ route('student.profile-store') }} method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" required="required" placeholder="Masukkan Nama"> <br />
                        </div>
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="number" class="form-control" name="nim" required="required" placeholder="Masukkan NIM"> <br />
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select class="form-control form-control-md" name="gender">
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group" margin>
                            <label>Angkatan</label>
                            <input type="number" class="form-control" name="angkatan" required="required" placeholder="Tahun Masuk/Angkatan"> <br />
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
                            <label>Jurusan</label>
                            <input type="text" class="form-control" name="jurusan" required="required" placeholder="Jurusan"> <br />
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