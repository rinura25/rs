@extends('layout.master')
 @section('judul')
     Cari Dokter
 @endsection
 @section('content')
 @php
    use Illuminate\Http\Request;
@endphp
  <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"></h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <section class="content">
            <div class="col-md">
              <form action="/dokter" method="GET">
                @csrf
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Search ID Dokter. . . " name="id">
                  <button class="btn btn-danger" type="submit">search</button>
                </div>
              </form>
            </div>
          <table class="table">
            <thead class="thead-dark" align="center">
              <tr>
                <th scope="col">Nama Dokter</th>
                <th scope="col">Gender</th>
                <th scope="col">Alamat</th>
              </tr>
            </thead>
            <tbody align="center">
            <tr>
                <td> {{ $request->namaDokter }} </td>
                <td> {{ $request->gender }} </td> 
                <td> {{ $request->alamat }} </td> 
                    {{-- <td> {{ $object->gender }}</td> --}}
            </tr>
        </tbody>
        </table>
        </div>
        <!-- /.card-body -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    <!-- /.content -->
  </div>
  
@endsection