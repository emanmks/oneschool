@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Kwitansi Pembayaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('penerimaan') }}"><i class="active"></i> Penerimaan</a></li>
    </ol>
</section>

<section class="content invoice">
    <div class="row">
        <div class="col-xs-12">
            <p>
                <h4><strong>One School</strong></h4>
                <small>
                    One School Office<br/>
                    Jl. Poros Limbung No. 55<br/>
                    Telp : 0411 - 8217794 / 085397815928
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
                            <th><i class="fa fa-files-o"></i>  Kwitansi Pembayaran Nomor : #{{ $earning->code }}</th>
                            <th><small class="pull-right">Tanggal Cetak : {{ date('d-m-Y H:i:s') }}</small></th>
                        </tr>
                    </thead>
                </table>
            </small>
        </div>
    </div>

    <div class="row invoice-info">
        <small>
            <div class="col-xs-4 invoice-col">
                Terima Dari:
                <address>
                    <strong>{{ $earning->issue->student->name }}</strong><br/>
                    Nomor Pokok: {{ $earning->issue->issue }}<br/>
                </address>
            </div>

            <div class="col-xs-4 invoice-col">
                Diterima Oleh:
                <address>
                    <strong>{{ $earning->employee->name }}</strong><br/>
                    a/n {{ $earning->location->name }}
                </address>
            </div>

            <div class="col-xs-4 invoice-col">
                Pada:
                <address>
                    <strong>{{ date('d-m-Y', strtotime($earning->earning_date)) }}</strong>
                </address>
            </div>   
        </small>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <small>
                <table class="table table-condensed">
                    <thead>
                        <tr class="warning">
                            <th width="50%">Pembayaran</th>
                            <th width="20%"><span class="pull-right">Nominal</span></th>
                            <th width="30%">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($earnings as $earning)
                            <tr>
                                <td>
                                    @if($earning->earnable_type == 'Receivable')
                                        <i>Pembayaran Biaya Bimbingan yang dibebankan atas Pendaftaran tanggal {{ date('d-m-Y', strtotime($earning->earnable->registration->registration_date)) }}</i>
                                    @elseif($earning->earnable_type == 'Installment')
                                        <i>Pembayaran Angsuran Biaya Bimbingan yang jatuh Tempo pada : {{ date('d-m-Y', strtotime($earning->earnable->schedule)) }}</i>
                                    @elseif($earning->earnable_type == 'Registration')
                                        <i>Pembayaran Biaya PDF yang dibebankan atas Pendaftaran tanggal {{ date('d-m-Y', strtotime($earning->earnable->registration_date)) }}</i>
                                    @elseif($earning->earnable_type == 'Movement')
                                        <i>Pembayaran Biaya Pindah Kelas</i>
                                    @elseif($earning->earnable_type == 'Punishment')
                                        <i>Pembayaran Denda {{ substr($earning->earnable->comments, 0,100) }}</i>
                                    @elseif($earning->earnable_type == 'Resign')
                                        <i>Denda Siswa Keluar</i>
                                    @else
                                        Pembayaran "Unclassified"
                                    @endif
                                </td>
                                <td><strong class="pull-right">Rp{{ number_format($earning->payment,2,",",".") }}</strong></td>
                                <td><small>{{ substr($earning->comments, 0,50) }}</small></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                

                Signature : <i>{{ $earning->signature }}</i>
            </small>
        </div>
    </div>

    <div class="row">
    	<div class="col-xs-8"></div>
    	<div class="col-xs-3">
    		<small>
                <center>
                    <span>Makassar, {{ date('d-m-Y') }}</span><br/><br/><br/>
                    <span>{{ $earning->employee->name }}</span>      
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