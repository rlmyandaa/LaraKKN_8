@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Program Kerja KKN
</div>
@endsection

@section('contentori')

<div class="card">
    <div class="card-header">
        Form Pengajuan Program Kerja KKN
    </div>
    <div class="card-body">
        <div class="col-lg-8 mx-auto my-5">

            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <li>{{ $error }}</li>
            </div>
            @endforeach
            @if($msg ?? '' == 1)
            <div class="alert alert-success">
                Proposal Berhasil Diajukan.
            </div>
            @endif

            <form action="{{ route('student.proker-propose-upload') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <b>Judul Proker</b><br />
                    <input type="text" name="proker_name" class="form-control" required="required" placeholder="Masukkan Juduk Proker">
                </div>

                <div class="form-group">
                    <b>Kategori Proker</b><br />
                    <input type="text" name="proker_category" class="form-control" required="required" placeholder="Masukkan Kategori Proker">
                </div>

                <div class="form-group">
                    <b>File Proposal Proker (.pdf), max 1 MB</b><br />
                    <input type="file" name="file">
                </div>

                <div class="form-group">
                    <b>Keterangan</b>
                    <textarea class="form-control" name="proker_detail" required="required"></textarea>
                </div>

                <input type="submit" value="Upload" class="btn btn-primary">
            </form>
            <br />
            <div>
                <b>Download Format File Proker</b><br />
                <a type="button" class="btn btn-primary" href="/student/proker/propose/formatproker">Format Proker</a>
            </div>
        </div>
    </div>
</div>




@endsection