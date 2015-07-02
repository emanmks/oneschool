@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
   <h1>
     	Partisipasi Kegiatan
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
      <li><a href="#"> Akademik</a></li>
      <li><a href="{{ URL::to('partisipasi') }}"><i class="active"></i> Partisipasi</a></li>
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
               <div class="box-body">
                 	<table class="table table-striped table-bordered table-hover table-condensed" id="data-table">
                     <thead>
                        <tr>
	                        <th>Tanggal</th>
	                        <th>Kegiatan</th>
	                        <th>Jenis Agenda</th>
	                        <th>Jumlah Peserta</th>
	                        <th>Partisipasi</th>
                        </tr>
                     </thead>

                     <tbody>
                     @foreach($activities as $activity)
                        <tr>
                           <td>{{ date('d-m-Y', strtotime($activity->agenda)) }}</td>
                           <td>{{ $activity->name }}</td>
                           <td>{{ $activity->coordination }}</td>
                           <td><span class="badge bg-red">{{ $activity->participations->count() }}</span></td>
                           <td><a href="{{ URL::to('partisipasi') }}/{{ $activity->id }}" class="btn btn-xs btn-primary">Partisipasi</a></td>
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