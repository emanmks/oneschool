@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>Pengeluaran</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('pengeluaran') }}"><i class="active"></i> Pengeluaran</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <button class="btn btn-primary" onclick="create()"><i class="fa fa-floppy-o"></i> Simpan</button>
                    </div>
                </div>

                <div class="box-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="classifications">Jenis Pengeluaran</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="classifications">
                                    <option value="0">--Pilih</option>
                                    @foreach($classifications as $classification)
                                        <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="nominal">Nominal</label>
                            <div class="col-lg-3">
                                <input name="nominal" type="text" class="form-control currency" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="spend_date">Tanggal Pengeluaran</label>
                            <div class="col-lg-2">
                                <input name="spend_date" type="text" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="employees">Dikelola Oleh</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="employees">
                                    <option value="0">--Pilih Pegawai</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="comments">Tambahan Informasi</label>
                            <div class="col-lg-8">
                                <textarea name="comments" class="textarea form-control" placeholder="Tambahkan Informasi dan Penjelasan disini"style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Page-Level Plugin Scripts -->
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}
{{ HTML::script('assets/js/currency.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('input[name=spend_date]').datepicker({format:'yyyy-mm-dd',autoclose:true});

        $('.textarea').wysihtml5();

        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });
    });

    function create()
    {
        var classification_id = $('[name=classifications]').val();
        var total = $('[name=nominal]').val();
        var spend_date = $('[name=spend_date]').val();
        var employee_id = $('[name=employees]').val();
        var comments = $('[name=comments]').val();
        
        if(classification_id != '0' && employee_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('pengeluaran') }}",
                type:'POST',
                data:{
                	classification_id : classification_id,
                    total : total, 
                	spend_date : spend_date, 
                	employee_id : employee_id, 
                	comments : comments},
                success:function(response){
                    window.location = "{{ URL::to('pengeluaran') }}/"+response.id;
                }
            });
        }
        else
        {
            window.alert('Mohon Lengkapi Inputan Anda!');
        }
    }
</script>
@stop