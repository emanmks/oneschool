@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>
        Udpdate Promo
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('promo') }}"><i class="active"></i> Promo</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <button class="btn btn-primary" onclick="update()"><i class="fa fa-floppy-o"></i> Simpan</button>
                    </div>
                </div>

                <div class="box-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">Nama Promo</label>
                            <div class="col-lg-5">
                            	<input type="hidden" name="promo_id" value="{{ $promotion->id }}">
                                <input name="name" type="text" class="form-control" value="{{ $promotion->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="discount">Diskon (%)</label>
                            <div class="col-lg-2">
                                <input name="discount" type="text" class="form-control" value="{{ $promotion->discount }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="nominal">Nominal</label>
                            <div class="col-lg-3">
                                <input name="nominal" type="text" class="form-control" value="{{ $promotion->nominal }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="last_valid">Valid Hingga</label>
                            <div class="col-lg-2">
                                <input name="last_valid" type="text" class="form-control" data-provider="datepicker" value="{{ date('Y-m-d', strtotime($promotion->last_valid)) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="description">Informasi/Penjelasan</label>
                            <div class="col-lg-8">
                                <textarea name="description" class="textarea form-control" placeholder="Tambahkan Informasi dan Penjelasan disini"style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                	{{ $promotion->description }}
                                </textarea>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('input[name=last_valid]').datepicker({format:'yyyy-mm-dd',autoclose:true});
        $('.textarea').wysihtml5();
    });

    function update()
    {
        var id = $('input[name=promo_id]').val();
        var name = $('input[name=name]').val();
        var discount = $('input[name=discount]').val();
        var nominal = $('input[name=nominal]').val();
        var last_valid = $('input[name=last_valid]').val();
        var description = $('textarea[name=description]').val();

        if(name != '')
        {
            $.ajax({
                url:"{{ URL::to('promo') }}/"+id,
                type:'PUT',
                data:{
                	name : name,
                    discount : discount, 
                	nominal : nominal, 
                	last_valid : last_valid, 
                	description : description},
                success:function(){
                    window.location = "{{ URL::to('promo') }}";
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