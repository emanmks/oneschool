@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Mitra / Kontak Person
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('mitra') }}"><i class="active"></i> Mitra / Kontak Person</a></li>
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
                        <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> Mitra Baru</button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                                <th>Email</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($partners as $partner)
                            <tr>
                                <td><strong>{{ $partner->name }}</strong></td>
                                <td>{{ $partner->address }}</td>
                                <td><strong class="text-primary">{{ $partner->contact }}</strong></td>
                                <td><strong class="text-success">{{ $partner->email }}</strong></td>
                                <td>
                                    <input type="hidden" id="name-{{ $partner->id }}" value="{{ $partner->name }}">
                                    <input type="hidden" id="address-{{ $partner->id }}" value="{{ $partner->address }}">
                                    <input type="hidden" id="contact-{{ $partner->id }}" value="{{ $partner->contact }}">
                                    <input type="hidden" id="email-{{ $partner->id }}" value="{{ $partner->email }}">
                                    <div class="mytooltip">
                                        <button type="button" class="btn btn-primary btn-circle" onclick="showFormUpdate({{ $partner->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $partner->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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

<!-- Form Add Discount [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Mitra Baru</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Nama</label>
                        <div class="col-lg-7">
                            <input name="name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="address">Alamat</label>
                        <div class="col-lg-8">
                            <textarea name="address" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="contact">Kontak</label>
                        <div class="col-lg-7">
                            <input name="contact" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="email">Email</label>
                        <div class="col-lg-7">
                            <input name="email" type="text" class="form-control">
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
<!-- End of Add Discount [modal] -->

<!-- Form Update Discount [modal]
===================================== -->
<div id="formUpdate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Update Discount</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_name">Nama</label>
                        <div class="col-lg-7">
                        	<input type="hidden" name="updated_id" value="0">
                            <input name="updated_name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_address">Alamat</label>
                        <div class="col-lg-8">
                            <textarea name="updated_address" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_contact">Kontak</label>
                        <div class="col-lg-7">
                            <input name="updated_contact" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_email">Email</label>
                        <div class="col-lg-7">
                            <input name="updated_email" type="text" class="form-control">
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
<!-- End of Update Discount [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });
    });

    function showFormCreate()
    {
        $('#formCreate').modal('show');
        $('input[name=name]').val('');
        $('input[name=contact]').val('');
        $('input[name=email]').val('');
        $('textarea[name=address]').val('');
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');
        
        $('input[name=updated_id]').val(id);
        $('input[name=updated_name]').val($('#name-'+id).val());
        $('input[name=updated_contact]').val($('#contact-'+id).val());
        $('input[name=updated_email]').val($('#email-'+id).val());
        $('textarea[name=updated_address]').val($('#address-'+id).val());
    }

    function create()
    {
        var name = $('input[name=name]').val();
        var address = $('textarea[name=address]').val();
        var contact = $('input[name=contact]').val();
        var email = $('input[name=email]').val();

        if(name != '')
        {
            $.ajax({
                url:'mitra',
                type:'POST',
                data:{name : name, address:address, contact:contact, email:email},
                success:function(){
                    window.location = "mitra";
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
        var address = $('textarea[name=updated_address]').val();
        var contact = $('input[name=updated_contact]').val();
        var email = $('input[name=updated_email]').val();

        if(id != 0 && name != '')
        {
            $.ajax({
                url:'mitra/'+id,
                type:'PUT',
                data:{name:name, address:address, contact:contact, email:email},
                success:function(){
                    window.location = "mitra";
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
                url:'mitra/'+id,
                type:'DELETE',
                success:function(){
                    window.location = "mitra";
                }
            });
    	}
    }
</script>
@stop