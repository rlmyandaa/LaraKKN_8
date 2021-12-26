@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Program Kerja Kelompok KKN
</div>
@endsection

@section('contentori')

<div>
    <div class="card">
        <div class="card-header">
            Detail Pengajuan Program Kerja
        </div>
        <div class="card-body">
            <table class="table">
                <thead></thead>
                <tbody>

                    <tr>
                        <td style="width: 15%">Kelompok KKN</td>
                        <td> {{ $gname }}</td>

                    </tr>
                    <tr>
                        <td style="width: 15%">Judul Program Kerja</td>
                        <td> {{ $data->proker_name }} </td>
                    </tr>
                    <tr>
                        <td style="width: 15%">Kategori</td>
                        <td> {{ $data->proker_category }} </td>
                    </tr>
                    <tr>
                        <td style="width: 15%">Keterangan</td>
                        <td> {{ $data->proker_detail }} </td>
                    </tr>
                    <tr>
                        <td style="width: 15%">File Proposal</td>
                        <td>
                            <a href="/dosen/proker/detail/dl/{{ $fileName }}"> {{ $data->proker_filename }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="card-body">
                                <form action="{{ route('dosen.management-proker-proposal_decide') }}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="proker_uid" value="{{ $data->proker_uid }}">
                                    <div class="form-group">
                                        <b>Keterangan</b>
                                        <textarea class="form-control" name="proker_comment"></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="action" value="accept" class="btn btn-success">Acc</button>
                                        <button type="submit" name="action" value="returned" class="btn btn-warning">Tolak</button>
                                    </div>

                                </form>
                            </div>
                        </td>
                    </tr>
                </tbody>



            </table>

        </div>
    </div>
</div>


@endsection