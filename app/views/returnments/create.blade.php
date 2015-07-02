@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>Pengembalian</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('pengembalian') }}"><i class="active"></i> Pengembalian</a></li>
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
	                        <label class="col-lg-3 control-label" for="students">Cari Siswa</label>
	                        <div class="col-lg-4">
	                           <input type="text" name="students" class="form-control" data-provide="typeahead" placeholder="Ketikkan Nomor Pokok">
	                           <input type="hidden" name="issue" value="0">
	                        </div>
	                    </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="total">Total Pengembalian</label>
                            <div class="col-lg-3">
                                <input name="total" type="text" class="form-control currency" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="retur_date">Tanggal Penyerahan</label>
                            <div class="col-lg-2">
                                <input name="retur_date" type="text" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="employees">Diserahkan Oleh</label>
                            <div class="col-lg-3">
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
{{ HTML::script('assets/js/plugins/typeahead/bootstrap-typeahead.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('input[name=retur_date]').datepicker({format:'yyyy-mm-dd',autoclose:true});

        $('.textarea').wysihtml5();

        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });

        $('[name=students]').typeahead({
            source : function(query, process){
                return $.get("{{ URL::to('softfilterstudents') }}/"+query, function(response){
                    //response = $.parseJSON(response);
                    var sourceArr = []; 
                    for(var i = 0; i < response.length; i++)
                    {
                        sourceArr.push(
                            response[i].id +"#"+ response[i].issue +"#"+ response[i].student_id +"#"+ response[i].student.name
                            );
                    }
                    return process(sourceArr);
                })
            },
            highlighter : function(item){
                var student = item.split('#');
                var item = ''
                        + "<div class='typeahead_wrapper'>"
                        + "<span class='typeahead_photo fa fa-2x fa-user'></span>"
                        + "<div class='typeahead_labels'>"
                        + "<div class='typeahead_primary'>" + student[1] + "</div>"
                        + "<div class='typeahead_secondary'>" + student[3] + "</div>"
                        + "</div>"
                        + "</div>";
                return item;
            },
            updater : function(item){
                var student = item.split('#');
                $('[name=issue]').val(student[0]);
                return student[1]+ ' / ' +student[3];
            }
        });
    });

    function create()
    {
        var issue_id = $('[name=issue]').val();
        var total = $('[name=total]').val();
        var retur_date = $('[name=retur_date]').val();
        var employee_id = $('[name=employees]').val();
        var comments = $('[name=comments]').val();
        
        if(employee_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('pengembalian') }}",
                type:'POST',
                data:{issue_id:issue_id,
                    total : total, 
                	retur_date : retur_date, 
                	employee_id : employee_id, 
                	comments : comments},
                success:function(response){
                    window.location = "{{ URL::to('pengembalian') }}/"+response.id;
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