@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/iCheck/all.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Nilai Quiz Kelas <small>{{ $quiz->course->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Akademik</a></li>
        <li><a href="{{ URL::to('nilai') }}/Quiz/{{ $quiz->id }}"><i class="active"></i> Nilai Quiz</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header"><h2 class="box-title">Nilai Quiz</h2></div>

                <div class="box-body">
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
	                           	<input type="text" class="form-control" name="subject" value="{{ $quiz->subject->name }}" disabled>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-lg-3 control-label" for="employee">Tentor</label>
	                        <div class="col-lg-4">
	                           <input type="text" class="form-control" name="employee" value="{{ $quiz->employee->name }}" disabled>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-lg-3 control-label" for="name">Materi</label>
	                        <div class="col-lg-8">
	                           	<input type="text" class="form-control" name="name" value="{{ $quiz->name }}" disabled>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-lg-3 control-label" for="quiz_date">Tanggal Quiz</label>
	                        <div class="col-lg-2">
	                           	<input type="text" class="form-control" name="quiz_date" value="{{ date('Y-m-d', strtotime($quiz->quiz_date)) }}" disabled>
	                        </div>
	                    </div>
                    </form>

                    <div class="clear-fix"><br/></div>

                    @if(Session::has('message'))
                    <div class="alert alert-danger alert-dismissable">
                       <i class="fa fa-warning"></i>
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                       {{ Session::get('message') }}
                    </div>
                    @endif

                    <table class="table table-striped table-condensed display" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th width="15%">Nilai</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($quiz->points as $point)
                            <tr>
                                <td>
                                    <div class="pull-left image mytooltip">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $point->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $point->issue_id }}" data-toggle="tooltip" data-placement="right" title="Klik untuk Lihat Profil">
                                            {{ $point->issue->issue }} /
                                            {{ $point->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-blue">{{ $point->point }}</span>
                                </td>
                                <td><a href="#" onclick="destroy({{ $point->id }})" data-toggle="tooltip" data-placement="left" title="Hapus"><i class="fa fa-trash-o text-danger"></i></a></td>
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
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}

<script type="text/javascript">
    $.fn.dataTable.TableTools.defaults.aButtons = [ "copy", "csv", "xls" ];
    $(document).ready(function() {
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('[name=quiz_date]').datepicker({format:"yyyy-mm-dd"});

        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $('#theAlert').hide();
    });

    function destroy(id)
    {
        var quiz = $('[name=quiz_id]').val();

        if(confirm("Yakin akan menghapus data ini?!"))
        {
            $.ajax({
                url:"{{ URL::to('nilai') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('quiz') }}/"+quiz;
                }
            });
        }
    }
</script>
@stop