@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Penon-Aktifan Siswa
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kesiswaan</a></li>
        <li><a href="{{ URL::to('perpindahan') }}"><i class="active"></i> Penon-aktifan</a></li>
    </ol>
</section>

<section class="content invoice">
    <div class="row">
        <div class="col-xs-12">
        	<h2 class="page-header">
        		<i class="fa fa-files-o"></i> Berita Acara Penon-aktifan Siswa
        		<small class="pull-right">Tanggal : {{ date('d-m-Y') }}</small>
        	</h2>
        </div>
    </div>

    <div class="row invoice-info">
    	<div class="col-sm-4 invoice-col">
    		Siswa
    		<address>
    			<strong>{{ $resign->student->name }}</strong><br/>
    			{{ $resign->student->issue->issue }}<br/>
    			{{ $resign->student->address }}
    		</address>
    	</div>

    	<div class="col-sm-4 invoice-col">
    		Ayah 
    		<address>
    			<strong>{{ $resign->student->father_name }}</strong><br/>
                {{ $resign->student->father_address }}<br/>
                {{ $resign->student->father_contact }}
    		</address>
    	</div>

    	<div class="col-sm-4 invoice-col">
    		Ibu
    		<address>
    			<strong>{{ $resign->student->mother_name }}</strong><br/>
                {{ $resign->student->mother_address }}<br/>
                {{ $resign->student->mother_contact }}
    		</address>
    	</div>
    </div>

    <div class="row">
    	<div class="col-xs-12 table-responsive">
    		<table class="table">
    			<thead>
    				<tr>
    					<th width="80%">Biaya - Biaya</th>
    					<th width="20%">Nilai (Rp)</th>
    				</tr>	
    			</thead>

    			<tbody>
    				<tr>
    					<td>Biaya Denda</td>
    					<td>Rp{{ number_format($resign->fines,2,",",".") }}</td>
    				</tr>
    				<tr>
    					<td>Pengembalian Biaya Bimbingan</td>
    					<td>Rp{{ number_format($resign->returnment,2,",",".") }}</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    </div>

    <div class="row">
    	<div class="col-xs-6">
            Alasan Penon-Aktifan : <strong>{{ $resign->classification->name }}</strong>   
        </div>
    	<div class="col-xs-6">
    		<span class="pull-right">Diproses Oleh</span><br/><br/><br/>
    		<span class="pull-right">{{ $resign->employee->name }}</span>
    	</div>
    </div>

    <div class="row">
    	<div class="col-xs-6">
            Pembayaran Denda<br/>
            Kode Pembayaran Denda : @if(!empty($earning)) {{ $earning->code }} @endif
    		Signature : @if(!empty($earning)) {{ $earning->signature }} @endif
    	</div>
    	<div class="col-xs-6">
            Pengembalian Biaya
    		Signature : @if(!empty($returnment)) {{ $returnment->signature }} @endif
    	</div>
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