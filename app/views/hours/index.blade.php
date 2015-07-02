@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/css/timepicker/bootstrap-timepicker.css') }}

<section class="content-header">
    <h1>
        Manajemen Jam Belajar
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('jam') }}"><i class="active"></i> Jam Belajar</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
           @if(Session::has('message'))
            <div class="alert alert-info alert-dismissable">
                <i class="fa fa-warning"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('message') }}
            </div>
            @endif

            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> Jam Belajar Baru</button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($hours as $hour)
                            <tr>
                                <td><span class="badge bg-yellow">{{ $hour->start }}</span></td>
                                <td><span class="badge bg-red">{{ $hour->end }}</span></td>
                                <td>
                                    <input type="hidden" id="hh_start-{{ $hour->id }}" value="{{ substr($hour->start,0,2) }}">
                                    <input type="hidden" id="mm_start-{{ $hour->id }}" value="{{ substr($hour->start,3,2) }}">
                                    <input type="hidden" id="hh_end-{{ $hour->id }}" value="{{ substr($hour->end,0,2) }}">
                                    <input type="hidden" id="mm_end-{{ $hour->id }}" value="{{ substr($hour->end,3,2) }}">
                                    <div class="mytooltip">
                                        <button type="button" class="btn btn-primary btn-circle" onclick="showFormUpdate({{ $hour->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $hour->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Add place [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Jam Belajar Baru</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="start">Jam Mulai</label>
                        <div class="col-lg-4">
                            <div class="form-inline">
                            	<select class="form-control" name="hh_start">
	                            	@for($i=0; $i<24; $i++)
	                            		<option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}">{{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
	                            	@endfor
	                            </select>
	                            <select class="form-control" name="mm_start">
	                            	@for($i=0; $i<60; $i++)
	                            		<option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}">{{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
	                            	@endfor
	                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="end">Jam Selesai</label>
                        <div class="col-lg-4">
                            <div class="form-inline">
                            	<select class="form-control" name="hh_end">
	                            	@for($i=0; $i<24; $i++)
	                            		<option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}">{{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
	                            	@endfor
	                            </select>
	                            <select class="form-control" name="mm_end">
	                            	@for($i=0; $i<60; $i++)
	                            		<option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}">{{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
	                            	@endfor
	                            </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="create()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Add place [modal] -->

<!-- Form Update place [modal]
===================================== -->
<div id="formUpdate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Update Project</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_start">Jam Mulai</label>
                        <div class="col-lg-4">
                            <div class="form-inline">
                            	<select class="form-control" name="hh_updated_start">
	                            	@for($i=0; $i<24; $i++)
	                            		<option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}">{{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
	                            	@endfor
	                            </select>
	                            <select class="form-control" name="mm_updated_start">
	                            	@for($i=0; $i<60; $i++)
	                            		<option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}">{{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
	                            	@endfor
	                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_end">Jam Selesai</label>
                        <div class="col-lg-4">
                            <div class="form-inline">
                            	<select class="form-control" name="hh_updated_end">
	                            	@for($i=0; $i<24; $i++)
	                            		<option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}">{{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
	                            	@endfor
	                            </select>
	                            <select class="form-control" name="mm_updated_end">
	                            	@for($i=0; $i<60; $i++)
	                            		<option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}">{{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
	                            	@endfor
	                            </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onClick="update()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Update place [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/timepicker/bootstrap-timepicker.min.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });
        $('.timepicker').timepicker();
    });

    function showFormCreate()
    {
        $('#formCreate').modal('show');
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');
        
        $('input[name=id]').val(id);
        $('select[name=hh_updated_start]').val($('#hh_start-'+id).val());
        $('select[name=mm_updated_start]').val($('#mm_start-'+id).val());
        $('select[name=hh_updated_end]').val($('#hh_end-'+id).val());
        $('select[name=mm_updated_end]').val($('#mm_end-'+id).val());
    }

    function create()
    {
        var start = $('select[name=hh_start]').val()+':'+$('select[name=mm_start]').val();
        var end = $('select[name=hh_end]').val()+':'+$('select[name=mm_end]').val();

        if(start != '' && end != '')
        {
            $.ajax({
                url:'jam',
                type:'POST',
                data:{start : start, end : end},
                success:function(){
                    window.location = "jam";
                }
            });
        }
        else
        {
            window.alert('Mohon Lengkapi Inputan Anda!');
        }
    }

    function update()
    {
        var id = $('input[name=id]').val();
        var start = $('select[name=hh_updated_start]').val()+':'+$('select[name=mm_updated_start]').val();
        var end = $('select[name=hh_updated_end]').val()+':'+$('select[name=mm_updated_end]').val();

        if(id != '' && start != '' && end != '')
        {
            $.ajax({
                url:'jam/'+id,
                type:'PUT',
                data:{start : start, end : end},
                success:function(){
                    window.location = "jam";
                }
            });
        }
        else
        {
            window.alert('Mohon Lengkapi Inputan Anda!');
        }
    }

    function destroy(id)
    {
        if(confirm("Yakin akan menghapus data ini?!"))
        {
        	$.ajax({
	            url:'jam/'+id,
	            type:'DELETE',
	            success:function(){
	                window.location = "jam";
	            }
	        });
        }
    }
</script>
@stop