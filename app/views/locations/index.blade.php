@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Cabang
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('cabang') }}"><i class="active"></i> Cabang</a></li>
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
                        <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> Cabang Baru</button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Kantor Cabang</th>
                                <th>Kode</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($locations as $location)
                            <tr>
                                <td><strong class="text-primary">{{ $location->name }}</strong></td>
                                <td><span class="badge bg-blue">{{ $location->code }}</span></td>
                                <td>{{ $location->address }}</td>
                                <td>{{ $location->contact }}</td>
                                <td>
                                    <input type="hidden" id="code-{{ $location->id }}" value="{{ $location->code }}">
                                    <input type="hidden" id="name-{{ $location->id }}" value="{{ $location->name }}">
                                    <input type="hidden" id="address-{{ $location->id }}" value="{{ $location->address }}">
                                    <input type="hidden" id="contact-{{ $location->id }}" value="{{ $location->contact }}">
                                    <div class="mytooltip">
                                        <button type="button" class="btn btn-primary btn-circle" onclick="showFormUpdate({{ $location->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $location->id }})" data-toggle="tooltip" data-placement="top" title="Hapus" disabled><i class="fa fa-trash-o"></i>
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

<!-- Form Add Location [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Cabang Baru</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Nama Cabang</label>
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
                        <label class="col-lg-3 control-label" for="address">Alamat</label>
                        <div class="col-lg-6">
                            <input name="address" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="contact">Kontak</label>
                        <div class="col-lg-6">
                            <input name="contact" type="text" class="form-control">
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
                        <label class="col-lg-3 control-label" for="updated_name">Nama Cabang</label>
                        <div class="col-lg-7">
                            <input type="hidden" name="location_id" value="0">
                            <input name="updated_name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_code">Kode/Singkatan</label>
                        <div class="col-lg-2">
                            <input name="updated_code" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_address">Alamat</label>
                        <div class="col-lg-6">
                            <input name="updated_address" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_contact">Kontak</label>
                        <div class="col-lg-6">
                            <input name="updated_contact" type="text" class="form-control">
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        })
    });

    function showFormCreate()
    {
        $('#formCreate').modal('show');

        $('input[name=name]').val('');
        $('input[name=code]').val('');
        $('input[name=address]').val('');
        $('input[name=contact]').val('');
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');

        $('input[name=location_id]').val(id);
        $('input[name=updated_code]').val($('#code-'+id).val());
        $('input[name=updated_name]').val($('#name-'+id).val());
        $('input[name=updated_address]').val($('#address-'+id).val());
        $('input[name=updated_contact]').val($('#contact-'+id).val());
    }

    function create()
    {
        var name = $('input[name=name]').val();
        var code = $('input[name=code]').val();
        var address = $('input[name=address]').val();
        var contact = $('input[name=contact]').val();

        if(code != '' && name != '')
        {
            $.ajax({
                url:'cabang',
                type:'POST',
                data:{name : name, code : code, address : address, contact : contact},
                success:function(){
                    window.location = "cabang";
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
        var id = $('input[name=location_id]').val();
        var name = $('input[name=updated_name]').val();
        var code = $('input[name=updated_code]').val();
        var address = $('input[name=updated_address]').val();
        var contact = $('input[name=updated_contact]').val();

        if(code != '' && name != '')
        {
            $.ajax({
                url:'cabang/'+id,
                type:'PUT',
                data:{name : name, code : code, address : address, contact : contact},
                success:function(){
                    window.location = "cabang";
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
        if(confirm("Anda yakin akan menghapus data ini?!"))
        {
            $.ajax({
                url:'cabang/'+id,
                type:'DELETE',
                success:function(){
                    window.location = "cabang";
                }
            });
        }
    }
</script>
@stop