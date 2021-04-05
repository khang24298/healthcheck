
@extends('index')
@section('content')
<div class="content-wrapper">
    <section class="content">
    <div class="container-fluid">
        <div>
            <form action="/api/add-ip" method="POST">

                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Server IP Address</label>
                        <input name="ip" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter IP">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Port</label>
                        <input name="port" type="number" class="form-control" id="exampleInputPassword1" placeholder="Port">
                    </div>
                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    </section>
</div>
@endsection
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="../../dist/js/demo.js"></script> -->
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>