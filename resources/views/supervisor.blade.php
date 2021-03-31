@extends('index')
@section('content')
<div class="content-wrapper">

    <section class="content">
        <div class="containter-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bordered Table</h3>
                    <!-- Button trigger modal -->
                   
                    
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
                                        <a href="/api/supervisor-edit/{{$item->id}}">
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