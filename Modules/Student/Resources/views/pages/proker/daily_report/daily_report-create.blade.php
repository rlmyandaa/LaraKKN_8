@extends('Modules.layouts.app-f')


@push('styles_addon')
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('scripts_addon')
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
@endpush



@section('content')
<div class="card">
    <div class="card-header">
        <div>
            Laporan Harian KKN
        </div>
    </div>


    @switch($msg ?? '')
    @case(1)
    <div class="alert alert-success">
        Laporan Berhasil Dibuat.
    </div>
    @break

    @case(2)
    <div class="alert alert-danger">
        Laporan Gagal Dibuat! <br />
        - Cek file yang diupload, pastikan format foto.<br />
        - Pastikan ukuran kurang dari ukuran maksimal.<br />
    </div>
    @break
    

    @default

    @endswitch

    <div class="card-body">
        <div class="card">
            <div class="card-header">
                Form Pengisian Laporan Harian KKN
            </div>
            <div class="card-body">
                <div class="col-lg-8 mx-auto my-5">
                    <form action="{{ route('student.proker-daily_report-upload') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <b>Tanggal Pelaksanaan</b><br />
                            <input type="date" name="report_date" id="datepicker" width="276" />
                            
                        </div>
                        <div class="form-group">
                            <b>Keterangan Laporan</b><br />
                            <textarea class="form-control" name="report_detail" required="required"></textarea>
                        </div>
                        <div class="form-group">
                            <b>File Dokumentasi, format jpg,jpeg,png,bmp , max 15 MB.</b><br />
                            <input type="file" class="@error('file') is-invalid @enderror" name="files[]" value="{{ old('file') }}" required="required" multiple>
                        </div>


                        <input type="submit" value="Upload" class="btn btn-primary">
                    </form>
                    <br />
                </div>

            </div>
        </div>

    </div>

</div>

@stop