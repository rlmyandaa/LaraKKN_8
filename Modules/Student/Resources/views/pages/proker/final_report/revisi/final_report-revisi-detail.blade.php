@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Laporan Akhir KKN
</div>
@endsection

@section('contentori')

<div class="card">
    <div class="card-header text-center">
        Detail Revisi
    </div>
    <div class="card-body">
        <div class="card-body">
            <table class="table">
                <thead></thead>
                <tbody>
                    <tr>
                        <td style="width: 15%">Kelompok KKN</td>
                        <td> {{ $gname }}</td>

                    </tr>
                    <tr>
                        <td style="width: 15%">Revisi Laporan ke- : </td>
                        <td> {{ $data->fr_rev_count }} </td>
                    </tr>
                    <tr>
                        <td style="width: 15%">Tanggal Penyerahan</td>
                        <td> {{ Carbon\Carbon::parse($data->fr_submitted_date)->translatedFormat('d F Y g:i:s ') }} </td>
                    </tr>
                    <tr>
                        <td style="width: 15%">File Laporan</td>
                        <td>
                            <a href="/student/proker/final-report/dl/{{ $data->fr_filename }}"> {{ $data->fr_filename }}</a>
                        </td>
                    </tr>
                    <tr class="table-warning">
                        <td style="width: 15%">Komentar Revisi dari Dosen</td>
                        <td>
                            {{ $data->fr_dosen_rev_comment }}
                        </td>
                    </tr>
                    @if($data->fr_revised != 1)
                    <tr>
                        <td colspan="2" class="text-center"><b>Ajukan Revisi</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="card-body">
                                <form action="{{ route('student.proker-final_report-revision_submit') }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="fr_uid" value="{{ $data->fr_uid }}">

                                    <div class="form-group">
                                        <b>File Revisi (.pdf), max 5 MB</b><br />
                                        <input type="file" name="file">
                                    </div>
                                    <div class="form-group">
                                        <b>Keterangan</b>
                                        <textarea class="form-control" name="rev_comment"></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" value="Upload" class="btn btn-warning">Ajukan Revisi</button>
                                    </div>

                                </form>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @if($data->fr_revised == 1)
                    <tr class="table-warning">
                        <td style="width: 15%">File Revisi</td>
                        <td>
                            <a href="/student/proker/final-report/dl/{{ $revData->fr_filename }}"> {{ $revData->fr_filename }}</a>
                        </td>
                    </tr>
                    <tr class="table-warning">
                        <td style="width: 15%">Keterangan Revisi</td>
                        <td>
                            {{ $revData->fr_student_rev_comment }}
                        </td>
                    </tr>
                    @endif
                </tbody>



            </table>
        </div>
    </div>
</div>



@endsection