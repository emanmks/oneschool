@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Bukti Pengembalian
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('pengembalian') }}"><i class="active"></i> Pengembalian</a></li>
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
                            <th><i class="fa fa-files-o"></i>  Bukti Pengembalian Nomor : #{{ $returnment->code }}</th>
                            <th><small class="pull-right">Tanggal Cetak : {{ date('d-m-Y H:i:s') }}</small></th>
                        </tr>
                    </thead>
                </table>
            </small>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <small>
               	Terima Dari:
                <address>
                	<strong>{{ $returnment->employee->name }}</strong><br/>
                	a/n {{ $returnment->location->name }}
                </address>
            </small>
        </div>
        <div class="col-xs-6">
            <small>
               	Pengembalian Biaya Bimbingan:
                <address>
                	<strong>Sebesar : Rp{{ number_format($returnment->total,2,",",".") }}</strong><br/>
                	@if($returnment->resign_id > 0)
                		Sebagai kebijakan atas {{ $returnment->resign->classification->name }} pada {{ date('d-m-Y', strtotime($returnment->resign->resign_date)) }}
                	@else
                		{{ $returnment->comments }}
                	@endif
                </address>

                Signature : <i>{{ $returnment->signature }}</i>
            </small>
        </div>
    </div>

    <div class="row">
    	<br/><br/>
    	<div class="col-xs-8"></div>
    	<div class="col-xs-3">
    		<small>
                <center>
                    <span>Makassar, {{ date('d-m-Y') }}</span><br/><br/><br/>
                    <span>{{ $returnment->issue->student->name }}</span>      
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