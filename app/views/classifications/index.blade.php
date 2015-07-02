@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Pengklasifikasian
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('klasifikasi') }}"><i class="active"></i> Pengklasifikasian</a></li>
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
                        <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> Klasifikasi Baru</button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="data-table">
                        <thead>
                            <tr>
                                <th>Yang Diklasifikasikan</th>
                                <th>Klasifikasi</th>
                                <th>Keterangan</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($classifications as $classification)
                            <tr>
                                <td>
                                	@if($classification->category == 'Course')
                                		<span class="text-primary">Kelas</span>
                                	@elseif($classification->category == 'Registration')
                                		<span class="text-success">Pendaftaran</span>
                                	@elseif($classification->category == 'Operational')
                                		<span class="text-danger">Biaya Operasional</span>
                                	@elseif($classification->category == 'Resign')
                                        <span class="text-muted">Siswa Keluar</span>
                                    @elseif($classification->category == 'Income')
                                        <span class="text-warning">Income Salary</span>
                                    @elseif($classification->category == 'Deduction')
                                		<span class="text-warning">Deduction Salary</span>
                                	@else 
                                		Tidak Diketahui
                                	@endif
                                </td>
                                <td>{{ $classification->name }}</td>
                                <td>{{ substr($classification->description, 0,100) }}</td>
                                <td>
                                    <input type="hidden" id="category-{{ $classification->id }}" value="{{ $classification->category }}">
                                    <input type="hidden" id="name-{{ $classification->id }}" value="{{ $classification->name }}">
                                    <input type="hidden" id="description-{{ $classification->id }}" value="{{ $classification->description }}">
                                    <div class="mytooltip">
                                        <a href="#" onclick="showFormUpdate({{ $classification->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </a>
                                        &nbsp;
                                        <a href="#" onclick="destroy({{ $classification->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="text-danger fa fa-trash-o"></i>
                                        </a>
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

<!-- Form Add Room [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Klasifikasi Baru</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="category">Yang Diklasifikasikan</label>
                        <div class="col-lg-7">
                           <select class="form-control" name="category">
                           		<option value="Course">Kelas</option>
                           		<option value="Operational">Biaya Operasional</option>
                           		<option value="Registration">Pendaftaran</option>
                                <option value="Resign">Siswa Keluar</option>
                                <option value="Income">Income Salary</option>
                           		<option value="Deduction">Deduction Salary</option>
                           </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Nama Klasifikasi</label>
                        <div class="col-lg-7">
                            <input name="name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="description">Keterangan</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="description" placeholder="Tambahkan Keterangan"></textarea>
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
                <h3 id="myModalLabel">Update klasifikasi</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="udpdated_category">Yang Diklasifikasikan</label>
                        <div class="col-lg-7">
                        	<input type="hidden" name="classification_id" value="0">
                           	<select class="form-control" name="updated_category">
                           		<option value="Course">Kelas</option>
                           		<option value="Operational">Biaya Operasional</option>
                           		<option value="Registration">Pendaftaran</option>
                           		<option value="Resign">Siswa Keluar</option>
                           </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_name">Nama Klasifikasi</label>
                        <div class="col-lg-7">
                            <input name="updated_name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_description">Keterangan</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="updated_description" placeholder="Tambahkan Keterangan"></textarea>
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
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');

        $('input[name=classification_id]').val(id);
        $('select[name=updated_category]').val($('#category-'+id).val());
        $('input[name=updated_name').val($('#name-'+id).val());
        $('textarea[name=updated_description]').val($('#description-'+id).val());
    }

    function create()
    {
        var category = $('select[name=category]').val();
        var name = $('input[name=name]').val();
        var description = $('textarea[name=description]').val();

        if(name != '')
        {
            $.ajax({
                url:'klasifikasi',
                type:'POST',
                data:{category:category, name:name, description:description},
                success:function(){
                    window.location = "{{ URL::to('klasifikasi') }}";
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
        var id = $('input[name=classification_id]').val();
        var category = $('select[name=updated_category]').val();
        var name = $('input[name=updated_name]').val();
        var description = $('textarea[name=updated_description]').val();

        if(name != '')
        {
            $.ajax({
                url:'klasifikasi/'+id,
                type:'PUT',
                data:{category:category, name:name, description:description},
                success:function(){
                    window.location = "{{ URL::to('klasifikasi') }}";
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
        if(confirm("Yakin akan menghapus klasifikasi ini?!"))
        {
             $.ajax({
                url:'klasifikasi/'+id,
                type:'DELETE',
                success:function(){
                    window.location = "{{ URL::to('klasifikasi') }}";
                }
            });
        }
    }
</script>
@stop