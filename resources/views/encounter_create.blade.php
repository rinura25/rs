@extends('layout.master')
 @section('judul')
     STATUS
 @endsection
 @section('content')
 <form action="/encounter" method="post">
  @csrf
  <div class="form-group">
      <label>ID Pasien</label>
      <input type="text" class="form-control" name="id_pasien" value="{{ old('id_pasien') }}">
      <label>Nama Pasien</label>
      <input type="text" class="form-control" name="nama_pasien" value="{{ old('nama_pasien') }}">
      <label>ID Dokter</label>
      <input type="text" class="form-control" name="id_dokter" value="{{ old('id_dokter') }}">
      <label>Nama Dokter</label>
      <input type="text" class="form-control" name="nama_dokter" value="{{ old('nama_dokter') }}">
      <label>ID Lokasi</label>
      <input type="text" class="form-control" name="id_lokasi" value="{{ old('id_lokasi') }}">
      <label>Nama Lokasi</label>
      <input type="text" class="form-control" name="nama_lokasi" value="{{ old('nama_lokasi') }}">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection