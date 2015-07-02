@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>Nilai Siswa</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Akademik</a></li>
        <li><a href="{{ URL::to('nilai') }}"><i class="active"></i> Nilai Siswa</a></li>
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
                    <button class="btn btn-primary" onclick="showFormSelectActivity()"><i class="fa fa-plus"></i> Input Nilai Kegiatan</button>
                    <div class="clear-fix"><br/></div>
                    <table class="table table-bordered table-hover table-condensed" id="data-table">
                        <thead>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Detail</th>
                                <th>Koreksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($points as $point)
                                <tr>
                                    <td>{{ $point->pointable->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($point->pointable->agenda)) }}</td>
                                    <td>
                                        <a href="{{ URL::to('nilai') }}/{{ $point->pointable_id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Lihat Detail"><i class="fa fa-edit"></i> Detail</a>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('nilai') }}/{{ $point->pointable_id }}/edit" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Koreksi"><i class="fa fa-edit"></i> Koreksi</a>
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

<!-- Form Select Course [modal]
===================================== -->
<div id="formSelectActivity" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Input Nilai Kegiatan</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="activities">Pilih Kegiatan</label>
                        <div class="col-lg-8">
                           <select class="form-control" name="activities">
                               <option value="0">--Pilih Kegiatan</option>
                               @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                               @endforeach
                           </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onClick="showFormCreateActivityPoint()" data-dismiss="modal" aria-hidden="true">Pilih Kegiatan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Form Select Course [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

    });

    function showFormSelectActivity()
    {
        $('#formSelectActivity').modal('show');
    }

    function showFormCreateActivityPoint()
    {
        var activity_id = $('[name=activities]').val();

        window.location = "{{ URL::to('nilai') }}/create/"+activity_id;
    }
</script>
@stop