@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/css/daterangepicker/daterangepicker-bs3.css') }}

<section class="content-header">
    <h1>
        Manajemen Karyawan
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('karyawan') }}"><i class="active"></i> Karyawan</a></li>
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
                        <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> Karyawan Baru</button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>ID Karyawan</th>
                                <th>Kode Tentor</th>
                                <th>Nama Lengkap</th>
                                <th>Kontak</th>
                                <th>Basic Salary</th>
                                <th>Teach Salary</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td><span class="badge bg-green">{{ $employee->employee_id }}</span></td>
                                <td><span class="badge bg-blue">{{ $employee->code }}</span></td>
                                <td>
                                	<div class="mytooltip">
                                		<a href="{{ URL::to('karyawan') }}/{{ $employee->id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk lihat Riwayat Aktifitas">{{ $employee->name }}</a>
                                	</div>
                                </td>
                                <td>{{ $employee->contact }}</td>
                                <td><span class="badge bg-yellow">Rp{{ number_format($employee->basic_salary,2,',','.') }}</span></td>
                                <td><span class="badge bg-red">Rp{{ number_format($employee->teach_salary,2,',','.') }}</span></td>
                                <td>
                                    <input type="hidden" id="employee_id-{{ $employee->id }}" value="{{ $employee->employee_id }}">
                                    <input type="hidden" id="code-{{ $employee->id }}" value="{{ $employee->code }}">
                                    <input type="hidden" id="name-{{ $employee->id }}" value="{{ $employee->name }}">
                                    <input type="hidden" id="contact-{{ $employee->id }}" value="{{ $employee->contact }}">
                                    <input type="hidden" id="basic_salary-{{ $employee->id }}" value="{{ $employee->basic_salary }}">
                                    <input type="hidden" id="teach_salary-{{ $employee->id }}" value="{{ $employee->teach_salary }}">
                                    <div class="mytooltip">
                                        <button type="button" class="btn btn-primary btn-circle" onclick="showFormUpdate({{ $employee->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $employee->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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

<!-- Form Add Employee [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Karyawan Baru</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="employeeID">ID Karyawan</label>
                        <div class="col-lg-5">
                            <input name="employeeID" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="code">Kode Tentor</label>
                        <div class="col-lg-2">
                            <input name="code" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Nama Lengkap</label>
                        <div class="col-lg-8">
                            <input name="name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="contact">Kontak</label>
                        <div class="col-lg-8">
                            <input name="contact" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="basicSalary">Basic Salary</label>
                        <div class="col-lg-5">
                            <input name="basicSalary" type="text" class="form-control" value="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="teachSalary">Teach Salary</label>
                        <div class="col-lg-5">
                            <input name="teachSalary" type="text" class="form-control" value="0">
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
<!-- End of Add Employee [modal] -->

<!-- Form Update Employee [modal]
===================================== -->
<div id="formUpdate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Update Karyawan</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_employeeID">ID Karyawan</label>
                        <div class="col-lg-5">
                        	<input type="hidden" name="updated_id">
                            <input name="updated_employeeID" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_code">Kode Tentor</label>
                        <div class="col-lg-2">
                            <input name="updated_code" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Nama Lengkap</label>
                        <div class="col-lg-8">
                            <input name="updated_name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_contact">Kontak</label>
                        <div class="col-lg-8">
                            <input name="updated_contact" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="basicSalary">Basic Salary</label>
                        <div class="col-lg-5">
                            <input name="updated_basicSalary" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="teachSalary">Teach Salary</label>
                        <div class="col-lg-5">
                            <input name="updated_teachSalary" type="text" class="form-control">
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
<!-- End of Update Employee [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/daterangepicker/daterangepicker.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });
        $('input[name=daterange]').daterangepicker({format:'YYYY/MM/DD'});
    });

    function showFormCreate()
    {
        $('#formCreate').modal('show');
        $('input[name=employeeID]').val('');
        $('input[name=code]').val('');
        $('input[name=name]').val('');
        $('input[name=contact]').val('');
        $('input[name=basicSalary]').val('');
        $('input[name=teachSalary]').val('');
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');

        $('input[name=updated_id]').val(id);
        $('input[name=updated_employeeID]').val($('#employee_id-'+id).val());
        $('input[name=updated_code]').val($('#code-'+id).val());
        $('input[name=updated_name]').val($('#name-'+id).val());
        $('input[name=updated_contact]').val($('#contact-'+id).val());
        $('input[name=updated_basicSalary]').val($('#basic_salary-'+id).val());
        $('input[name=updated_teachSalary]').val($('#teach_salary-'+id).val());
    }

    function create()
    {
        var employee_id = $('input[name=employeeID]').val();
        var name = $('input[name=name]').val();
        var code = $('input[name=code]').val();
        var contact = $('input[name=contact]').val();
        var basic_salary = $('input[name=basicSalary]').val();
        var teach_salary = $('input[name=teachSalary]').val();

        if(name != '')
        {
            $.ajax({
                url:'karyawan',
                type:'POST',
                data:{employee_id:employee_id, 
                	name:name, 
                	code:code, 
                	contact:contact, 
                	basic_salary:basic_salary, 
                	teach_salary:teach_salary},
                success:function(){
                    window.location = "karyawan";
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
        var employee_id = $('input[name=updated_employeeID]').val();
        var name = $('input[name=updated_name]').val();
        var code = $('input[name=updated_code]').val();
        var contact = $('input[name=updated_contact]').val();
        var basic_salary = $('input[name=updated_basicSalary]').val();
        var teach_salary = $('input[name=updated_teachSalary]').val();

        if(id != 0 && name != '')
        {
            $.ajax({
                url:'karyawan/'+id,
                type:'PUT',
                data:{employee_id:employee_id, 
                	name:name, 
                	code:code, 
                	contact:contact, 
                	basic_salary:basic_salary, 
                	teach_salary:teach_salary},
                success:function(){
                    window.location = "karyawan";
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