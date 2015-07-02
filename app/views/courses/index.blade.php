@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Kelas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('kelas') }}"><i class="active"></i> Kelas</a></li>
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
                    <div class="mytooltip">
                        <a href="{{ URL::to('kelas/create') }}" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Buka Kelas Baru"><i class="fa fa-plus"></i> Kelas Baru</a>
                    </div>

                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Tingkatan</th>
                                <th>Nama Kelas</th>
                                <th>Biaya</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th>Hari Belajar</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td><span class="badge bg-blue">{{ $course->generation->name }}</span></td>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('kelas') }}/{{ $course->id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Detail">{{ $course->name }}</a>
                                    </div>
                                </td>
                                <td><span class="badge bg-red">Rp{{ number_format($course->costs,2,',','.') }}</span></td>
                                <td><span class="badge bg-yellow">{{ $course->capacity }}</span></td>
                                <td>
                                	@if($course->availability  == 0)
                                		<span class="badge bg-red">Closed</span>
                                	@else
                                		<span class="badge bg-green">Open</span>
                                	@endif
                                </td>
                                <td><strong>{{ $course->course_days }}</strong></td>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('kelas') }}/{{ $course->id }}/edit" role="button" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $course->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
                                        </button>
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

<!-- End of Update place [modal] -->

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