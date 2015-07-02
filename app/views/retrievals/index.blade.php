@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/css/datepicker/datepicker.css') }}

<section class="content-header">
    <h1>
        Pengambilan Handbook
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#">Kesiswaan</a></li>
        <li><a href="{{ URL::to('pengambilan') }}"><i class="active"></i> Pengambilan Handbook</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
           @if(Session::has('message'))
            <div class="alert alert-info alert-dismissable">
                <i class="fa fa-warning"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('message') }}
            </div>
            @endif

            <div class="box">
                <div class="box-body">
                	<button class="btn btn-primary" onclick="showFormCreate()"><i class="fa fa-plus"></i> Pengambilan Baru</button>
                	<div class="clear-fix"><br/></div>
                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Judul Handbook</th>
                                <th>Tanggal Ambil</th>
                                <th>Front Office</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($retrievals as $retrieval)
                            <tr>
                                <td>
                                    <div class="pull-left image">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $retrieval->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                            <a href="{{ URL::to('pengambilan') }}/{{ $retrieval->issue_id }}">
                                                {{ $retrieval->issue->issue }} /
                                                {{ $retrieval->issue->student->name }}
                                            </a>
                                    </div>
                                </td>
                                <td>{{ $retrieval->handbook->title }}</td>
                                <td>{{ date('d-m-Y', strtotime($retrieval->retrieval_date)) }}</td>
                                <td>{{ $retrieval->employee->name }}</td>
                                <td>
                                    <input type="hidden" id="issue-{{ $retrieval->id }}" value="{{ $retrieval->issue_id }}">
                                    <input type="hidden" id="issues-{{ $retrieval->id }}" value="{{ $retrieval->issue->issue }}">
                                    <input type="hidden" id="students-{{ $retrieval->id }}" value="{{ $retrieval->issue->student->name }}">
                                    <input type="hidden" id="handbook-{{ $retrieval->id }}" value="{{ $retrieval->handbook_id }}">
                                    <input type="hidden" id="employee-{{ $retrieval->id }}" value="{{ $retrieval->employee_id }}">
                                    <input type="hidden" id="date-{{ $retrieval->id }}" value="{{ $retrieval->retrieval_date }}">
                                    <div class="mytooltip">
                                        <button class="btn btn-circle btn-primary" onclick="showFormUpdate({{ $retrieval->id }})" data-toggle="tooltip" data-placement="top" title="Klik untuk Koreksi"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-circle btn-danger" onclick="destroy({{ $retrieval->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan!!!"><i class="fa fa-trash-o"></i></button>
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

<!-- Form Create Retrieval [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Pengambilan Handbook</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="students">Cari Siswa</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="students" data-provide="typeahead" placeholder="Ketikkan Nomor Pokok">
                            <input type="hidden" name="student" value="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="handbooks">Pilih Handbook</label>
                        <div class="col-lg-6">
                            <select class="form-control" name="handbooks">
                            	<option value="0">--Pilih Handbook</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="date">Tanggal Pengambilan</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" name="date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="employees">Front Office</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="employees">
                            	<option value="0">--Pilih Pegawai</option>
                            	@foreach($employees as $employee)
                            		<option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            	@endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onclick="create()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Create Retrieval [modal] -->

<!-- Form Update Retrieval [modal]
===================================== -->
<div id="formUpdate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Update Pengambilan Handbook</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_students">Cari Siswa</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="updated_students" data-provide="typeahead">
                            <input type="hidden" name="updated_student" value="0">
                            <input type="hidden" name="retrieval_id" value="0">
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_handbooks">Pilih Handbook</label>
                        <div class="col-lg-6">
                            <select class="form-control" name="updated_handbooks">
                            	<option value="0">--Pilih Handbook</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="upadted_date">Tanggal Pengambilan</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="updated_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_employees">Front Office</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="updated_employees">
                            	<option value="0">--Pilih Pegawai</option>
                            	@foreach($employees as $employee)
                            		<option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            	@endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onclick="update()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Update Retrieval [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/typeahead/bootstrap-typeahead.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();

        $('[name=date]').datepicker({format:"yyyy-mm-dd"});
        $('[name=updated_date]').datepicker({format:"yyyy-mm-dd"});

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
                $('[name=student]').val(student[0]);
                filterHandbook(student[0]);
                return student[1]+ ' / ' +student[3];
            }
        });

		$('[name=updated_students]').typeahead({
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
                $('[name=updated_student]').val(student[0]);
                filterUpdatedHandbook(student[0]);
                return student[1]+ ' / ' +student[3];
            }
        });
    });

	function filterHandbook(issue)
	{
		$.ajax({
            url:"{{ URL::to('filterhandbookbyissue') }}/"+issue,
            type:"GET",
            dataType:"json",
            success:function(handbooks){
                $('[name=handbooks]').html('');

                $('[name=handbooks]').append("<option value='0'>--Pilih Handbook</option>");

                for (var i = handbooks.length - 1; i >= 0; i--) {
                    $('[name=handbooks]').append("<option value='"+handbooks[i].id+"'>"+handbooks[i].title+"</option>");
                };
            }
        });
	}

	function filterUpdatedHandbook(issue, hb)
	{
		$.ajax({
            url:"{{ URL::to('filterhandbookbyissue') }}/"+issue,
            type:"GET",
            dataType:"json",
            success:function(handbooks){
                $('[name=updated_handbooks]').html('');

                $('[name=updated_handbooks]').append("<option value='0'>--Pilih Handbook</option>");

                for (var i = handbooks.length - 1; i >= 0; i--) {
                    $('[name=updated_handbooks]').append("<option value='"+handbooks[i].id+"'>"+handbooks[i].title+"</option>");
                };
                $('[name=updated_handbooks]').val(hb);
            }
        });
	}

    function showFormCreate()
    {
    	$('#formCreate').modal('show');
    }

    function create()
    {
    	var issue_id = $('[name=student]').val();
    	var handbook_id = $('[name=handbooks]').val();
    	var date = $('[name=date]').val();
    	var employee_id = $('[name=employees]').val();

    	if(issue_id != '0' && handbook_id != '0' && date != '' && employee_id != '0')
    	{
    		$.ajax({
	            url:"{{ URL::to('pengambilan') }}",
	            type:"POST",
	            data:{issue_id:issue_id, handbook_id:handbook_id, date:date, employee_id:employee_id},
	            success:function(){
	            	window.location = "{{ URL::to('pengambilan') }}";
	            }
	        });
    	}
    	else
    	{
    		window.alert('Tidak dapat diproses! Anda belum melengkapi Form');
    	}
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');

       	$('[name=retrieval_id]').val(id);
        $('[name=updated_student]').val($('#issue-'+id).val());
       	$('[name=updated_students]').val($('#issues-'+id).val()+' / '+$('#students-'+id).val());
       	$('[name=updated_date]').val($('#date-'+id).val());
       	$('[name=updated_employees]').val($('#employee-'+id).val());
       	filterUpdatedHandbook($('#issue-'+id).val(),$('#handbook-'+id).val());
    }

    function update()
    {
        var id = $('[name=retrieval_id]').val();
        var issue_id = $('[name=updated_student]').val();
    	var handbook_id = $('[name=updated_handbooks]').val();
    	var date = $('[name=updated_date]').val();
    	var employee_id = $('[name=updated_employees]').val();

    	if(issue_id != '0' && handbook_id != '0' && date != '' && employee_id != '0')
    	{
    		$.ajax({
	            url:"{{ URL::to('pengambilan') }}/"+id,
	            type:"PUT",
	            data:{issue_id:issue_id, handbook_id:handbook_id, date:date, employee_id:employee_id},
	            success:function(){
	            	window.location = "{{ URL::to('pengambilan') }}";
	            }
	        });
    	}
    	else
    	{
    		window.alert('Lengkap Inputan Anda!');
    	}
    }

    function destory(id)
    {
        if(confirm("Yakin akan membatalkan Pengambilan Handbook?!"))
        {
            $.ajax({
                url:"{{ URL::to('pengambilan') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('pengambilan') }}";
                }
            });
        }
    }
</script>
@stop