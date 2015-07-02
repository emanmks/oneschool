@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/iCheck/all.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Input Nilai Penguasaan <small>{{ $course->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Akademik</a></li>
        <li><a href="{{ URL::to('penguasaan') }}"><i class="active"></i> Penguasaan</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header"><h2 class="box-title">Form Nilai Penguasaan Bidang Studi</h2></div>

                <div class="box-body">
                	<div id="theAlert" class="alert alert-danger alert-dismissable">
		                <i class="fa fa-warning"></i>
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

		                Terjadi Kesalahan, Gagal Menyimpan Nilai Penguasaan Bidang Studi
		            </div>
                    <form class="form form-horizontal">
                    	<div class="form-group">
	                        <label class="col-lg-3 control-label" for="course">Kelas</label>
	                        <div class="col-lg-4">
	                        	<input type="hidden" name="course_id" value="{{ $course->id }}">
	                        	<input type="text" class="form-control" value="{{ $course->name }} /  Program : {{ $course->program->name }}  / {{ $course->course_days }}" disabled>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-lg-3 control-label" for="subjects">Bidang Studi</label>
	                        <div class="col-lg-4">
	                           	<select class="form-control" name="subjects">
	                               <option value="0">--Pilih Bidang Studi</option>
	                               @foreach($subjects as $subject)
	                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
	                               @endforeach
	                            </select>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-lg-3 control-label" for="report_date">Tanggal Laporan</label>
	                        <div class="col-lg-2">
	                           	<input type="text" class="form-control" name="report_date" value="{{ date('Y-m-d') }}">
	                        </div>
	                    </div>
                    </form>

                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-condensed" id="data-table">
                        <thead>
                            <tr>
                            	<th>Pilih</th>
                                <th>Siswa</th>
                                <th width="15%">Nilai</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($course->placements as $placement)
                            <tr>
                                <td><input type="checkbox" class="form-control flat-red" name="students" value="{{ $placement->issue_id }}"></td>
                                <td>
                                    <div class="pull-left image mytooltip">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $placement->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $placement->issue_id }}" data-toggle="tooltip" data-placement="right" title="Klik untuk Lihat Profil">
                                            {{ $placement->issue->issue }} /
                                            {{ $placement->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <select class="form-control" id="mastery-{{ $placement->issue_id }}">
                                        <option value="A">A - SANGAT BAGUS</option>
                                        <option value="B">B - BAGUS</option>
                                        <option value="C">C - SEDANG</option>
                                        <option value="D">D - KURANG</option>
                                        <option value="E">E - PERHATIAN KHUSUS</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary" onclick="createMasteries()"><i class="fa fa-floppy-o"></i> Rekam Penilaian</button>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();

        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('[name=report_date]').datepicker({format:"yyyy-mm-dd"});

        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $('#theAlert').hide();
    });

    function createMasteries()
    {
    	var issues = [];
    	var masteries = [];
    	var subject_id = $('[name=subjects]').val();
    	var report_date = $('[name=report_date]').val();

    	$('input:checkbox[name="students"]:checked').each(function(){
            issues.push(parseFloat($(this).val()));
            masteries.push($("#mastery-"+$(this).val()).val());
        });

        if(issues.length > 0 && masteries.length > 0 && subject_id != '0')
        {
        	$.ajax({
        		url:"{{ URL::to('penguasaan') }}",
        		type:"POST",
        		data:{
        			issues:issues,
        			masteries:masteries,
        			subject_id:subject_id,
        			report_date:report_date
        		},
        		success:function(){
        			window.location = "{{ URL::to('penguasaan') }}";
        		},
        		error:function(){
        			$('#theAlert').show();
        		}
        	});
        }
        else
        {
        	window.alert("Mohon Lengkapi Data Anda!!!");
        }
    }
</script>
@stop