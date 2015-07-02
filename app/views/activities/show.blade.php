@extends('templates/base')

@section('content')

<section class="content-header">
   <h1>
     	List Peserta Kegiatan
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
      <li><a href="#"> Akademik</a></li>
      <li><a href="{{ URL::to('partisipasi') }}"><i class="active"></i> Partisipasi Kegiatan</a></li>
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
                  <a href="{{ URL::to('kegiatan') }}/create" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Peserta Kegiatan</a>

                  <div class="clear-fix"><br/></div>

                 	<table class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
	                        <th>Pendaftar</th>
                          <th>Diterima Oleh</th>
                          <th>TGL Daftar</th>
                          <th>Biaya PDF</th>
	                        <th>Pembatalan</th>
                        </tr>
                     </thead>

                     <tbody>
                     @foreach($participations as $participation)
                        <tr>
                            <td>
                              <div class="pull-left image">
                                <img src="assets/img/photos/{{ $participation->student->photo }}" class="img-polaroid" alt="student Avatar">
                                <strong class="text-primary">{{ $participation->student->name }}</strong>
                              </div>
                            </td>
                            <td><strong class="badge bg-blue">{{ $participation->employee->name }}</strong></td>
                            <td><span class="badge bg-green">{{ date('d-m-Y', strtotime($participation->created_at)) }}</span></td>
                            <td><span class="badge bg-red">Rp{{ number_format($participation->registration_fee,2,'.',',') }}</span></td>
                            <td>
                              <button class="btn btn-sm btn-danger" onclick="cancel({{ $participation->id }})"><i class="fa fa-cancel"></i> Batalkan!</button>
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

<script type="text/javascript">
  function cancel()
  { 
    if(confirm("Yakin akan membatalkan keikutsertaan?!"))
    {
         $.ajax({
            url:"{{ URL::to('partisipasi') }}/"+id,
            type:'DELETE',
            success:function(){
                window.location = "{{ URL::to('partisipasi') }}";
            }
        });
    }
  }
</script>
@stop