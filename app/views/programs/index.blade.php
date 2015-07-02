@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Program Bimbingan
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('program') }}"><i class="active"></i> Program Bimbingan</a></li>
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
                    <a href="{{ URL::to('program/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Program Baru</a>
                    <div class="clear-fix"><br/></div>
                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Program Bimbingan</th>
                                <th>Periode Program</th>
                                <th>Statistik</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($programs as $program)
                            <tr>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('program') }}/{{ $program->id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk lihat Statistik">{{ $program->name }}</a>
                                    </div>
                                </td>
                                <td><span class="badge bg-yellow">{{ date('d-m-Y', strtotime($program->start_date)) }}</span> S/D <span class="badge bg-red">{{ date('d-m-Y', strtotime($program->end_date)) }}</span></td>
                                <td><a href="{{ URL::to('program') }}/{{ $program->id }}" class="btn btn-xs btn-primary">Lihat Statistik</a></td>
                                <td>
                                    <input type="hidden" id="name-{{ $program->id }}" value="{{ $program->name }}">
                                    <input type="hidden" id="generation-{{ $program->id }}" value="{{ $program->generation_id }}">
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('program') }}/{{ $program->id }}/edit" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $program->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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