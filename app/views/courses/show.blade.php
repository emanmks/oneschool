@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Kelas
        <small>{{ $course->name }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Detail</a></li>
        <li><a href="{{ URL::tO('kelas') }}"><i class="active"></i> Kelas</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">Kelas {{ $course->name }}</h2>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class=="fa fa-rocket"></i> {{ $course->program->name }}/{{ $course->project->name }}
                                    <span class="pull-right text-muted small"><em>Program</em></span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class=="fa fa-groups"></i> {{ $course->generation->name }}
                                    <span class="pull-right text-muted small"><em>Tingkatan</em></span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class=="fa fa-money"></i> {{ $course->classification->name }}
                                    <span class="pull-right text-muted small"><em>Jenis Kelas</em></span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class=="fa fa-list"></i> {{ $course->major->name }}
                                    <span class="pull-right text-muted small"><em>Jurusan</em></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class=="fa fa-globe"></i> {{ $course->course_days }}
                                    <span class="pull-right text-muted small"><em>Hari Belajar</em></span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class=="fa fa-globe"></i> {{ $course->capacity }}
                                    <span class="pull-right text-muted small"><em>Kapasitas</em></span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class=="fa fa-globe"></i> {{ $course->placements->count() }}
                                    <span class="pull-right text-muted small"><em>Jumlah Siswa</em></span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class=="fa fa-globe"></i> 
                                    @if($course->availability == 1) {{ 'Buka' }} @else {{ 'Tutup' }} @endif
                                    <span class="pull-right text-muted small"><em>Status</em></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-lg-12">
           @if(Session::has('message'))
            <div class="alert alert-info alert-dismissable">
                <i class="fa fa-warning"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('message') }}
            </div>
            @endif

            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">Daftar Siswa di Kelas {{ $course->name }}</h2>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Kontak</th>
                                <th>Ayah</th>
                                <th>Ibu</th>
                                <th>Tgl Lahir</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($course->placements as $placement)
                            <tr>
                                <td>
                                    <div class="pull-left image mytooltip">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $placement->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $placement->issue_id }}" data-toggle="tooltip" data-placement="right" title="Klik untuk Lihat Profil">
                                            {{ $placement->issue->issue }} /
                                            {{ $placement->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $placement->issue->student->contact }}</td>
                                <td>{{ $placement->issue->student->father_name }}, <i class="fa fa-phone"></i> {{ $placement->issue->student->father_contact }}</td>
                                <td>{{ $placement->issue->student->mother_name }}, <i class="fa fa-phone"></i> {{ $placement->issue->student->mother_contact }}</td>
                                <td>{{ date('d-m-Y', strtotime($placement->issue->student->birthdate)) }}</td>
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