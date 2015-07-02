@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/iCheck/all.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Hitung Payroll <small>{{ $employee->name }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Akademik</a></li>
        <li><a href="{{ URL::to('kuis') }}/{{ $employee->id }}"><i class="active"></i> Nilai Quiz</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header"><h2 class="box-title">Form Payroll - {{ $curr_month }} / {{ $curr_year }}</h2></div>

                <div class="box-body">
                	<div id="theAlert" class="alert alert-danger alert-dismissable">
		                <i class="fa fa-warning"></i>
		                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

		                Terjadi Kesalahan, Gagal Menyimpan Nilai Quiz
		            </div>
                    <form class="form form-horizontal">
                    	<div class="form-group">
                            <label class="col-lg-3 control-label" for="employee">ID Karyawan</label>
                            <div class="col-lg-4">
                                <input type="hidden" name="employee" value="{{ $employee->id }}">
                                <input type="text" class="form-control" value="{{ $employee->employee_id }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="code">Kode Tentor</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" value="{{ $employee->code }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
	                        <label class="col-lg-3 control-label" for="name">Nama Lengkap</label>
	                        <div class="col-lg-4">
	                        	<input type="text" class="form-control" value="{{ $employee->name }}" disabled>
	                        </div>
	                    </div>
	                    <div class="form-group">
                            <label class="col-lg-3 control-label" for="basic_salary">Gaji Pokok</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="basic_salary" value="{{ number_format($employee->basic_salary,2,',',',') }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
	                        <label class="col-lg-3 control-label" for="basic_salary">Gaji Mengajar</label>
	                        <div class="col-lg-3">
	                           	<input type="text" class="form-control" name="basic_salary" value="{{ number_format($employee->teach_salary,2,',',',') }}" disabled>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-lg-3 control-label" for="release_date">Jadwal Payroll</label>
	                        <div class="col-lg-2">
	                           	<input type="text" class="form-control" name="release_date" value="{{ date('Y-m-d') }}">
	                        </div>
	                    </div>
                    </form>

                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-condensed" id="data-table">
                        <thead>
                            <tr class="success">
                                <th colspan="5"><center>Riwayat Pertemuan Bulan ini</center></th>
                            </tr>
                            <tr class="warning">
                                <th>Tanggal</th>
                                <th>Kelas</th>
                                <th>Bidang Studi</th>
                                <th>Jam Belajar</th>
                                <th>Materi</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php $teaches_count = 0; ?>
                        @foreach($teaches as $teach)
                            <tr>
                                <td>{{ date('d-m-Y', strtotime($teach->course_date)) }}</td>
                                <td><span class="badge bg-blue">{{ $teach->course->name }}</span></td>
                                <td>{{ $teach->subject->name }}</td>
                                <td>{{ $teach->hour->start }} - {{ $teach->hour->end }}</td>
                                <td>{{ $teach->title }}</td>
                            </tr>
                            <?php $teaches_count += 1; ?>
                        @endforeach
                        </tbody>
                    </table>

                    <table class="table table-condensed">
                        <thead>
                            <tr class="warning">
                                <th width="34%"><center>Honor per Jam</center></th>
                                <th width="33%"><center>Total Jam Mengajar</center></th>
                                <th width="33%"><center>Total Honor Mengajar</center></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td><center>Rp{{ number_format($employee->teach_salary,2,',',',') }}</center></td>
                                <td><center>{{ $teaches_count }}</center></td>
                                <td><center><span class="badge bg-red">Rp{{ number_format($employee->teach_salary*$teaches_count,2,',',',') }}</span></center></td>
                                <input type="hidden" name="total_teach_salary" value="{{ $employee->teach_salary*$teaches_count }}">
                            </tr>
                        </tfoot>
                    </table>

                    <div class="clear-fix"><br/></div>

                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                                <tr class="success">
                                    <th colspan="3"><center>Incomes</center></th>
                                </tr>
                                <tr class="warning">
                                    <th width="34%">Jenis</th>
                                    <th width="33%">Tanggal</th>
                                    <th width="33%">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $total_incomes = 0; ?>
                            @foreach($incomes as $income)
                                <tr>
                                    <td>{{ $income->classification->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($income->release_date)) }}</td>
                                    <td>Rp{{ number_format($income->nominal,2,',',',') }}</td>
                                </tr>
                                <?php $total_incomes += $income->nominal; ?>
                            @endforeach
                                <tr>
                                    <td colspan="2"><center>Total Income</center></td>
                                    <td><span class="badge bg-green">Rp{{ number_format($total_incomes,2,',',',') }}</span></td>
                                </tr>
                                <input type="hidden" name="total_incomes" value="{{ $total_incomes }}">
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                                <tr class="success">
                                    <th colspan="3"><center>Deductions</center></th>
                                </tr>
                                <tr class="warning">
                                    <th width="34%">Jenis</th>
                                    <th width="33%">Tanggal</th>
                                    <th width="33%">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $total_deductions = 0; ?>
                            @foreach($deductions as $deduction)
                                <tr>
                                    <td>{{ $deduction->classification->name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($deduction->release_date)) }}</td>
                                    <td>Rp{{ number_format($deduction->nominal,2,',',',') }}</td>
                                </tr>
                                <?php $total_deductions += $deduction->nominal; ?>
                            @endforeach
                                <tr>
                                    <td colspan="2"><center>Total Deduct</center></td>
                                    <td><span class="badge bg-yellow">Rp{{ number_format($total_deductions,2,',',',') }}</span></td>
                                </tr>
                                <input type="hidden" name="total_deductions" value="{{ $total_deductions }}">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box-footer">
                    <button class="btn btn-primary" onclick="createPayroll()"><i class="fa fa-floppy-o"></i> Simpan Payroll</button>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/currency.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();

        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('[name=release_date]').datepicker({format:"yyyy-mm-dd"});

        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });

        $('#theAlert').hide();
    });

    function createPayroll()
    {
    	var employee_id = $('[name=employee]').val();
        var total_teach_salary = $('[name=total_teach_salary]').val();
        var total_incomes = $('[name=total_incomes]').val();
        var total_deductions = $('[name=total_deductions]').val();
        var release_date = $('[name=release_date]').val();

        if(employee_id != '0')
        {
        	$.ajax({
        		url:"{{ URL::to('payroll') }}",
        		type:"POST",
        		data:{
        			employee_id:employee_id,
                    teaches_salary:total_teach_salary,
                    incomes:total_incomes,
                    deductions:total_deductions,
        			release_date:release_date
        		},
        		success:function(){
        			window.location = "{{ URL::to('payroll') }}";
        		},
        		error:function(){
        			$('#theAlert').show();
        		}
        	});
        }
        else
        {
        	window.alert("Mohon Lengkapi Data Anda!!!");
        }
    }
</script>
@stop