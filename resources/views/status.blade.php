
 @extends('layout.master')
 @section('judul')
     STATUS
 @endsection
 @section('content')
 
    <!-- Main content -->
      
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
            <div class="col-12">
                <b>Auth URL :</b> {{ env('AUTH_BASE_URL') }} <br>
                <b>Base URL :</b> {{ env('SATU_SEHAT_BASE_URL') }} <br>
                <b>Client ID :</b> {{(env('CLIENT_ID')) }} <br>
                <b>Secret ID :</b> {{(env('CLIENT_SECRET')) }} <br>
                <b>Token :</b> {{ $access_token }} <br>
            </div>
          </div>  
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  
@endsection