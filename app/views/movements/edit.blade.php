@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>
        Manajemen Perpindahan
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('perpindahan') }}"><i class="active"></i> Perpindahan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">Form Update Informasi Pindah Kelas</h2>
                </div>
                <div class="box-body table-responsive">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="destinations">Pilih Kelas Tujuan</label>
                            <div class="col-lg-4">
                            	<input type="hidden" name="movement_id" value="{{ $movement->id }}">
                                <select class="form-control" name="destinations">
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
                                <input type="text" name="date" class="form-control" value="{{ $movement->movement_date }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="costs">Biaya yang dibebankan</label>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input type="text" class="form-control currency" name="costs" value="{{ number_format($movement->movement_costs,2,',','.') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="upgrade">Biaya Upgrade Kelas</label>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input type="text" class="form-control currency" name="upgrade" value="{{ number_format($movement->upgrade_costs,2,',','.') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="comments">Keterangan</label>
                            <div class="col-lg-9">
                                <textarea class="textarea form-control" name="comments">{{ $movement->comments }}</textarea>
                            </div>
                        </div>
                    </form>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="submit"></label>
                            <div class="col-lg-3">
                                <button class="btn btn-success" onclick="update()"><i class="fa fa-floppy-o"></i> Update Info Pindah Kelas!</button>
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

        $('[name=destinations]').val("{{ $movement->destination_id }}");
        $('[name=employees]').val("{{ $movement->employee_id }}");
    });

    function update()
    {
        var id = $('[name=movement_id]').val();
        var destination_id = $('[name=destinations]').val();
        var employee_id = $('[name=employees]').val();
        var date = $('[name=date]').val();
        var costs = $('[name=costs]').val();
        var upgrade = $('[name=upgrade]').val();
        var comments = $('[name=comments]').val();

        if(destination_id != '0' && employee_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('perpindahan') }}/"+id,
                type:"PUT",
                data:{
                    destination_id:destination_id,
                    employee_id:employee_id,
                    date:date,
                    movement_costs:costs,
                    upgrade_costs:upgrade,
                    comments:comments},
                success:function(){
                	window.location = "{{ URL::to('perpindahan') }}/"+id;
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