@extends('layout.master')
 @section('judul')
     STATUS
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
          <div class="row">
            {{-- <form onsubmit="window.location = 'http://domain.ca/blog/search/' + search.value; return false;"> --}}
            <form action="/pasien" method="get">
              @csrf
                <form class="form-inline">
                    <div class="form-group mx-sm-3 mb-2">
                      <label for="inputNIK" class="sr-only">NIK</label>
                      <input type="text" class="form-control" name="nik" placeholder="Masukkan NIK">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Cari Pasien</button>
                  </form>
            </form> 
          </div>
        </div>
        <!-- /.card-body -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    <!-- /.content -->
  </div>
  
@endsection