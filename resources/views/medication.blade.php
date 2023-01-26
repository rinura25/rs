@extends('layout.master')
 @section('judul')
     STATUS
 @endsection
 @section('content')
 <form action="/medication" method="post">
  @csrf
  <div class="form-group">
      <label>Kode Obat</label>
      <input type="text" class="form-control" name="kfa_code" value="{{ old('kode_obat') }}">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection