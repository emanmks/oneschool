@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/iCheck/all.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Kehadiran
        <small>{{ $teach->course->name }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Akademik</a></li>
        <li><a href="{{ URL::to('presensi') }}"><i class="active"></i> Presensi Siswa</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">Daftar Kehadiran {{ $teach->course->name }}</h2>
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

                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th width="40%">Siswa</th>
                                <th>Hadir</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($teach->presences as $presence)
                            <tr>
                                <td>
                                    <div class="pull-left image mytooltip">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $presence->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $presence->issue_id }}" data-toggle="tooltip" data-presence="right" title="Klik untuk Lihat Profil">
                                            {{ $presence->issue->issue }} /
                                            {{ $presence->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @if($presence->presence == 1)
                                    	<input type="checkbox" class="form-control flat-red" checked>
                                    @else
                                    	<input type="checkbox" class="form-control flat-red">
                                    @endif
                                </td>
                                <td>
                                    @if($presence->presence == 0)
                                    	{{ $presence->description }}
                                    @endif
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
{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });
    });
</script>
@stop