@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Payroll Slip
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kepegawaian</a></li>
        <li><a href="{{ URL::to('payroll') }}"><i class="active"></i> Payroll</a></li>
    </ol>
</section>

<section class="content invoice">
    <div class="row">
        <div class="col-xs-12">
            <p>
                <h4><strong>JILC</strong></h4>
                <small>
                    Jakarta Intensive Learning Centre Cabang Andalas<br/>
                    Jl. Andalas No. 200-200A Telp. 0411-362954, 3629579<br/>
                    E-mail: jilc_andalas@yahoo.com
                </small>
            </p>
        </div>    
    </div>

    <div class="row">
        <div class="col-xs-12">
            <small>
                <table class="table table-condensed">
                    <thead>
                        <tr class="success">
                            <th><i class="fa fa-files-o"></i>  Payroll Slip</th>
                            <th><small class="pull-right">Periode : {{ $curr_month }} / {{ $curr_year }}</small></th>
                        </tr>
                    </thead>
                </table>
            </small>
        </div>
    </div>

    <div class="row invoice-info">
    	<small>
            <div class="col-xs-4 invoice-col">
                ID Karyawan
                <address>
                    <strong>{{ $payroll->employee->employee_id }}</strong>
                </address>
            </div>

            <div class="col-xs-4 invoice-col">
                Kode Tentor
                <address>
                    <strong>{{ $payroll->employee->code }}</strong>
                </address>
            </div>

            <div class="col-xs-4 invoice-col">
                Nama Lengkap
                <address>
                    <strong>{{ $payroll->employee->name }}</strong>
                </address>
            </div>   
        </small>
    </div>

    <div class="row"></div>

    <div class="row">
        <small>
            <div class="col-xs-12">
                <table class="table table-condensed">
                    <thead>
                        <tr class="success">
                            <th colspan="3"><center>Hitungan Honor Mengajar <small>Periode : {{ $curr_month }} / {{ $curr_year }}</small></center></th>
                        </tr>
                        <tr class="warning">
                            <th width="34%"><center>Honor per Jam</center></th>
                            <th width="33%"><center>Total Jam Mengajar</center></th>
                            <th width="33%"><center>Total Honor Mengajar</center></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td><center>Rp{{ number_format($employee->teach_salary,2,',','.') }}</center></td>
                            <td><center>{{ $teaches }}</center></td>
                            <td><center><span class="badge bg-red">Rp{{ number_format($employee->teach_salary*$teaches,2,',','.') }}</span></center></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </small>
    </div>

    <div class="row"></div>

    <div class="row">
        <small>
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
                            <td>Rp{{ number_format($income->nominal,2,',','.') }}</td>
                        </tr>
                        <?php $total_incomes += $income->nominal; ?>
                    @endforeach
                        <tr>
                            <td colspan="2"><center>Total Income</center></td>
                            <td><span class="badge bg-green">Rp{{ number_format($total_incomes,2,',','.') }}</span></td>
                        </tr>
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
                            <td>Rp{{ number_format($deduction->nominal,2,',','.') }}</td>
                        </tr>
                        <?php $total_deductions += $deduction->nominal; ?>
                    @endforeach
                        <tr>
                            <td colspan="2"><center>Total Deduct</center></td>
                            <td><span class="badge bg-yellow">Rp{{ number_format($total_deductions,2,',','.') }}</span></td>
                        </tr>
                    </tbody>
                </table>
        	</div>
        </small>
    </div>

    <div class="row"></div>

    <div class="row">
        <small>
            <div class="col-xs-12">
                <table class="table table-condensed">
                    <thead>
                        <tr class="success">
                            <th colspan="6"><center>Recap Salary</center></th>
                        </tr>
                        <tr class="warning">
                            <th><center>Gaji Pokok</center></th>
                            <th><center>Honor Mengajar</center></th>
                            <th><center>Total Salary</center></th>
                            <th><center>Potongan</center></th>
                            <th><center>Infaq</center></th>
                            <th><center>Take Home Salary</center></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td><center><span class="badge bg-blue">Rp{{ number_format($employee->basic_salary,2,',','.') }}</span></center></td>
                            <td><center><span class="badge bg-yellow">Rp{{ number_format($employee->teach_salary*$teaches,2,',','.') }}</span></center></td>
                            <td><center><span class="badge bg-blue">Rp{{ number_format($payroll->incomes,2,',','.') }}</span></center></td>
                            <td><center><span class="badge bg-red">Rp{{ number_format($payroll->deductions,2,',','.') }}</span></center></td>
                            <td><center><span class="badge bg-green">Rp{{ number_format($payroll->salary*(2.5/100),2,',','.') }}</span></center></td>
                            <td><center><span class="badge bg-yellow">Rp{{ number_format($payroll->salary - ($payroll->salary*(2.5/100)),2,',','.') }}</span></center></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </small>
    </div>

    <div class="row">
        <div class="col-xs-8"></div>
        <div class="col-xs-3">
            <small>
                <center>
                    <span>Makassar, {{ date('d-m-Y', strtotime($payroll->release_date)) }}</span><br/><br/><br/><br/>
                    <span>{{ $employee->name }}</span>      
                </center>      
            </small>
        </div>
        <div class="col-xs-1"></div>
    </div>

    <br/><br/>

    <div class="row no-print">
        <div class="col-xs-12">
            <button class="btn btn-primary" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>
@stop