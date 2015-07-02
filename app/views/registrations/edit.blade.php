@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>
        Pendaftaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Pendaftaran</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">Form Update Informasi Pendaftaran</h2>
                </div>
                <div class="box-body table-responsive">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="classifications">Jenis Pendaftaran</label>
                            <div class="col-lg-4">
                            	<input type="hidden" name="registration_id" value="{{ $registration->id }}" onclick="checkClassification()">
                                <select class="form-control" name="classifications">
                                    <option value="0">--Pilih Jenis Pendaftaran</option>
                                    @foreach($classifications as $classification)
                                        <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="locations">Cabang Asal <small>Jika Pindahan</small></label>
                            <div class="col-lg-4">
                                <select class="form-control" name="locations" disabled>
                                    <option value="0">--Pilih Cabang</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="date">Tanggal Daftar</label>
                            <div class="col-lg-2">
                                <input type="text" name="date" class="form-control" value="{{ $registration->registration_date }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="costs">Biaya Pendaftaran</label>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input type="text" class="form-control currency" name="costs" value="{{ number_format($registration->registration_cost,2,',','.') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="employees">Diterima Oleh</label>
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
                            <label class="col-xs-3 control-label" for="comments">Keterangan</label>
                            <div class="col-lg-9">
                                <textarea class="textarea form-control" name="comments">{{ $registration->registration_comments }}</textarea>
                            </div>
                        </div>
                    </form>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="submit"></label>
                            <div class="col-lg-3">
                                <button class="btn btn-success" onclick="update()"><i class="fa fa-floppy-o"></i> Update Info Pendaftaran!</button>
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

        $('[name=classifications]').val("{{ $registration->classification_id }}");
        $('[name=locations]').val("{{ $registration->base_id }}");
        $('[name=employees]').val("{{ $registration->employee_id }}");
    });

    function checkClassification()
    {
    	var classification = $('[name=classifications]').val();

    	if(classification == '10')
    	{
    		$('[name=locations]').removeAttr('disabled');
    	}
    }

    function update()
    {
        var id = $('[name=registration_id]').val();
        var classification_id = $('[name=classifications]').val();
        var location_id = $('[name=locations]').val();
        var employee_id = $('[name=employees]').val();
        var registration_date = $('[name=date]').val();
        var costs = $('[name=costs]').val();
        var comments = $('[name=comments]').val();

        if(id != '0' && employee_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('pendaftaran') }}/"+id,
                type:"PUT",
                data:{
                    classification_id:classification_id,
                    location_id:location_id,
                    employee_id:employee_id,
                    registration_date:registration_date,
                    registration_cost:costs,
                    registration_comments:comments},
                success:function(){
                	window.location = "{{ URL::to('pendaftaran') }}/"+id;
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