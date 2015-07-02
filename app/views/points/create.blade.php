@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/iCheck/all.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Input Nilai Kegiatan <small>{{ $activity->name }}</small></h1>
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
                    <div id="theAlert" class="alert alert-danger alert-dismissable">
                        <i class="fa fa-warning"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        Terjadi Kesalahan, Gagal Menyimpan nilai Kegiatan
                    </div>
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

                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>Pilih</th>
                                <th>Siswa</th>
                                <th width="15%">Nilai</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($activity->participations as $participation)
                            <tr>
                                <td><input type="checkbox" class="form-control flat-red" name="students" value="{{ $participation->issue_id }}"></td>
                                <td>
                                    <div class="pull-left image mytooltip">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $participation->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $participation->issue_id }}" data-toggle="tooltip" data-participations="right" title="Klik untuk Lihat Profil">
                                            {{ $participation->issue->issue }} /
                                            {{ $participation->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" id="point-{{ $participation->issue_id }}" class="form-control" value="0.00">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary" onclick="createPoints()"><i class="fa fa-floppy-o"></i> Setor Nilai Kegiatan</button>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}

<script type="text/javascript">
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

    function createPoints()
    {
        var issues = [];
        var points = [];
        var activity_id = $('[name=activity_id]').val();

        $('input:checkbox[name="students"]:checked').each(function(){
            issues.push(parseFloat($(this).val()));
            points.push(parseFloat($("#point-"+$(this).val()).val()));
        });

        if(activity_id != '0' && issues.length > 0 && points.length > 0)
        {
            $.ajax({
                url:"{{ URL::to('nilai') }}",
                type:"POST",
                data:{
                    activity_id:activity_id,
                    issues:issues,
                    points:points
                },
                success:function(){
                    window.location = "{{ URL::to('nilai') }}";
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