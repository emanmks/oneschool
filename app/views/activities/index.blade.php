@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
   <h1>
     	Manajemen Kegiatan
   </h1>
   <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
      <li><a href="#"> Manajemen</a></li>
      <li><a href="kegiatan"><i class="active"></i> Kegiatan</a></li>
   </ol>
</section>

<section class="content">
   <div class="row">
        	<div class="col-xs-12">
            @if(Session::has('message'))
            <div class="alert alert-info alert-dismissable">
               <i class="fa fa-warning"></i>
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

               {{ Session::get('message') }}
            </div>
            @endif

            <div class="box">
               <div class="box-body table-responsive">
                  <a href="{{ URL::to('kegiatan') }}/create" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Agenda Kegiatan</a>

                  <div class="clear-fix"><br/></div>

                 	<table class="table table-striped table-bordered table-hover" id="data-table">
                     <thead>
                        <tr>
	                        <th>Tanggal</th>
	                        <th>Kegiatan</th>
	                        <th>Jenis Agenda</th>
	                        <th>Detail</th>
	                        <th width="10%">Aksi</th>
                        </tr>
                     </thead>

                     <tbody>
                     @foreach($activities as $activity)
                        <tr>
                           <td><span class="badge bg-yellow">{{ date('d-m-Y', strtotime($activity->agenda)) }}</span></td>
                           <td><strong class="badge bg-blue">{{ $activity->name }}</strong></td>
                           <td><span class="badge bg-green">{{ $activity->coordination }}</span></td>
                           <td><a href="{{ URL::to('kegiatan') }}/{{ $activity->id }}" class="btn btn-xs btn-primary">Lihat Detail</a></td>
                           <td>
                              <div class="mytooltip">
                                 <a href="{{ URL::to('kegiatan') }}/{{ $activity->id }}/edit" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Edit">
                                 	<i class="fa fa-edit"></i>
                                 </a>
                                 <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $activity->id }})" data-toggle="tooltip" data-placement="top" title="Hapus">
                                 	<i class="fa fa-trash-o"></i>
                                 </button>
                              </div>
                           </td>
                        </tr>
                     @endforeach
                     </tbody>
                 	</table>
               </div>
            </div>
        	</div>
   </div>
</section>

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}

<script type="text/javascript">
   $(document).ready(function() {
      $('#data-table').dataTable();
      $('.mytooltip').tooltip({
         selector: "[data-toggle=tooltip]",
         container: "body"
      })
 	});
</script>
@stop