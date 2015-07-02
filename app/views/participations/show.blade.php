@extends('templates/base')

@section('content')

{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
   <h1>
     	Form Partisipasi Kegiatan
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
            	<div class="box-header">
            		<h2 class="box-title">List Peserta Kegiatan</h2>
            	</div>

               <div class="box-body table-responsive">
                  <div class="list-group">
                     <a href="#" class="list-group-item">
                        <i class=="fa fa-calendar"></i> {{ date('d-m-Y', strtotime($activity->agenda)) }}
                        <span class="pull-right text-muted small"><em>Jadwal</em></span>
                     </a>
                     <a href="#" class="list-group-item">
                        <i class=="fa fa-calendar"></i> {{ $activity->name }}
                        <span class="pull-right text-muted small"><em>Nama Kegiatan</em></span>
                     </a>
                     <a href="#" class="list-group-item">
                        <i class=="fa fa-calendar"></i> {{ $activity->coordination }}
                        <span class="pull-right text-muted small"><em>Koordinasi</em></span>
                     </a>
                  </div>

               	<button class="btn btn-success" onclick="showFormParticipant()">
               		<i class="fa fa-plus"></i> Tambah Peserta Kegiatan
               	</button>

               	<div class="clear-fix"><br/></div>

                  <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                 	<table class="table table-striped table-bordered table-hover table-condensed" id="data-table">
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
                              	<img src="{{ URL::to('assets/img/students')}}/{{ $participation->issue->student->photo }}" class="img-polaroid"> 
                                 {{ $participation->issue->issue }}
                                 {{ $participation->issue->student->name }}
                              </div>
                            </td>
                            <td>{{ $participation->employee->name }}</td>
                            <td>{{ date('d-m-Y', strtotime($participation->created_at)) }}</td>
                            <td><span class="badge bg-green">Rp{{ number_format($participation->registration_fee,2,'.',',') }}</span></td>
                            <td>
                              <div class="mytooltip">
                                 <button class="btn btn-circle btn-danger" onclick="cancel({{ $participation->id }})" data-toggle="tooltip" data-placement="top" title="Klik untuk Batalkan"><i class="fa fa-trash-o"></i></button>
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

<!-- Form Add Participant [modal]
===================================== -->
<div id="formParticipant" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Tambahkan Peserta</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="students">Cari Siswa</label>
                        <div class="col-lg-8">
                           <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                           <input type="text" name="students" class="form-control" data-provide="typeahead" placeholder="Ketikkan Nomor Pokok">
                           <input type="hidden" name="issue" value="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="fee">Biaya PDF</label>
                        <div class="col-lg-6">
                            <input name="fee" type="text" class="form-control currency" value="0">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="addParticipant()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Add Participant [modal] -->

{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/currency.js') }}
{{ HTML::script('assets/js/plugins/typeahead/bootstrap-typeahead.js') }}

<script type="text/javascript">
  $(function(){
      $('#data-table').dataTable();
      $('.currency').keyup(function(){
         $(this).val(formatCurrency($(this).val()));
      });

      $('[name=students]').typeahead({
         source : function(query, process){
            return $.get("{{ URL::to('softfilterstudents') }}/"+query, function(response){
                //response = $.parseJSON(response);
                var sourceArr = []; 
                for(var i = 0; i < response.length; i++)
                {
                    sourceArr.push(
                        response[i].id +"#"+ response[i].issue +"#"+ response[i].student_id +"#"+ response[i].student.name
                        );
                }
                return process(sourceArr);
            })
         },
         highlighter : function(item){
            var student = item.split('#');
            var item = ''
                    + "<div class='typeahead_wrapper'>"
                    + "<span class='typeahead_photo fa fa-2x fa-user'></span>"
                    + "<div class='typeahead_labels'>"
                    + "<div class='typeahead_primary'>" + student[1] + "</div>"
                    + "<div class='typeahead_secondary'>" + student[3] + "</div>"
                    + "</div>"
                    + "</div>";
            return item;
         },
         updater : function(item){
            var student = item.split('#');
            $('[name=issue]').val(student[0]);
            return student[1]+ ' / ' +student[3];
         }
      });
   });
	
   function showFormParticipant()
	{
		$('#formParticipant').modal('show');
	}

	function addParticipant()
	{
		var activity = $('[name=activity_id]').val();
		var issue_id = $('[name=issue]').val();
		var fee = $('[name=fee]').val();

		if(issue_id != '0'){
      $.ajax({
          url:"{{ URL::to('partisipasi') }}",
          type:'POST',
          data:{activity:activity, issue_id:issue_id, fee:fee},
          success:function(){
              window.location = "{{ URL::to('partisipasi') }}/"+activity;
          }
      });
    }
    else{
      window.alert("Lengkapi Inputan Anda!!");
    }
	}

  	function cancel(id)
  	{ 
	    var activity = $('input[name=activity_id]').val();

	    if(confirm("Yakin akan membatalkan keikutsertaan?!"))
	    {
	         $.ajax({
	            url:"{{ URL::to('partisipasi') }}/"+id,
	            type:'DELETE',
	            success:function(){
	                window.location = "{{ URL::to('partisipasi') }}/"+activity;
	            }
	        });
	    }
	}
</script>
@stop