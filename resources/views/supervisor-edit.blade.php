@extends('index')
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="containter-fluid">
            <!-- Modal Edit-->
            <form action="/api/supervisor-edit" method="POST">
                <input type="text" name="id" id="id" value="{{$data->id}}" hidden>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Supervisor Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-success">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="program_name">Program Name</label>
                                    <input name="program_name" id="program_name" class="form-control form-control-sm" type="text" placeholder="program name" value="{{$data->program_name}}">
                                </div>
                                <div class="form-group custom-control custom-switch">
                                    <input name="auto_start" type="checkbox" class="custom-control-input" id="auto_start" checked>
                                    <label class="custom-control-label" for="auto_start" >Auto Start</label>
                                </div>
                                <div class="form-group custom-control custom-switch">
                                    <input name="auto_restart" type="checkbox" class="custom-control-input" id="auto_restart" checked>
                                    <label class="custom-control-label" for="auto_restart">Auto Restart</label>
                                </div>
                                <div class="form-group">
                                    <label for="num_procs">Number of Processes</label>
                                    <input name="num_procs" type="number" class="form-control form-control-sm" value="{{$data->numprocs}}" id="num_procs" placeholder="how many processes?">
                                </div>
                                <div class="form-group">
                                    <label for="stopwaitsecs">StopWaitSecs</label>
                                    <input name="stopwaitsecs" type="number" class="form-control form-control-sm" value="{{$data->stopwaitsecs}}" id="stopwaitsecs" placeholder="how many secs?">
                                </div>
                                <div class="form-group">
                                    <label for="sleep">Sleep</label>
                                    <input name="sleep" type="number" class="form-control form-control-sm" value="{{$data->sleep}}" id="sleep" placeholder="how many secs?">
                                </div>
                                <div class="form-group">
                                    <label for="time_out">Time Out</label>
                                    <input name="timeout" type="number" class="form-control form-control-sm" value="{{$data->timeout}}" id="time_out" placeholder="how many secs?">
                                </div>
                                <div class="form-group">
                                    <label for="tries">Tries</label>
                                    <input name="tries" type="number" class="form-control form-control-sm" value="{{$data->tries}}" id="tries" placeholder="how many times?">
                                </div>
                                <div class="form-group">
                                    <label for="queue">Queue</label>
                                    <select name="queue" id="queue" value="{{$data->queue}}">
                                        <option value="default" default>Default</option>
                                        <option value="processing">Processing</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="save" >Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>


<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

