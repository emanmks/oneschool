@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>
        Agenda Kegiatan Baru
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('kegiatan') }}"><i class="active"></i> Agenda Kegiatan</a></li>
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
                            <label class="col-lg-3 control-label" for="location">Lokasi Kegiatan</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="location">
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                <script type="text/javascript">
                                	$('select[name=location]').val("{{ Auth::user()->location_id }}");
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">Nama Kegiatan</label>
                            <div class="col-lg-5">
                                <input name="name" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="agenda">Jadwal Pelaksanaan</label>
                            <div class="col-lg-2">
                                <input name="agenda" type="text" class="form-control" data-provider="datepicker" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="coordination">Jenis Agenda</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="coordination">
                                    <option value="Agenda Pusat">Agenda Pusat</option>
                                    <option value="Agenda Cabang">Agenda Cabang</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="description">Informasi/Penjelasan</label>
                            <div class="col-lg-8">
                                <textarea name="description" class="textarea form-control" placeholder="Tambahkan Informasi dan Penjelasan disini"style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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
        $('input[name=agenda]').datepicker({format:'yyyy-mm-dd',autoclose:true});
        $('.textarea').wysihtml5();
    });

    function create()
    {
        var location = $('select[name=location]').val();
        var name = $('input[name=name]').val();
        var agenda = $('input[name=agenda]').val();
        var description = $('textarea[name=description]').val();
        var coordination = $('select[name=coordination]').val();

        if(name != '')
        {
            $.ajax({
                url:"{{ URL::to('kegiatan') }}",
                type:'POST',
                data:{
                	location : location, 
                	name : name, 
                	agenda : agenda, 
                	coordination : coordination, 
                	description : description},
                success:function(){
                    window.location = "{{ URL::to('kegiatan') }}";
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