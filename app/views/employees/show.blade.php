@extends('templates/base')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Profile Karyawan
        <small>{{ $employee->name }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Profile</a></li>
        <li><a href="{{ URL::to('karyawan') }}"><i class="active"></i> Karyawan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
            	<div class="box-header">
            		<h2 class="box-title">
            			Profile Karyawan : {{ $employee->name }}
            		</h2>
            	</div>
                <div class="box-body">
                    <div class="nav-tabs-costum">
                        <ul class="nav nav-tabs">
                            <li>
                            	<a href="#profile" data-toggle="tab"><strong>
                            		<i class="fa fa-user"></i> Biodata</strong>
                            	</a>
                            </li>
                            <li>
                            	<a href="#registration" data-toggle="tab"><strong>
                            		<i class="fa fa-files"></i> Penerimaan Siswa</strong>
                            	</a>
                            </li>
                            <li>
                            	<a href="#earning" data-toggle="tab"><strong>
                            		<i class="fa fa-tags"></i> Penerimaan Pembayaran</strong>
                            	</a>
                            </li>
                            <li>
                            	<a href="#handbook" data-toggle="tab"><strong>
                            		<i class="fa fa-handbook"></i> Penyerahan Handbook</strong>
                            	</a>
                            </li>
                            <li>
                            	<a href="#timeline" data-toggle="tab"><strong>
                            		<i class="fa fa-twitter"></i> Timeline</strong>
                            	</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="profile">
                                <div class="clear-fix"><br/></div>
                                
                                <div class="row">
                                	<div class="col-xs-12">
	                                	<div class="list-group">
	                                		<a href="#" class="list-group-item">
	                                			<i class="fa fa-barcode"></i>   <strong>{{ $employee->employee_id }}</strong>
	                                			<span class="pull-right text-muted small">ID Pegawai</span>
	                                		</a>
	                                		<a href="#" class="list-group-item">
	                                			<i class="fa fa-barcode"></i>   <strong>{{ $employee->code }}</strong>
	                                			<span class="pull-right text-muted small">Kode Tentor</span>
	                                		</a>
	                                		<a href="#" class="list-group-item">
	                                			<i class="fa fa-user"></i>   <strong>{{ $employee->name }}</strong>
	                                			<span class="pull-right text-muted small">Nama Lengkap</span>
	                                		</a>
	                                		<a href="#" class="list-group-item">
	                                			<i class="fa fa-phone"></i>   <strong>{{ $employee->contact }}</strong>
	                                			<span class="pull-right text-muted small">Kontak</span>
	                                		</a>
	                                		<a href="#" class="list-group-item">
	                                			<i class="fa fa-money"></i>   <strong>{{ number_format($employee->basic_salary,2,",",".") }}</strong>
	                                			<span class="pull-right text-muted small">Gaji Pokok</span>
	                                		</a>
	                                		<a href="#" class="list-group-item">
	                                			<i class="fa fa-money"></i>   <strong>{{ number_format($employee->teach_salary,2,",",".") }}</strong>
	                                			<span class="pull-right text-muted small">Gaji Mengajar per Jam</span>
	                                		</a>
	                                	</div>
	                                </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="registration">
                                <div class="clear-fix"><br/></div>
                                
                                <div class="row">
                                	<div class="col-xs-12">
	                                	<h3 class="page-header">Riwayat Penerimaan Pendaftaran</h3>
	                                	<table class="table table-striped">
	                                		<thead>
	                                			<tr>
	                                				<th>Jenis Pendaftaran</th>
	                                				<th>Tanggal Daftar</th>
                                                    <th>Siswa</th>
	                                				<th>Biaya PDF</th>
	                                				<th>Biaya Bimbingan</th>
	                                			</tr>
	                                		</thead>

	                                		<tbody>
	                                			@foreach($registrations as $registration)
	                                			<tr>
	                                				<td>{{ $registration->classification->name }}</td>
	                                				<td>{{ date('d-m-Y', strtotime($registration->registration_date)) }}</td>
                                                    <td>{{ $registration->student->name }}</td>
	                                				<td><span class="badge bg-blue">Rp{{ number_format($registration->registration_cost,2,",",".") }}</span></td>
                                                    <td><span class="badge bg-green">Rp{{ number_format($registration->receivable->total,2,",",".") }}</span></td>
	                                			</tr>
	                                			@endforeach
	                                		</tbody>
	                                	</table>
	                                </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="earning">
                                <div class="clear-fix"><br/></div>
                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h3 class="page-header">Riwayat Penerimaan Pembayaran</h3>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Siswa</th>
                                                    <th>Tanggal</th>
                                                    <th>Jenis Penerimaan</th>
                                                    <th>Kode Pembayaran</th>
                                                    <th>Nilai Pembayaran</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($earnings as $earning)
                                                <tr>
                                                    <td>{{ $earning->student->name }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($earning->earning_date)) }}</td>
                                                    <td>{{ $earning->earnable->name }}</td>
                                                    <td>{{ $earning->code }}</td>
                                                    <td>{{ number_format($earning->payment,",",".") }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="handbook">
                                <div class="clear-fix"><br/></div>
                                
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h3 class="page-header">Riwayat Penyerahan Handbook</h3>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Siswa</th>
                                                    <th>Tanggal Penyerahan</th>
                                                    <th>Judul Handbook</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($retrievals as $retrieval)
                                                <tr>
                                                    <td>{{ $retrieval->student->name }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($earning->retrieval_date)) }}</td>
                                                    <td>{{ $retrieval->handbook->title }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="timeline">
                                <div class="clear-fix"><br/></div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="timeline">
                                            @foreach($timelines as $timeline)
                                            <li>
                                                <i class="fa fa-comment bg-blue"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y H:i:s', strtotime($timeline->created_at)) }}</span>
                                                    <h3 class="timeline-header"><a href="#">{{ $timeline->informable->name }}</a></h3>
                                                    <div class="timeline-body">
                                                        {{ $timeline->content }}
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{ HTML::script('assets/js/plugins/jqueryKnob/jquery.knob.js') }}

<script type="text/javascript">
    $(function(){
        $('.knob').knob();
        $('#onProgress').hide();
    })
</script>
@stop