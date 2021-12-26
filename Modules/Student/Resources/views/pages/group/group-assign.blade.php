@extends('modules.layouts.app-f')

@section('pagetittle')
<div>
    Input Token Grup
</div>
@endsection

@section('contentori')

<form action={{ route('student.group-token-update') }} method="post">

  <div>
    Masukkan Token Kelompok
  </div>
  {{ csrf_field() }}
  <div class="form-row align-items-center">
    <div class="col-auto">
      <input type="text" class="form-control mb-2" name="token" placeholder="Token">
    </div>

    <div class="col-auto">
      <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </div>

  </div>
  <div>
    <p style="color:green">
      Untuk mendapatkan token silahkan hubungi dosen pembimbing.
    </p>
  </div>
</form>

@endsection