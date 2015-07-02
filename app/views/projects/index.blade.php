@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/css/daterangepicker/daterangepicker-bs3.css') }}

<section class="content-header">
    <h1>
        Manajemen Project
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="project"><i class="active"></i> Project</a></li>
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
                        <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> Project Baru</button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Kode</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Statistik</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td><span class="badge bg-green">{{ $project->name }}</span></td>
                                <td><span class="badge bg-blue">{{ $project->code }}</span></td>
                                <td><span class="badge bg-yellow">{{ $project->start_date }}</span></td>
                                <td><span class="badge bg-red">{{ $project->end_date }}</span></td>
                                <td><a href="{{ URL::to('project') }}/{{ $project->id }}" class="btn btn-xs btn-primary">Lihat Statistik</a></td>
                                <td>
                                    <input type="hidden" id="code-{{ $project->id }}" value="{{ $project->code }}">
                                    <input type="hidden" id="name-{{ $project->id }}" value="{{ $project->name }}">
                                    <input type="hidden" id="start_date-{{ $project->id }}" value="{{ date('Y/m/d', strtotime($project->start_date)) }}">
                                    <input type="hidden" id="end_date-{{ $project->id }}" value="{{ date('Y/m/d', strtotime($project->end_date)) }}">
                                    <div class="mytooltip">
                                        <button type="button" class="btn btn-primary btn-circle" onclick="showFormUpdate({{ $project->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $project->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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
                <h3 id="myModalLabel">Mulai Project</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Project</label>
                        <div class="col-lg-7">
                            <input name="name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="code">Kode/Singkatan</label>
                        <div class="col-lg-2">
                            <input name="code" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="range">Range Tanggal</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="daterange"/>
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
                        <label class="col-lg-3 control-label" for="updated_name">Project</label>
                        <div class="col-lg-7">
                            <input name="updated_id" type="hidden" value="0">
                            <input name="updated_name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_code">Kode/Singkatan</label>
                        <div class="col-lg-7">
                            <input name="updated_code" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_range">Range Tanggal</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="updated_daterange"/>
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
{{ HTML::script('assets/js/plugins/daterangepicker/daterangepicker.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable({
            "tableTools":{
                "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
            }
        });
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });
        $('input[name=daterange]').daterangepicker({format:'YYYY/MM/DD'});
    });

    function showFormCreate()
    {
        $('#formCreate').modal('show');
        $('input[name=code]').val('');
        $('input[name=name]').val('');
        $('input[name=daterange]').val('');
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');

        var startDate = $('#start_date-'+id).val();
        var endDate = $('#end_date-'+id).val();
        var rangeDate = startDate +' - '+ endDate;

        //console.log(startDate);
        //console.log(endDate);
        
        $('input[name=updated_id]').val(id);
        $('input[name=updated_code]').val($('#code-'+id).val());
        $('input[name=updated_name]').val($('#name-'+id).val());

        $('input[name=updated_daterange]').daterangepicker({
            format:'YYYY/MM/DD',
            startDate:startDate,
            endDate:endDate
        });

        $('input[name=updated_daterange]').val(rangeDate);
    }

    function create()
    {
        var name = $('input[name=name]').val();
        var code = $('input[name=code]').val();
        var range = $('input[name=daterange]').val();

        if(code != '' || name != '' || range != '')
        {
            $.ajax({
                url:'project',
                type:'POST',
                data:{name : name, code : code, range : range},
                success:function(){
                    window.location = "project";
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
        var id = $('input[name=updated_id]').val();
        var name = $('input[name=updated_name]').val();
        var code = $('input[name=updated_code]').val();
        var range = $('input[name=updated_daterange]').val();

        if(id != 0 || code != '' || name != '' || range != '')
        {
            $.ajax({
                url:'project/'+id,
                type:'PUT',
                data:{name : name, code : code, range : range},
                success:function(){
                    window.location = "project";
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