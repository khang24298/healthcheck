
@extends('index')
@section('content')
<div class="content-wrapper">
    <section class="content">
    <div class="container-fluid">
        <div>
            <form action="/api/add-ip" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">IP Address</label>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                        </div>
                        <input name="ip" type="text" class="form-control" placeholder="127.0.0.1" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">IP Range</label>
                        <input name="range" type="number" class="form-control" id="exampleInputEmail1" placeholder="/24">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Port</label>
                        From<input name="portFrom" type="number" class="form-control" id="exampleInputPassword1" placeholder=":0">
                        To<input name="portTo" type="number" class="form-control" id="exampleInputPassword1" placeholder=":65353">
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
$(document).ready(function(){
    $(":input").inputmask();
    $("#phone").inputmask({
        mask: '999 999 9999',
        placeholder: ' ',
        showMaskOnHover: false,
        showMaskOnFocus: false,
        onBeforePaste: function (pastedValue, opts) {
            var processedValue = pastedValue;
            //do something with it
            return processedValue;
        }
    });
});
</script>