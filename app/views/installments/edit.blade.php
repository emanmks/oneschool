@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/iCheck/all.css') }}
{{ HTML::style('assets/css/datepicker/datepicker.css') }}

<section class="content-header">
    <h1>
        Koreksi Angsuran
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('angsuran') }}"><i class="active"></i> Angsuran</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <button class="btn btn-primary" onclick="update({{ $installment->id }})"><i class="fa fa-floppy-o"></i> Simpan</button>
                    </div>
                </div>

                <div class="box-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="classification">Jadwal Angsuran</label>
                            <div class="col-lg-3">
                            	<input type="text" class="form-control" name="schedule" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="total">Jumlah Angsuran</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control currency" name="total" value="{{ number_format($installment->total,2,',','.') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="balance">Sisa</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control currency" name="balance" value="{{ number_format($installment->balance,2,',','.') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="availability">Status</label>
                            <div class="col-lg-9">
                                @if($installment->availability == "1" && $installment->balance == 0)
                                    <input type="checkbox" name="availability" id="availability" class="flat-red" value="1" checked> <span id="paid_status">Terbayar</span>
                                @elseif($installment->availability == "1" && $installment->balance > 0)
                                    <input type="checkbox" name="availability" id="availability" class="flat-red" value="1" checked> <span id="paid_status">Terbayar Sebagian</span>
                             	@else
                             		<input type="checkbox" name="availability" id="availability" class="flat-red" value="1"> <span id="paid_status">Belum Dibayar</span
                                @endif
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
{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}
{{ HTML::script('assets/js/currency.js') }}

<script type="text/javascript">
    $(document).ready(function() {
    	$('select[name=classification]').val("{{ $installment->classification_id }}");
        $('select[name=program]').val("{{ $installment->program_id }}");
    	$('select[name=generation]').val("{{ $installment->generation_id }}");
    	$('select[name=major]').val("{{ $installment->major_id }}");

        $('.textarea').wysihtml5();

        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });

        $('#availability').on("ifClicked", function(){
            if(!this.checked){
                $('#availability_status').html('Terbuka / Menerima Siswa');
            }else{
                $('#availability_status').html('Tertutup / Tidak Menerima Siswa');
            }
        });
    });

    function update()
    {
        var id = $('input[name=course_id]').val();
        var classification = $('select[name=classification]').val();
        var program = $('select[name=program]').val();
        var generation = $('select[name=generation]').val();
        var major = $('select[name=major]').val();
        var name = $('input[name=name]').val();
        var days = [];
        var costs = $('input[name=costs]').val();
        var capacity = $('input[name=capacity]').val();
        var students = $('[name=students]').val();
        var status = '0';
        var description = $('textarea[name=description]').val(); 

        $('input:checkbox[name=days]:checked').each(function(){
            days.push($(this).val());
        });

        $('input:checkbox[name=availability]:checked').each(function(){
            status = $(this).val();
        });

        if(classification != '0' && program != '0' && major != '0' && name != '' && days.length > 0)
        {
            $.ajax({
                url:"{{ URL::to('kelas') }}/"+id,
                type:'PUT',
                data:{
                        classification : classification, 
                        program : program,
                        generation : generation, 
                        major : major, 
                        name : name,
                        days : days,
                        costs : costs,
                        capacity : capacity,
                        students : students, 
                        status : status, 
                        description : description},
                success:function(){
                    window.location = "{{ URL::to('kelas') }}";
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