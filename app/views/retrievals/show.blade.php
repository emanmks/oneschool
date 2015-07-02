@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Pengambilan Handbook
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#">Kesiswaan</a></li>
        <li><a href="{{ URL::to('pengambilan') }}"><i class="active"></i> Pengambilan Handbook</a></li>
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
                            <th><i class="fa fa-files-o"></i>  Riwayat Pengambilan Handbook</th>
                            <th><small class="pull-right">Tanggal : {{ date('d-m-Y') }}</small></th>
                        </tr>
                    </thead>
                </table>
            </small>
        </div>
    </div>

    <div class="row invoice-info">
    	<small>
            <div class="col-xs-4 invoice-col">
                Biodata Siswa
                <address>
                    <strong>{{ $issue->student->name }}</strong>  [@if($issue->student->sex == 'L') L @else P @endif]<br/>
                    <small>TTL</small> : {{ $issue->student->birthplace }}, {{ date('d-m-Y', strtotime($issue->student->birthdate)) }} <br/>
                    <small>Agama</small> : {{ $issue->student->religion }} <br/>
                    <small>Alamat</small> : {{ $issue->student->address }} <br/>
                    <small>Kontak</small> : {{ $issue->student->contact }} <br/>
                    <small>Email</small> : {{ $issue->student->email }} 
                </address>
            </div>

            <div class="col-xs-4 invoice-col">
                Ayah
                <address>
                    <small>Nama</small> : {{ $issue->student->father_name }}<br/>
                    <small>Pekerjaan</small> : {{ $issue->student->father_occupation }}<br/>
                    <small>Alamat</small> : {{ $issue->student->father_address }} <br/>
                    <small>Kontak</small> : {{ $issue->student->father_contact }} <br/>
                    <small>Email</small> : {{ $issue->student->father_email }}
                </address>
            </div>

            <div class="col-xs-4 invoice-col">
                Ibu
                <address>
                    <small>Nama</small> : {{ $issue->student->mother_name }}<br/>
                    <small>Pekerjaan</small> : {{ $issue->student->mother_occupation }}<br/>
                    <small>Alamat</small> : {{ $issue->student->mother_address }} <br/>
                    <small>Kontak</small> : {{ $issue->student->mother_contact }} <br/>
                    <small>Email</small> : {{ $issue->student->mother_email }}
                </address>
            </div>   
        </small>
    </div>

    <div class="row"></div>

    <div class="row">
        <small>
        	<div class="col-xs-5">
        		<table class="table table-condensed">
        			<thead>
                        <tr class="success">
                            <th colspan="2"><center>Jatah Handbook</center></th>
                        </tr>
        				<tr class="warning">
        					<th>Judul Handbook</th>
        					<th>Harga</th>
        				</tr>
        			</thead>
        			<tbody>
        				@foreach($handbooks as $handbook)
        					<tr>
        						<td>{{ $handbook->title }}</td>
        						<td>Rp{{ number_format($handbook->price,2,",",".") }}</td>
        					</tr>
        				@endforeach
        			</tbody>
        		</table>
        	</div>
        	<div class="col-xs-7">
        		<table class="table table-condensed">
        			<thead>
                        <tr class="success">
                            <th colspan="3"><center>Riwayat Pengambilan</center></th>
                        </tr>
        				<tr class="warning">
        					<th>Judul Handbook</th>
        					<th>Tanggal Ambil</th>
        					<th>FO</th>
        				</tr>
        			</thead>
        			<tbody>
        				@foreach($retrievals as $retrieval)
        					<tr>
        						<td>{{ $retrieval->handbook->title }}</td>
        						<td>{{ date('d-m-Y', strtotime($retrieval->retrieval_date)) }}</td>
        						<td>{{ $retrieval->employee->name }}</td>
        					</tr>
        				@endforeach
        			</tbody>
        		</table>
        	</div>
        </small>
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