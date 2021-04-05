@extends('index')
@section('content')
<div class="content-wrapper">

    <section class="content">
        <div class="containter-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bordered Table</h3>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                        Create Supervisor
                    </button>
                    
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th >Process Name</th>
                        <th >File Execute</th>
                        <th>Num Processes</th>
                        <th>Auto Start</th>
                        <th>Auto Restart</th>
                        <th>StopWaitSecs</th>
                        <th>Sleep</th>
                        <th>Tries</th>
                        <th>Queue</th>
                        <th>Timeout</th>
                        <th colspans=2>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($data)
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->program_name }}</td>
                                    <td>{{ $item->file_exec }}</td>
                                    <td>{{ $item->numprocs }}</td>
                                    <td>{{ ($item->autostart == 1) ? "ON" : "OFF" }}</td>
                                    <td>{{ ($item->autorestart == 1) ? "ON" : "OFF" }}</td>
                                    <td>{{ $item->stopwaitsecs }}</td>
                                    <td>{{ $item->sleep }}</td>
                                    <td>{{ $item->tries }}</td>
                                    <td>{{ $item->queue }}</td>
                                    <td>{{ $item->timeout }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="runSupervisor({{$item->id}})">
                                            Run
                                        </button>  
                                    </td>
                                    <td> 
                                        <a href="/api/supervisor-edit/{{ $item->id }}">
                                            Edit
                                        </a>       
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>

    <!-- Modal Edit-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/api/supervisor" method="POST">
      
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Supervisor Create</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-success">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="program_name">Program Name</label>
                                    <input name="program_name" id="program_name" class="form-control form-control-sm" type="text" placeholder="process name">
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
                                    <input name="num_procs" type="number" class="form-control form-control-sm" id="num_procs" placeholder="how many processes?">
                                </div>
                                <div class="form-group">
                                    <label for="stopwaitsecs">StopWaitSecs</label>
                                    <input name="stopwaitsecs" type="number" class="form-control form-control-sm" id="stopwaitsecs" placeholder="how many secs?">
                                </div>
                                <div class="form-group">
                                    <label for="sleep">Sleep</label>
                                    <input name="sleep" type="number" class="form-control form-control-sm" id="sleep" placeholder="how many secs?">
                                </div>
                                <div class="form-group">
                                    <label for="time_out">Time Out</label>
                                    <input name="timeout" type="number" class="form-control form-control-sm" id="time_out" placeholder="how many secs?">
                                </div>
                                <div class="form-group">
                                    <label for="tries">Tries</label>
                                    <input name="tries" type="number" class="form-control form-control-sm" id="tries" placeholder="how many times?">
                                </div>
                                <div class="form-group">
                                    <label for="queue">Queue</label>
                                    <select name="queue" id="queue">
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
    </div>


</div>
@endsection
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>


<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script type="text/javascript">
$(function () {
  bsCustomFileInput.init();
});

function runSupervisor(item){
    // console.log(item);
    window.location.href="/api/supervisor/"+ item;
}


</script>