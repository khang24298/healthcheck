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
                    <th style="width:2em">ID</th>
                    <th style="width:3em">Server IP</th>
                    <th style="width:2em">Port</th>
                    <th style="width:2em">Status</th>
                    <th style="width:1em">Ratio Alive</th>
                    <th style="width:2em">Internet Access</th>
                    <th style="width:1em">Ratio Internet Access</th>
                    <th style="width:2em">Final Die</th>
                    <th style="width:2em">Final Alive</th>
                  </tr>
                  </thead>
                  <tbody>
                @if($data)

                  @foreach($data as $item)
                    @if($item->isChecking == 0 && $item->isDoubleCheck == 0)
                    <!-- First va double deu chay xong -->
                      <tr>
                        <!-- ID -->
                        <td>{{ $item->id }}</td>

                        <!-- IP -->
                        <td>{{ $item->ip }}</td>

                        <!-- PORT -->
                        <td>{{ $item->port }}</td>

                        <!-- Status  -->
                        <td>
                          @if($item->current_status == 1)
                          <!-- Icon success neu song -->
                          <img style="width: 2em; border-radius:50%" src="https://s.pngix.com/pngfile/s/96-964843_simple-green-check-button-clip-art-green-check.png" alt="">
                          @else
                          <!-- Icon fail neu chet -->
                          <img style="width: 2em; border-radius:50%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7cGyBBKloTyQ56XcpLM_8FZutq8Eb60XkIQ&usqp=CAU" alt="">
                          @endif
                        </td>

                        <!-- Ti le song -->
                        <td>{{ (number_format($item->alive_times/$item->total_attempts,2))*100 }} %</td>
                        
                        <!-- Internet Access -->
                        <td>
                          @if($item->isNetCheck == 1)
                          <!-- Icon loading neu dang check net -->
                          <img style="width: 2em; border-radius:50%" src="dist/img/isLoading.gif" alt=""></td>
                          @else
                          <!-- Neu da check net xong -->
                            @if($item->isInternetConnect == 1)
                            <!-- Icon success neu access dc internet -->
                            <img style="width: 2em; border-radius:50%" src="https://s.pngix.com/pngfile/s/96-964843_simple-green-check-button-clip-art-green-check.png" alt="">
                            @else
                            <!-- Icon fail neu ko access dc internet -->
                            <img style="width: 2em; border-radius:50%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7cGyBBKloTyQ56XcpLM_8FZutq8Eb60XkIQ&usqp=CAU" alt=""> 
                            @endif
                          @endif
                        </td>

                        <!-- Ti le access internet -->
                        <td>{{ (number_format($item->net_access_times/$item->alive_times,2))*100 }} %</td>

                        <!-- Thoi gian chet gan nhat -->
                        <td>{{ $item->final_die_time }}</td>

                        <!-- Thoi gian song gan nhat -->
                        <td>{{ $item->final_alive_time }}</td>
                      </tr>                     
                    @else
                    <!-- Mot trong 2 thang dang chay -->
                      <tr>
                        <!-- ID -->
                        <td>{{ $item->id }}</td>

                        <!-- IP -->
                        <td>{{ $item->ip }}</td>

                        <!-- PORT -->
                        <td>{{ $item->port }}</td>

                        <!-- Status   -->
                        <td>
                          @if($item->isChecking == 1)
                          <button class="btn bg-success">First</button>
                          @else
                          <button class="btn bg-success">Second</button>
                          @endif
                        </td>

                        <!-- Ti le song -->
                        <td>{{ (number_format($item->alive_times/$item->total_attempts,2))*100 }} %</td>
                        
                        <!-- Internet Access -->
                        <td>
                          @if($item->isNetCheck == 1)
                          <!-- Icon loading neu dang check net -->
                          <img style="width: 2em; border-radius:50%" src="dist/img/isLoading.gif" alt=""></td>
                          @else
                          <!-- Neu da check net xong -->
                            @if($item->isInternetConnect == 1)
                            <!-- Icon success neu access dc internet -->
                            <img style="width: 2em; border-radius:50%" src="https://s.pngix.com/pngfile/s/96-964843_simple-green-check-button-clip-art-green-check.png" alt="">
                            @else
                            <!-- Icon fail neu ko access dc internet -->
                            <img style="width: 2em; border-radius:50%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7cGyBBKloTyQ56XcpLM_8FZutq8Eb60XkIQ&usqp=CAU" alt=""> 
                            @endif
                          @endif
                        </td>

                        <!-- Ti le access internet -->
                        <td>{{ (number_format($item->net_access_times/$item->alive_times,2))*100 }} %</td>

                        <!-- Thoi gian chet gan nhat -->
                        <td>{{ $item->final_die_time }}</td>

                        <!-- Thoi gian song gan nhat -->
                        <td>{{ $item->final_alive_time }}</td>
                      </tr> 
                    @endif
                  @endforeach
                @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Server IP</th>
                    <th>Port</th>
                    <th>Status</th>
                    <th>Ratio Alive</th>
                    <th>Internet Access</th>
                    <th>Ratio Internet Access</th>
                    <th>Final Die</th>
                    <th>Final Alive</th>                  
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