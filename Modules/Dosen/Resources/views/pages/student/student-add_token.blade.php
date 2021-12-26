@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Token Kelompok KKN
</div>
@endsection

@section('contentori')

<form action={{ route('dosen.student-group-token-update') }} method="post">
    <div>
        Masukkan Token untuk Kelompok
    </div>
    @foreach($data as $d)
    <div class="form-row align-items-center">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $d->id }}"> <br />
        <div class="col-auto">
            <input type="text" class="form-control mb-2" name="token" placeholder="Token">
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </div>
    </div>
    @endforeach
</form>

@endsection