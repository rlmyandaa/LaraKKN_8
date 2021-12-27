@extends('Modules.layouts.app-f')

@section('pagetittle')
<div>
    Program Kerja Kelompok KKN
</div>
@endsection

@section('contentori')
<div class="card">
    <div class="card-header text-center" style="font-weight:bold;">
        Laporan Akhir KKN<br />
        Kelompok {{ $gname }}
        <div class="card">
            <div class="card-header">
                @include('dosen::pages.management.finalreport.nav.finalreport-nav')
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header text-center" style="font-weight: bold;">
                Detail Revisi
            </div>
            <div class="card-body">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
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
                            <td style="width: 15%">Keterangan </td>
                            <td> {{ $data->fr_student_rev_comment }} </td>
                        </tr>
                        <tr>
                            <td style="width: 15%">File Laporan</td>
                            <td>
                                <a href="/dosen/finalreport/review/getfile/{{ $data->fr_uid }}"> {{ $data->fr_filename }}</a>
                            </td>
                        </tr>
                        @if ($data->fr_rev_stat != 4 && $data->fr_rev_stat != 5)
                        <tr>
                            <td colspan="2">
                                <div class="card-body">
                                    <form action="{{ route('dosen.management-finalreport-group-review-submit') }}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="fr_uid" value="{{ $data->fr_uid }}">
                                        <div class="form-group">
                                            <b>Keterangan</b>
                                            <textarea class="form-control" name="rev_comment"></textarea>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="action" value="accept" class="btn btn-success">Acc</button>
                                            <button type="submit" name="action" value="revisi" class="btn btn-warning">Revisi</button>
                                        </div>

                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @if ($data->fr_rev_stat == 4)
                        <tr class="table-warning">
                            <td style="width: 15%">Keterangan Revisi</td>
                            <td>
                                {{ $data->fr_dosen_rev_comment }}
                            </td>
                        </tr>
                        @endif
                    </tbody>



                </table>
            </div>
        </div>
    </div>
</div>




@endsection