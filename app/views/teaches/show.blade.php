@extends('templates/base')

@section('content')

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
                    <form class="form form-horizontal">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="course">Kelas</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" value="{{ $teach->course->name }} /  Program : {{ $teach->course->program->name }}  / {{ $teach->course->course_days }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="employees">Tentor</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" value="{{ $teach->employee->name }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="subjects">Bidang Studi</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" value="{{ $teach->subject->name }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="hours">Jam Belajar</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" value="{{ $teach->hour->start }} - {{ $teach->hour->end }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="course_date">Tanggal Mengajar</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" value="{{ date('Y-m-d', strtotime($teach->course_date)) }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="title">Materi</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="title" value="{{ $teach->title }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="comments">Keterangan</label>
                            <div class="col-lg-9">
                                {{ $teach->comments }}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>
@stop