@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>Income Payroll</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kepegawaian</a></li>
        <li><a href="{{ URL::to('income') }}"><i class="active"></i> Income Payroll</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <button class="btn btn-primary" onclick="update({{ $income->id }})"><i class="fa fa-floppy-o"></i> Update</button>
                    </div>
                </div>

                <div class="box-body">
                    <form class="form-horizontal" role="form">
                    	<div class="form-group">
                            <label class="col-lg-3 control-label" for="employees">Diberikan Kepada</label>
                            <div class="col-lg-5">
                                <input type="text" name="employees" class="form-control" data-provide="typeahead" value="ID: {{ $income->employee->employee_id }} Kode: {{ $income->employee->code }} Name: {{ $income->employee->name }}">
                                <input type="hidden" name="employee" value="{{ $income->employee_id }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="classifications">Jenis Income</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="classifications">
                                    <option value="0">--Pilih</option>
                                    @foreach($classifications as $classification)
                                        <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                    @endforeach
                                </select>
                                <script type="text/javascript">
                                	$('[name=classifications]').val("{{ $income->classification_id }}");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="nominal">Nominal</label>
                            <div class="col-lg-3">
                                <input name="nominal" type="text" class="form-control currency" value="{{ number_format($income->nominal,2,',',',') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="release_date">Tanggal Terbit</label>
                            <div class="col-lg-2">
                                <input name="release_date" type="text" class="form-control" value="{{ date('Y-m-d', strtotime($income->release_date)) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="comments">Tambahan Informasi</label>
                            <div class="col-lg-8">
                                <textarea name="comments" class="textarea form-control" placeholder="Tambahkan Informasi dan Penjelasan disini"style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $income->comments }}</textarea>
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
{{ HTML::script('assets/js/plugins/typeahead/bootstrap-typeahead.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('[name=release_date]').datepicker({format:'yyyy-mm-dd',autoclose:true});

        $('.textarea').wysihtml5();

        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });

        $('input[name=employees]').typeahead({
            source : function(query, process){
                return $.get("{{ URL::to('suggestemployee') }}/"+query, function(response){
                    response = $.parseJSON(response);
                    var sourceArr = []; 
                    for(var i = 0; i < response.length; i++)
                    {
                        sourceArr.push(response[i].id +"#"+ response[i].employee_id +"#"+ response[i].code +"#"+ response[i].name);
                    }
                    return process(sourceArr);
                })
            },
            highlighter : function(item){
                var employee = item.split('#');
                var item = ''
                        + "<div class='typeahead_wrapper'>"
                        + "<span class='typeahead_photo fa fa-2x fa-user'></span>"
                        + "<div class='typeahead_labels'>"
                        + "<div class='typeahead_primary'>" + employee[3] + "</div>"
                        + "<div class='typeahead_secondary'>ID: "+ employee[1] +" - Kode: "+ employee[2] +"</div>"
                        + "</div>"
                        + "</div>";
                return item;
            },
            updater : function(item){
                var employee = item.split('#');
                $('input[name=employee]').val(employee[0]);
                return "ID: "+employee[1]+" Kode: "+employee[2]+" Nama: "+employee[3];
            }
        });
    });

    function update(id)
    {
        var employee_id = $('[name=employee]').val();
        var classification_id = $('[name=classifications]').val();
        var nominal = $('[name=nominal]').val();
        var release_date = $('[name=release_date]').val();
        var comments = $('[name=comments]').val();
        
        if(classification_id != '0' && employee_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('income') }}/"+id,
                type:'PUT',
                data:{
                	employee_id : employee_id,
                	classification_id : classification_id,
                    nominal : nominal, 
                	release_date : release_date, 
                	comments : comments},
                success:function(){
                    window.location = "{{ URL::to('income') }}/"+id;
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