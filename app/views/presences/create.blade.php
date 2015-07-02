@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/iCheck/all.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Kehadiran
        <small>{{ $course->name }}</small>
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
                    <h2 class="box-title">Daftar Kehadiran {{ $course->name }}</h2>
                </div>

                <div class="box-body">
                    <form class="form form-horizontal">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="course">Kelas</label>
                            <div class="col-lg-4">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="text" class="form-control" value="{{ $course->name }} /  Program : {{ $course->program->name }}  / {{ $course->course_days }}" disabled>
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
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="course_date">Tanggal Mengajar</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="course_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="title">Materi</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="comments">Keterangan</label>
                            <div class="col-lg-9">
                                <textarea name="comments" class="textarea form-control" placeholder="Tambahkan Informasi dan Penjelasan disini"style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
                    </form>

                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th width="40%">Siswa</th>
                                <th>Kehadiran</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($course->placements as $placement)
                            <tr>
                                <td><input type="checkbox" class="form-control flat-red" name="students" value="{{ $placement->issue_id }}"></td>
                                <td>
                                    <div class="pull-left image mytooltip">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $placement->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $placement->issue_id }}" data-toggle="tooltip" data-placement="right" title="Klik untuk Lihat Profil">
                                            {{ $placement->issue->issue }} /
                                            {{ $placement->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <input type="checkbox" class="form-control flat-red" id="presence-{{ $placement->issue_id }}" value="{{ $placement->issue_id }}">
                                </td>
                                <td>
                                    <select class="form-control" id="desc-{{ $placement->issue_id }}">
                                        <option value="0">Keterangan</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Alpa">Alpa</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button class="btn btn-primary" onclick="createPresences()"><i class="fa fa-floppy-o"></i> Simpan Presensi</button>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}
{{ HTML::script('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('[name=course_date]').datepicker({format:"yyyy-mm-dd"});

        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $('input[id^=presence-]').on('ifClicked', function(){
            if(!this.checked){
                $('#desc-'+this.value).prop('disabled',true);
            }else{
                $('#desc-'+this.value).prop('disabled',false);
            }
        });

        $('.textarea').wysihtml5();
    });

    function createPresences()
    {
        var issues = [];
        var presences = [];
        var descs = [];
        var course_id = $('[name=course_id]').val();
        var employee_id = $('[name=employees]').val();
        var hour_id = $('[name=hours]').val();
        var title = $('[name=title]').val();
        var course_date = $('[name=course_date]').val();
        var comments = $('[name=comments]').val();

        $('input:checkbox[name="students"]:checked').each(function(){
            issues.push(parseFloat($(this).val()));
            if($('#presence-'+$(this).val()).prop('checked'))
            {
                presences.push(1);
            }
            else
            {
                presences.push(0);
            }
            descs.push($('#desc-'+$(this).val()).val());
        });

        if(course_id != '0' && issues.length > 0 && presences.length > 0 && descs.length > 0 && employee_id != '0' && hour_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('presensi') }}",
                type:"POST",
                data:{
                    course_id:course_id,
                    issues:issues,
                    presences:presences,
                    descs:descs,
                    employee_id:employee_id,
                    hour_id:hour_id,
                    title:title,
                    course_date:course_date,
                    comments:comments
                },
                success:function(){
                    window.location = "{{ URL::to('presensi') }}";
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