@extends('layout.master')
@section('judul')
    Cari Location
@endsection
@section('content')
    <section class="content">
        <!-- Default box -->
        <div class="card-body">
            <section class="content">
                <div class="col-md">
                    <form action="/location" method="GET">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search ID Lokasi. . . " name="id">
                            <button class="btn btn-danger" type="submit">search</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <div class="container">
            <table class="table">
                <thead class="thead-dark" align="center">
                    <tr>
                        <th scope="col">Nama Lokasi</th>
                        <th scope="col">ID</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Alamat</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <tr>
                        <td> {{ $request->name }} </td>
                        <td> {{ $request->id }} </td>
                        <td> {{ $request->description }} </td>
                        <td> {{ $request->line }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- VUE --}}

    {{-- <div id="app">
        <pasien-page></pasien-page>
    </div> --}}
    </div>
    <!-- /.card-body -->
    <!-- /.card-footer-->
    </div>
    <!-- /.card -->

    <!-- /.content -->
    </div>
    </section>
    {{-- VUE --}}
    {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
<script defer src="{{ mix('js/app.js') }}"></script> --}}
@endsection
