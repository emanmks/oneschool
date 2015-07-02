@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Bukti Pengeluaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('pengeluaran') }}"><i class="active"></i> Pengeluaran</a></li>
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
                            <th><i class="fa fa-files-o"></i>  Bukti Pengeluaran Nomor : #{{ $spending->code }}</th>
                            <th><small class="pull-right">Tanggal Cetak : {{ date('d-m-Y H:i:s') }}</small></th>
                        </tr>
                    </thead>
                </table>
            </small>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <small>
                <table class="table table-condensed">
                    <thead>
                        <tr class="warning">
                            <th width="50%">Pembayaran</th>
                            <th width="20%"><span class="pull-right">Nominal</span></th>
                            <th width="30%">Pegawai</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                        	<td>
                        		@if($spending->spendable_type == 'Payroll')
                        			Gaji
                        		@elseif($spending->spendable_type == 'Classification')
                        			{{ $spending->spendable->name }}
                        		@else
                        			Tidak Diketahui
                        		@endif
                        	</td>
                        	<td><span class="pull-right">Rp{{ number_format($spending->total,2,",",".") }}</span></td>
                        	<td>{{ $spending->employee->name }}</td>
                        </tr>
                    </tbody>
                </table>
                

                Signature : <i>{{ $spending->signature }}</i>
            </small>
        </div>
    </div>

    <div class="row">
    	<div class="col-xs-8"></div>
    	<div class="col-xs-3">
    		<small>
                <center>
                    <span>Makassar, {{ date('d-m-Y') }}</span><br/><br/><br/>
                    <span>{{ $spending->employee->name }}</span>      
                </center>      
            </small>
    	</div>
    	<div class="col-xs-1"></div>
    </div>

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