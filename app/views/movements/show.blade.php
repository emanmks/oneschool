@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Pindah Kelas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kesiswaan</a></li>
        <li><a href="{{ URL::to('perpindahan') }}"><i class="active"></i> Pindah Kelas</a></li>
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
                            <th><i class="fa fa-files-o"></i>  Berita Acara Pindah Kelas</th>
                            <th><small class="pull-right">Tanggal : {{ date('d-m-Y') }}</small></th>
                        </tr>
                    </thead>
                </table>
            </small>
        </div>
    </div>

    <div class="row invoice-info">
    	<small>
            <div class="col-sm-4 invoice-col">
                Siswa
                <address>
                    <strong>{{ $movement->issue->student->name }}</strong><br/>
                    {{ $movement->issue->issue }}<br/>
                    {{ $movement->issue->student->address }}
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                Pindah Dari Kelas: 
                <address>
                    <strong>{{ $movement->base->name }}</strong><br/>
                    {{ $movement->base->course_days }}<br/>
                    Rp{{ number_format($movement->base->costs,2,",",".") }}
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                Ke Kelas:
                <address>
                    <strong>{{ $movement->destination->name }}</strong><br/>
                    {{ $movement->destination->course_days }}<br/>
                    Rp{{ number_format($movement->destination->costs,2,",",".") }}
                </address>
            </div>   
        </small>
    </div>

    <div class="row">
    	<small>
            <div class="col-xs-12">
                <table class="table table-condensed">
                    <thead>
                        <tr class="warning">
                            <th width="80%">Biaya - Biaya</th>
                            <th width="20%">Nilai (Rp)</th>
                        </tr>   
                    </thead>

                    <tbody>
                        <tr>
                            <td>Biaya Pindah Kelas</td>
                            <td>Rp{{ number_format($movement->movement_costs,2,",",".") }}</td>
                        </tr>
                        <tr>
                            <td>Biaya Upgrade Kelas</td>
                            <td>Rp{{ number_format($movement->upgrade_costs,2,",",".") }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>   
        </small>
    </div>

    <div class="row">
    	<small>
            <div class="col-xs-6"></div>
            <div class="col-xs-6">
                <span class="pull-right">Diproses Oleh</span><br/><br/><br/>
                <span class="pull-right">{{ $movement->employee->name }}</span>
            </div>   
        </small>
    </div>

    <div class="row">
    	<small>
            <div class="col-xs-6">
                Kode Pembayaran : @if(!empty($earning)) {{ $earning->code }} @endif
            </div>
            <div class="col-xs-6">
                Signature : @if(!empty($earning)) {{ $earning->signature }} @endif
            </div>   
        </small>
    </div>

    <div class="row no-print">
        <div class="col-xs-12">
        	@if($movement->paid == 1)
            	<button class="btn btn-primary" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
            @else
            	<button class="btn btn-primary" onclick="window.print();" disabled><i class="fa fa-print"></i> Print</button>
            	<button class="btn btn-primary" onclick="pay({{ $movement->id }})"><i class="fa fa-money"></i> Bayar Sekarang!</butto>
            @endif
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        
    });

    function pay(id)
    {
    	$.ajax({
    		url:"{{ URL::to('perpindahan') }}/"+id+"/bayar",
    		type:"PUT",
    		success:function()
    		{
    			window.location = "{{ URL::to('perpindahan') }}/"+id;
    		}
    	});
    }
</script>
@stop