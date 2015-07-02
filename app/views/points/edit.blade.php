@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Koreksi Nilai Kegiatan <small>{{ $activity->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Akademik</a></li>
        <li><a href="{{ URL::to('nilai') }}/kegiatan/{{ $activity->id }}"><i class="active"></i> Nilai Kegiatan</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header"><h2 class="box-title">Form Nilai Kegiatan</h2></div>

                <div class="box-body">
                    @if(Session::has('message'))
                        <div class="alert alert-info alert-dismissable">
                            <i class="fa fa-warning"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form class="form form-horizontal">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">Nama Kegiatan</label>
                            <div class="col-lg-4">
                                <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                                <input type="text" class="form-control" value="{{ $activity->name }}" disabled>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="agenda">Tanggal Kegiatan</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" value="{{ date('d-m-Y', strtotime($activity->agenda)) }}" disabled>
                            </div>
                        </div>
                    </form>

                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-condensed" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th width="15%">Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($activity->points as $point)
                            <tr>
                                <td>
                                    <div class="pull-left image mytooltip">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $point->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $point->issue_id }}" data-toggle="tooltip" data-points="right" title="Klik untuk Lihat Profil">
                                            {{ $point->issue->issue }} /
                                            {{ $point->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td><input type="text" id="point-{{ $point->id }}" class="form-control" value="{{ $point->point }}"></td>
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
    });

    function update(point_id)
    {
        var activity_id = $('[name=activity_id]').val();
        var point = $('#point-'+point_id).val();

        $.ajax({
            url:"{{ URL::to('nilai') }}/"+point_id,
            type:"PUT",
            data:{point:point},
            success:function(){
                window.location = "{{ URL::to('nilai') }}/"+activity_id+"/edit";
            },
            error:function(){
                window.alert("Terjadi Kesalahan: Gagal mengupdate Nilai Kegiatan");
            }
        });
    }   

    function destroy(point_id)
    {
        var activity_id = $('[name=activity_id]').val();

        if(confirm("Yakin akan membatalkan Nilai ini?!"))
        {
            $.ajax({
                url:"{{ URL::to('nilai') }}/"+point_id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('nilai') }}/"+activity_id+"/edit";
                },
                error:function(){
                    window.alert("Terjadi Kesalahan: Gagal menghapus Nilai Kegiatan");
                }
            });
        }
    }
</script>
@stop