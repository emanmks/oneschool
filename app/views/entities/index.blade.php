@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Aset Kantor
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
           @if(Session::has('message'))
            <div class="alert alert-info alert-dismissable">
                <i class="fa fa-warning"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('message') }}
            </div>
            @endif

            <div class="box">
                <div class="box-body table-responsive">
                    <button onclick="showFormCreate()" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Aset</button>
                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Nilai</th>
                                <th>Bagus</th>
                                <th>Rusak</th>
                                <th>Opname</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($entities as $entity)
                            <tr>
                                <td><strong>{{ $entity->code }}</strong></td>
                                <td><strong class="text-primary">{{ $entity->name }}</strong></td>
                                <td><span class="badge bg-yellow">Rp{{ number_format($entity->price,2,',','.') }}</span></td>
                                <td><span class="badge bg-green">{{ $entity->feasible }}</span></td>
                                <td><span class="badge bg-red">{{ $entity->infeasible }}</span></td>
                                <td>
                                	<div class="mytooltip">
                                		<button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Opname" onClick="showFormOpname({{ $entity->id }})"><i class="fa fa-flash"></i> Opname</button>	
                                	</div>
                                </td>
                                <td>
                                    <input type="hidden" id="code-{{ $entity->id }}" value="{{ $entity->code }}">
                                    <input type="hidden" id="name-{{ $entity->id }}" value="{{ $entity->name }}">
                                    <input type="hidden" id="price-{{ $entity->id }}" value="{{ number_format($entity->price,2,',','.') }}">
                                    <input type="hidden" id="feasible-{{ $entity->id }}" value="{{ $entity->feasible }}">
                                    <input type="hidden" id="infeasible-{{ $entity->id }}" value="{{ $entity->infeasible }}">
                                    <input type="hidden" id="employee-{{ $entity->id }}" value="{{ $entity->employee_id }}">
                                    <div class="mytooltip">
                                        <button onclick="showFormUpdate({{ $entity->id }})" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $entity->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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

<!-- Form Add Entity [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Tambah Aset</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="code">Kode</label>
                        <div class="col-lg-3">
                            <input name="code" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Nama</label>
                        <div class="col-lg-7">
                            <input name="name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="price">Harga</label>
                        <div class="col-lg-5">
                            <input name="price" type="text" class="form-control currency" value="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="feasible">Stok Bagus</label>
                        <div class="col-lg-3">
                            <input name="feasible" type="text" class="form-control" value="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="infeasible">Stok Rusak</label>
                        <div class="col-lg-3">
                            <input name="infeasible" type="text" class="form-control" value="0">
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
<!-- End of Add Entity [modal] -->

<!-- Form Update Entity [modal]
===================================== -->
<div id="formUpdate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Update Info Aset</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                	<div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_code">Kode</label>
                        <div class="col-lg-3">
                        	<input type="hidden" name="updated_id" value="0">
                            <input name="updated_code" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_name">Nama</label>
                        <div class="col-lg-7">
                            <input name="updated_name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_price">Harga</label>
                        <div class="col-lg-5">
                            <input name="updated_price" type="text" class="form-control currency">
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
<!-- End of Update Entity [modal] -->

<!-- Form Opname Entity [modal]
===================================== -->
<div id="formOpname" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Update Info Aset</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                	<div class="form-group">
                        <label class="col-lg-3 control-label" for="opname_feasible">Stok Bagus</label>
                        <div class="col-lg-3">
                            <input type="hidden" name="opname_id" value="0">
                            <input name="opname_feasible" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="infeasible">Stok Rusak</label>
                        <div class="col-lg-3">
                            <input name="opname_infeasible" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="employee">Diopname Oleh</label>
                        <div class="col-lg-7">
                            <select class="form-control" name="employee">
                            	@foreach($employees as $employee)
                            		<option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            	@endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onClick="opname()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Opname Entity [modal] -->

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

        $('input[name=updated_id]').val(id);
        $('input[name=updated_code]').val($('#code-'+id).val());
        $('input[name=updated_name]').val($('#name-'+id).val());
        $('input[name=updated_price]').val($('#price-'+id).val());
    }

    function showFormOpname(id)
    {
        $('#formOpname').modal('show');

        $('input[name=opname_id]').val(id);
        $('input[name=opname_feasible]').val($('#feasible-'+id).val());
        $('input[name=opname_infeasible]').val($('#infeasible-'+id).val());
        $('select[name=employee]').val($('#employee-'+id).val());
    }

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
                url:"{{ URL::to('aset') }}",
                type:'POST',
                data:{
                    code:code,
                    name:name,
                    price:price,
                    feasible:feasible,
                    infeasible:infeasible
                    },
                success:function(){
                    window.location = "{{ URL::to('aset') }}";
                }
            });
        }
        else
        {
            window.alert("Nama aset harus jelas!!");
        }
    }

    function update()
    {
        var id = $('input[name=updated_id]').val();
        var code = $('input[name=updated_code]').val();
        var name = $('input[name=updated_name]').val();
        var price = $('input[name=updated_price]').val();

        if(id != '0' && name != '')
        {
            $.ajax({
                url:"{{ URL::to('aset') }}/"+id,
                type:'PUT',
                data:{
                    code:code,
                    name:name,
                    price:price
                    },
                success:function(){
                    window.location = "{{ URL::to('aset') }}";
                }
            });
        }
        else
        {
            window.alert("Nama aset harus jelas!!");
        }
    }

    function opname()
    {
        var id = $('input[name=opname_id]').val();
        var feasible = $('input[name=opname_feasible]').val();
        var infeasible = $('input[name=opname_infeasible]').val();
        var employee = $('select[name=employee]').val();

        if(employee != '0')
        {
            $.ajax({
                url:"{{ URL::to('aset') }}/"+id+"/opname",
                type:'PUT',
                data:{
                    feasible:feasible,
                    infeasible:infeasible,
                    employee:employee
                    },
                success:function(){
                    window.location = "{{ URL::to('aset') }}";
                }
            });
        }
        else
        {
            window.alert("Peng-Opname harus jelas!!");
        }
    }

    function destroy(id)
    {
        if(confirm("Yakin akan menghapus data ini?!"))
        {
            $.ajax({
                url:"{{ URL::to('aset') }}/"+id,
                type:'DELETE',
                success:function(){
                    window.location = "{{ URL::to('aset') }}";
                }
            });
        }
    }
</script>
@stop