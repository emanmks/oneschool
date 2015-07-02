@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pertemuan
        <small>{{ $teach->course->name }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Pegawai</a></li>
        <li><a href="{{ URL::to('mengajar') }}"><i class="active"></i> Pertemuan / Presensi Tentor</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">Detail Pertemuan {{ $teach->course->name }}</h2>
                </div>

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
                        <button class="btn btn-success" onclick="update()"><i class="fa fa-floppy-o"></i> Update Detail Pertemuan</button>
                    </div>
                    <div class="clear-fix"><br/><br/></div>

                    <form class="form form-horizontal">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="course">Kelas</label>
                            <div class="col-lg-4">
                            	<input type="hidden" name="teach_id" value="{{ $teach->id }}">
                                <input type="text" class="form-control" value="{{ $teach->course->name }} /  Program : {{ $teach->course->program->name }}  / {{ $teach->course->course_days }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="employees">Tentor</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="employees">
                                   <option value="0">--Pilih Tentor</option>
                                   @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                   @endforeach
                                </select>
                                <script type="text/javascript">
                                    $('[name=employees]').val("{{ $teach->employee_id }}")
                                </script>
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
                                <script type="text/javascript">
                                    $('[name=subjects]').val("{{ $teach->subject_id }}")
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="hours">Jam Belajar</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="hours">
                                   <option value="0">--Pilih Jam Belajar</option>
                                   @foreach($hours as $hour)
                                        <option value="{{ $hour->id }}">{{ $hour->start }} - {{ $hour->end }}</option>
                                   @endforeach
                                </select>
                                <script type="text/javascript">
                                    $('[name=hours]').val("{{ $teach->hour_id }}")
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="course_date">Tanggal Mengajar</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="course_date" value="{{ date('Y-m-d', strtotime($teach->course_date)) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="title">Materi</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="title" value="{{ $teach->title }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="comments">Keterangan</label>
                            <div class="col-lg-9">
                                 <textarea name="comments" class="textarea form-control" placeholder="Tambahkan Informasi dan Penjelasan disini"style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $teach->comments }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}

<script type="text/javascript">
    $(document).ready(function() {
    	$('[name=course_date]').datepicker({format:"yyyy-mm-dd"});
    	$('.textarea').wysihtml5();
    });

    function update()
    {
        var teach_id = $('[name=teach_id]').val();
        var subject_id = $('[name=subjects]').val();
        var employee_id = $('[name=employees]').val();
        var hour_id = $('[name=hours]').val();
        var title = $('[name=title]').val();
        var course_date = $('[name=course_date]').val();
        var comments = $('[name=comments]').val();

        if(subject_id != '0' && employee_id != '0' && hour_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('mengajar') }}/"+teach_id,
                type:"PUT",
                data:{
                    subject_id:subject_id,
                    employee_id:employee_id,
                    hour_id:hour_id,
                    title:title,
                    course_date:course_date,
                    comments:comments
                },
                success:function(){
                    window.location = "{{ URL::to('mengajar') }}/"+teach_id+"/edit";
                },
                error:function(){
                	window.alert("Terjadi Kesalahan: Gagal mengupdate detail Pertemuan");
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