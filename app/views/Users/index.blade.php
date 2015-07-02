@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen User
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('user') }}"><i class="active"></i> User</a></li>
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
                        <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> User Baru</button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>Nama User</th>
                                <th>Level User</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->employee->name or 'Tidak Diketahui' }}</td>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('user') }}/{{ $user->id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Lihat History Aktifitas">
                                            <i class="fa fa-user"></i> {{ $user->username }}
                                        </a>
                                    </div>
                                </td>
                                <td><span class="badge bg-blue">  {{ $user->role }}</span></td>
                                <td>
                                    <input type="hidden" id="location-{{ $user->id }}" value="{{ $user->location_id }}">
                                    <input type="hidden" id="employee-{{ $user->id }}" value="{{ $user->employee_id }}">
                                    <input type="hidden" id="username-{{ $user->id }}" value="{{ $user->username }}">
                                    <input type="hidden" id="role-{{ $user->id }}" value="{{ $user->role }}">
                                    <div class="mytooltip">
                                        <button type="button" class="btn btn-primary btn-circle" onclick="showFormUpdate({{ $user->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $user->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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

<!-- Form Add User [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">User Baru</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="location">Pilih Lokasi</label>
                        <div class="col-lg-5">
                            @if(Auth::user()->role == "Super Admin")
                            <select class="form-control" name="location">
                            @else
                            <select class="form-control" name="location" disabled>
                            @endif
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
                        <label class="col-lg-3 control-label" for="employee">Pilih Pegawai</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="employee">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="username">Username</label>
                        <div class="col-lg-6">
                            <input name="username" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="password">Password</label>
                        <div class="col-lg-7">
                            <input name="password" type="password" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="role">Level User</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="role">
                            	<option value="Admin">Admin</option>
                            	<option value="Front Office">Front Office</option>
                            	<option value="Accounting">Accounting</option>
                            </select>
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
<!-- End of Add User [modal] -->

<!-- Form Update User [modal]
===================================== -->
<div id="formUpdate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Update User</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_location">Pilih Lokasi</label>
                        <div class="col-lg-5">
                            <input type="hidden" name="userID" value="0"> 
                            @if(Auth::user()->role = "Super Admin")
                            <select class="form-control" name="updated_location">
                            @else
                            <select class="form-control" name="updated_location" disabled>
                            @endif
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_employee">Pilih Pegawai</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="updated_employee">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_username">Username</label>
                        <div class="col-lg-6">
                            <input name="updated_username" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_role">Level User</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="updated_role">
                            	<option value="Admin">Admin</option>
                            	<option value="Front Office">Front Office</option>
                            	<option value="Accounting">Accounting</option>
                            </select>
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
<!-- End of Update User [modal] -->

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

        $('input[name=username]').val('');
        $('input[name=password]').val('');
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');

        $('input[name=userID]').val(id);
        $('select[name=updated_location]').val($('#location-'+id).val());
        $('input[name=updated_username]').val($('#username-'+id).val());
        $('select[name=updated_role]').val($('#role-'+id).val());
        $('select[name=updated_employee]').val($('#employee-'+id).val());
    }

    function create()
    {
        var location = $('select[name=location]').val();
        var employee = $('select[name=employee]').val();
        var username = $('input[name=username]').val();
        var password = $('input[name=password]').val();
        var role = $('select[name=role]').val();

        if(employee != '' && username != '')
        {
            $.ajax({
                url:'user',
                type:'POST',
                data:{location:location, 
                    employee:employee, 
                    username:username,
                    password:password, 
                    role:role},
                success:function(){
                    window.location = "user";
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
        var id = $('input[name=userID]').val();
        var location = $('select[name=updated_location]').val();
        var employee = $('select[name=updated_employee]').val();
        var username = $('input[name=updated_username]').val();
        var role = $('select[name=updated_role]').val();

        if(employee != '' || username != '')
        {
            $.ajax({
                url:'user/'+id,
                type:'PUT',
                data:{location:location, 
                    employee:employee, 
                    username:username, 
                    role:role},
                success:function(){
                    window.location = "user";
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
        if(confirm("Yakin akan menghapus data sekolah ini?!"))
        {
             $.ajax({
                url:'user/'+id,
                type:'DELETE',
                success:function(){
                    window.location = "user";
                }
            });
        }
    }
</script>
@stop