@extends('index')
@section('content')
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered">
                  <thead>
                  <tr>
                    <th style="width:2em">Status</th>
                    <th style="width:2em;">Internet Access</th>
                    <th style="width:2em">ID</th>
                    <th style="width:4em">Server IP</th>
                    <th style="width:2em">Port</th>
                    <th style="width:1em">Total Attempts</th>
                    <th style="width:2em">Current Job</th>
                    <th style="width:2em">Final Die</th>
                    <th style="width:2em">Final Alive</th>
                    <th style="width:1em">Alive Times</th>
                  </tr>
                  </thead>
                  <tbody>
                @if($data)

                  @foreach($data as $item)
                    @if($item->isChecking == 0 && $item->isDoubleCheck == 0 && $item->isNetCheck == 0)
                    <!-- Kiem tra neu da check xong -->
                      @if($item->current_status == 1)
                      <!-- Doi sang mau xanh neu song -->
                      <tr>
                        <td><img style="width: 2em; border-radius:50%" src="https://s.pngix.com/pngfile/s/96-964843_simple-green-check-button-clip-art-green-check.png" alt=""></td>
                        @if($item->isInternetConnect == 1)
                        <td><img style="width: 2em; border-radius:50%" src="https://s.pngix.com/pngfile/s/96-964843_simple-green-check-button-clip-art-green-check.png" alt=""></td>
                        @else
                        <td><img style="width: 2em; border-radius:50%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7cGyBBKloTyQ56XcpLM_8FZutq8Eb60XkIQ&usqp=CAU" alt=""></td>
                        @endif
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->ip }}</td>
                        <td>{{ $item->port }}</td>
                        <td>{{ $item->total_attempts }}</td>
                        <td class="d-inline border-0">
                          <button class="btn bg-secondary">First</button>
                          <button class="btn bg-secondary float-right">Second</button>
                        </td>
                        <td>{{ $item->final_die_time }}</td>
                        <td>{{ $item->final_alive_time }}</td>
                        <td>{{ $item->alive_times }}</td>
                      </tr>
                      @else
                      <!-- Doi sang mau xam neu chet -->
                      <tr>
                        <td><img style="width: 2em; border-radius:50%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7cGyBBKloTyQ56XcpLM_8FZutq8Eb60XkIQ&usqp=CAU" alt=""></td>
                        <td><img style="width: 2em; border-radius:50%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7cGyBBKloTyQ56XcpLM_8FZutq8Eb60XkIQ&usqp=CAU" alt=""></td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->ip }}</td>
                        <td>{{ $item->port }}</td>
                        <td>{{ $item->total_attempts }}</td>
                        <td class="d-inline border-0">
                          <button class="btn bg-secondary">First</button>
                          <button class="btn bg-secondary float-right">Second</button>
                        </td>
                        <td>{{ $item->final_die_time }}</td>
                        <td>{{ $item->final_alive_time }}</td>
                        <td>{{ $item->alive_times }}</td>
                      </tr>
                      @endif
                      <!-- Neu dang kiem tra thi de mau vang -->
                    @else
                      <tr>
                        <td><img style="width: 2em; border-radius:50%" src="dist/img/isLoading.gif" alt=""></td>
                        <td><img style="width: 2em; border-radius:50%" src="dist/img/isLoading.gif" alt=""></td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->ip }}</td>
                        <td>{{ $item->port }}</td>
                        <td>{{ $item->total_attempts }}</td>
                        <td>
                          @if($item->isChecking == 1)
                          <div class="d-inline">
                            <button class="btn btn-success">First</button>
                            <button class="btn btn-secondary float-right">Second</button>
                          </div>
                          @else
                          <div class="d-inline">
                            <button class="btn btn-secondary">First</button>
                            <button class="btn btn-success float-right">Second</button>
                          </div>
                          @endif
                        </td>
                        <td>{{ $item->final_die_time }}</td>
                        <td>{{ $item->final_alive_time }}</td>
                        <td>{{ $item->alive_times }}</td>
                      </tr>
                    @endif
                  @endforeach
                @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Status</th>
                    <th>Internet Access</th>
                    <th>ID</th>
                    <th>Server IP</th>
                    <th>Port</th>
                    <th>Total Attempts</th>
                    <th>Current Job</th>
                    <th>Final Alive</th>   
                    <th>Alive Times</th>                  
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{ asset('dist/js/demo.js') }}"></script> -->
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>