@extends('layout.master')
@section('judul')
    Encounter
@endsection
@section('content')
    <section class="content">
        <!-- Default box -->
        <div class="card-body">
            <section class="content">
                <div class="col-md">
                    <form action="/encounter" method="GET">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search ID Encounter. . . " name="id">
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
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">Nama Dokter</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <tr>
                        <td> {{ $request->nama_pasien }} </td>
                        <td> {{ $request->nama_dokter }} </td>
                        <td> {{ $request->nama_lokasi }} </td>
                        <td> {{ $request->tanggal }} </td>
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
