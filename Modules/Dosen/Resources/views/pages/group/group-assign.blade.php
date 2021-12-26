@extends('modules.layouts.app')

@section('content')

<form>
    <div>
        Masukkan Token Kelompok
    </div>
    
  <div class="form-row align-items-center">
    
    <div class="col-auto">
      <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Token">
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
