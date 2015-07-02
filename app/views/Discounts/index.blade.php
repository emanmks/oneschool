@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Diskon
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('diskon') }}"><i class="active"></i> Diskon</a></li>
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
                        <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> Diskon Baru</button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Nama Diskon</th>
                                <th>Diberikan Oleh</th>
                                <th>Nilai</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($discounts as $discount)
                            <tr>
                                <td>{{ $discount->name }}</td>
                                <td>{{ $discount->given_by }}</td>
                                <td><span class="badge bg-blue">Rp{{ number_format($discount->nominal,2,",",".") }}</span></td>
                                <td>
                                    <input type="hidden" id="name-{{ $discount->id }}" value="{{ $discount->name }}">
                                    <input type="hidden" id="given_by-{{ $discount->id }}" value="{{ $discount->given_by }}">
                                    <input type="hidden" id="nominal-{{ $discount->id }}" value="{{ number_format($discount->nominal,2,",",".") }}">
                                    <div class="mytooltip">
                                        <button type="button" class="btn btn-primary btn-circle" onclick="showFormUpdate({{ $discount->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $discount->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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
                <h3 id="myModalLabel">Diskon Baru</h3>
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
                        <label class="col-lg-3 control-label" for="given_by">Diberikan Oleh</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="given_by">
                                <option value="0">--Pilih</option>
                                <option value="Owner Pusat">Owner Pusat</option>
                                <option value="Owner Cabang">Owner Cabang</option>
                                <option value="Dircab">Direktur Cabang</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="nominal">Nominal</label>
                        <div class="col-lg-4">
                            <input name="nominal" type="text" class="form-control currency">
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
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_name">Nama</label>
                        <div class="col-lg-7">
                            <input type="hidden" name="updated_id" value="0">
                            <input name="updated_name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_given_by">Diberikan Oleh</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="updated_given_by">
                                <option value="0">--Pilih</option>
                                <option value="Owner Pusat">Owner Pusat</option>
                                <option value="Owner Cabang">Owner Cabang</option>
                                <option value="Dircab">Direktur Cabang</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_nominal">Nominal</label>
                        <div class="col-lg-4">
                            <input name="updated_nominal" type="text" class="form-control currency">
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
{{ HTML::script('assets/js/currency.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();

        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });
    });

    function showFormCreate()
    {
        $('#formCreate').modal('show');
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');
        
        $('[name=updated_id]').val(id);
        $('[name=updated_name]').val($('#name-'+id).val());
        $('[name=updated_given_by]').val($('#given_by-'+id).val());
        $('[name=updated_nominal]').val($('#nominal-'+id).val());
    }

    function create()
    {
        var name = $('[name=name]').val();
        var given_by = $('[name=given_by]').val();
        var nominal = $('[name=nominal]').val();

        if(name != '' && given_by != '0')
        {
            $.ajax({
                url:"{{ URL::to('diskon') }}",
                type:'POST',
                data:{name : name, given_by:given_by, nominal:nominal},
                success:function(){
                    window.location = "{{ URL::to('diskon') }}";
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
        var id = $('[name=updated_id]').val();
        var name = $('[name=updated_name]').val();
        var given_by = $('[name=updated_given_by]').val();
        var nominal = $('[name=updated_nominal]').val();

        if(id != '0' && name != '' && given_by != '0')
        {
            $.ajax({
                url:"{{ URL::to('diskon') }}/"+id,
                type:'PUT',
                data:{name : name, given_by:given_by, nominal:nominal},
                success:function(){
                    window.location = "{{ URL::to('diskon') }}";
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
                url:"{{ URL::to('diskon') }}/"+id,
                type:'DELETE',
                success:function(){
                    window.location = "{{ URL::to('diskon') }}";
                }
            });
    	}
    }
</script>
@stop