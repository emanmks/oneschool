@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>
        Aset Baru
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('aset') }}"><i class="active"></i> Aset</a></li>
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

    function create()
    {
        var code = $('input[name=code]').val();
        var name = $('input[name=name]').val();
        var price = $('input[name=price]').val();
        var feasible = $('input[name=feasible]').val();
        var infeasible = $('input[name=infeasible]').val();

        if(name != '')
        {
            $.ajax({
                url:"{{ URL::to('promo') }}",
                type:'POST',
                data:{
                	code:code,
                	name : name,
                	price:price,
                	feasible:feasible,
                	infeasible:infeasible
                	}
                success:function(){
                    window.location = "{{ URL::to('aset') }}";
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