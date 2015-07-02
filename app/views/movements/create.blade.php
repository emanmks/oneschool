@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>
        Pindah Kelas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kesiswaan</a></li>
        <li><a href="{{ URL::to('perpindahan') }}"><i class="active"></i> Pindah Kelas</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">Form Pindah Kelas</h2>
                </div>
                <div class="box-body table-responsive">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="bases">Pilih Kelas Asal Siswa</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="bases" onclick="loadStudents()">
                                    <option value="0">--Pilih Kelas Asal</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }} / {{ $course->generation->name }} / {{ $course->course_days }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="students">Pilih Siswa</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="students" onclick="enableDestinations()" disabled>
                                    <option value="0">--Pilih Siswa</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="destinations">Pilih Kelas Tujuan</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="destinations" disabled>
                                    <option value="0">--Pilih Kelas Tujuan</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }} / {{ $course->generation->name }} / {{ $course->course_days }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="employees">Diproses Oleh</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="employees">
                                    <option value="0">--Pilih Pegawai</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="date">Tanggal Pindah</label>
                            <div class="col-lg-2">
                                <input type="text" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="costs">Biaya yang dibebankan</label>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input type="text" class="form-control currency" name="costs" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="upgrade">Biaya Upgrade Kelas</label>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input type="text" class="form-control currency" name="upgrade" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="comments">Keterangan</label>
                            <div class="col-lg-9">
                                <textarea class="textarea form-control" name="comments"></textarea>
                            </div>
                        </div>
                    </form>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="submit"></label>
                            <div class="col-lg-3">
                                <button class="btn btn-success" onclick="create()"><i class="fa fa-floppy-o"></i> Proses Perpindahan!</button>
                            </div>
                        </div>
                        <br/><br/>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Page-Level Plugin Scripts -->
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/currency.js') }}
{{ HTML::script('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('input[name=date]').datepicker({format:'yyyy-mm-dd',autoclose:true});
        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });
        $('.textarea').wysihtml5();
    });

    function loadStudents()
    {
        var course_id = $('[name=bases]').val();

        $.ajax({
            url:"{{ URL::to('loadstudents') }}/"+course_id,
            type:"GET",
            dataType:"json",
            success:function(students){
                $('[name=students]').html('');

                $('[name=students]').append("<option value='0'>Pilih Siswa</option>");

                for (var i = students.length - 1; i >= 0; i--) {
                    $('[name=students]').append("<option value='"+students[i].issue.id+"'>"+students[i].issue.issue+" / "+students[i].issue.student.name+"</option>");
                };

                $('[name=students]').removeAttr('disabled');
            }
        });
    }

    function enableDestinations()
    {
        $('[name=destinations]').removeAttr('disabled');
    }

    function create()
    {
        var base_id = $('[name=bases]').val();
        var issue_id = $('[name=students]').val();
        var destination_id = $('[name=destinations]').val();
        var employee_id = $('[name=employees]').val();
        var date = $('[name=date]').val();
        var costs = $('[name=costs]').val();
        var upgrade = $('[name=upgrade]').val();
        var comments = $('[name=comments]').val();

        if(base_id != '0' && issue_id != '0' && destination_id != '0' && employee_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('perpindahan') }}",
                type:"POST",
                data:{
                    base_id:base_id,
                    issue_id:issue_id,
                    destination_id:destination_id,
                    employee_id:employee_id,
                    date:date,
                    movement_costs:costs,
                    upgrade_costs:upgrade,
                    comments:comments},
                success:function(movement){
                    window.location = "{{ URL::to('perpindahan') }}/"+movement.id;
                }
            });
        }   
        else
        {
            window.alert('Mohon lengkapi data anda!');
        }
    }
</script>
@stop