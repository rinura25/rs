@extends('layout.master')
 @section('judul')
     Location
 @endsection
 @section('content')
 <form action="/location_create" method="post">
  @csrf
  <div class="form-group">
      <label>Nama</label>
      <input type="text" class="form-control" name="name" value="{{ old('name') }}">
      <label>Deskripsi</label>
      <input type="text" class="form-control" name="description" value="{{ old('description') }}">
      <label>phone</label>
      <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
      <label>Email</label>
      <input type="text" class="form-control" name="email" value="{{ old('email') }}">
      <label>Alamat (Jalan)</label>
      <input type="text" class="form-control" name="line" value="{{ old('line') }}">
      <label>Kota</label>
      <input type="text" class="form-control" name="city" value="{{ old('city') }}">
      <label>Kode Pos</label>
      <input type="text" class="form-control" name="postalCode" value="{{ old('postalCode') }}">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection