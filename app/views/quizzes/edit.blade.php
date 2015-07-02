@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/css/datatables/dataTables.tabletools.css') }}
{{ HTML::style('assets/css/datepicker/datepicker.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Nilai Quiz Kelas <small>{{ $quiz->course->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Akademik</a></li>
        <li><a href="{{ URL::to('quiz') }}/Quiz/{{ $quiz->id }}"><i class="active"></i> Nilai Quiz</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header"><h2 class="box-title">Nilai Quiz</h2></div>

                <div class="box-body">
                   	@if(Session::has('message'))
			            <div class="alert alert-info alert-dismissable">
			                <i class="fa fa-warning"></i>
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

			                {{ Session::get('message') }}
			            </div>
		            @endif

                    <div class="col-lg-3"></div>
                    <div class="col-lg-9">
                        <button class="btn btn-success" onclick="updateQuiz()"><i class="fa fa-floppy-o"></i> Update Detail Quiz</button>
                    </div>
                    <div class="clear-fix"><br/><br/></div>
                    
                    <form class="form form-horizontal">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="course">Kelas</label>
                            <div class="col-lg-4">
                                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                                <input type="text" class="form-control" value="{{ $quiz->course->name }} /  Program : {{ $quiz->course->program->name }}  / {{ $quiz->course->course_days }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="subject">Bidang Studi</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="subjects">
                                   <option value="0">--Pilih Bidang Studi</option>
                                   @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                   @endforeach
                                </select>
                                <script type="text/javascript">
                                    $('[name=subjects]').val("{{ $quiz->subject_id }}")
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="employee">Tentor</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="employees">
                                   <option value="0">--Pilih Tentor</option>
                                   @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                   @endforeach
                                </select>
                                <script type="text/javascript">
                                    $('[name=employees]').val("{{ $quiz->employee_id }}")
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">Materi</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="name" value="{{ $quiz->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="quiz_date">Tanggal Quiz</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="quiz_date" value="{{ date('Y-m-d', strtotime($quiz->quiz_date)) }}">
                            </div>
                        </div>
                    </form>

                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-condensed display" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th width="15%">Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($quiz->points as $point)
                            <tr id="row-{{ $point->id }}">
                                <td>
                                    <div class="pull-left image mytooltip">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $point->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $point->issue_id }}" data-toggle="tooltip" data-placement="right" title="Klik untuk Lihat Profil">
                                            {{ $point->issue->issue }} /
                                            {{ $point->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td><input type="text" class="form-control" id="point-{{ $point->id }}" value="{{ $point->point }}"></td>
                                <td>
                                    <button class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Simpan Perubahan" onclick="update({{ $point->id }})"><i class="fa fa-floppy-o"></i></button>
                                    <button class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o" onclick="destroy({{ $point->id }})"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.tableTools.min.js') }}
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();

        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('[name=quiz_date]').datepicker({format:"yyyy-mm-dd"});

        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $('.alert').hide();
    });

    function updateQuiz()
    {
        var quiz_id = $('[name=quiz_id]').val();
        var subject_id = $('[name=subjects]').val();
        var employee_id = $('[name=employees]').val();
        var name = $('[name=name]').val();
        var quiz_date = $('[name=quiz_date]').val();

        if(subject_id != '0' && employee_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('quiz') }}/"+quiz_id,
                type:"PUT",
                data:{
                    subject_id:subject_id,
                    employee_id:employee_id,
                    name:name,
                    quiz_date:quiz_date
                },
                success:function(){
                    window.location = "{{ URL::to('quiz') }}/"+quiz_id+"/edit";
                },
                error:function(){
                	window.alert("Terjadi Kesalahan: Gagal mengupdate detail Quiz");
                }
            });
        }
        else
        {
            window.alert("Mohon Lengkapi Data Anda!!!");
        }
    }

    function update(point_id)
    {
    	var quiz_id = $('[name=quiz_id]').val();
    	var point = $('#point-'+point_id).val();

    	$.ajax({
            url:"{{ URL::to('nilai') }}/"+point_id,
            type:"PUT",
            data:{point:point},
            success:function(){
                window.location = "{{ URL::to('quiz') }}/"+quiz_id+"/edit";
            },
            error:function(){
            	window.alert("Terjadi Kesalahan: Gagal mengupdate Nilai Quiz");
            }
        });
    }	

    function destroy(point_id)
    {
    	var quiz_id = $('[name=quiz_id]').val();

    	if(confirm("Yakin akan membatalkan Nilai ini?!"))
    	{
    		$.ajax({
	            url:"{{ URL::to('nilai') }}/"+point_id,
	            type:"DELETE",
	            success:function(){
	                window.location = "{{ URL::to('quiz') }}/"+quiz_id+"/edit";
	            },
	            error:function(){
	            	window.alert("Terjadi Kesalahan: Gagal menghapus Nilai Quiz");
	            }
	        });
    	}
    }
</script>
@stop