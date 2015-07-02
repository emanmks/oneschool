@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>
        Update Info Penon-aktifan Siswa
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kesiswaan</a></li>
        <li><a href="{{ URL::to('keluar') }}"><i class="active"></i> Non Aktif</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <button class="btn btn-success" onclick="create()"><i class="fa fa-floppy-o"></i> Simpan</button>
                    </div>
                </div>

                <div class="box-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="date">Tanggal Resmi</label>
                            <div class="col-lg-2">
                            	<input type="hidden" name="id" value="{{ $resign->id }}">
                                <input name="date" type="text" class="form-control" data-provide="datepicker" value="{{ date('Y-m-d', strtotime($resign->resign_date)) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="classifications">Alasan Keluar</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="classifications">
                                    <option value="0">--Pilih Alasan Keluar</option>
                                    @foreach($classifications as $classification)
                                        <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                    @endforeach
                                </select>
                                <script type="text/javascript">
                                	$('select[name=classifications]').val("{{ $resign->classification_id }}");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="fine">Biaya / Denda (Jika ada)</label>
                            <div class="col-lg-2">
                                <input name="fine" type="text" class="form-control currency" value="{{ number_format($resign->fines,2,',','.') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="returnment">Pengembalian Biaya (Jika ada)</label>
                            <div class="col-lg-2">
                                <input name="returnment" type="text" class="form-control currency" value="{{ number_format($resign->returnment,2,',','.') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="comments">Informasi/Penjelasan Tambahan</label>
                            <div class="col-lg-8">
                                <textarea name="comments" class="textarea form-control" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                	{{ $resign->comments }}
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
{{ HTML::script('assets/js/currency.js') }}

<script type="text/javascript">
    $(document).ready(function() {
    	$('input[name=date]').datepicker({format:'yyyy-mm-dd',autoclose:true});
        $('.textarea').wysihtml5();

        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });
    });

    function update()
    {
        var id = $('[name=id]').val();
        var date = $('input[name=date]').val();
        var classification = $('select[name=classifications]').val();
        var fine = $('input[name=fine]').val();
        var returnment = $('input[name=returnment]').val();
        var comments = $('textarea[name=comments]').val();

        if(id != '0' && classification != '0')
        {
            $.ajax({
                url:"{{ URL::to('keluar') }}/"+id,
                type:'PUT',
                data:{date:date,
                	classification_id:classification,
                	fine:fine,
                	returnment:returnment, 
                	comments:comments},
                success:function(){
                    window.location = "{{ URL::to('keluar') }}";
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