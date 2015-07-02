@extends('templates/base')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        OneSchool Dashboard
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Dashboard</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
		<div class="col-lg-12">
			<div class="box box-success">
				<div class="box-header">
					<h3 class="box-title">Statistik Siswa Aktif</h3>
				</div>

				<div class="box-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<td>Siswa Hingga Bulan Lalu</td>
								<td>Pendaftar Baru Bulan Ini</td>
								<td>Siswa Pindahan</td>
								<td>Siswa Keluar</td>
								<td>Siswa DO</td>
								<td>Siswa Pindah Ke Cabang Lain</td>
								<td>Total Siswa Aktif</td>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td><span class="badge bg-green">{{ $last_month_registrations }}</span></td>
								<td><span class="badge bg-blue">{{ $curr_month_registrations }}</span></td>
								<td><span class="badge bg-blue">{{ $movement_registrations }}</span></td>
								<td><span class="badge bg-red">{{ $curr_resign_students }}</span></td>
								<td><span class="badge bg-red">{{ $curr_do_students }}</span></td>
								<td><span class="badge bg-red">{{ $curr_relocate_students }}</span></td>
								<td><span class="badge bg-green">{{ $curr_active_students }}</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="box box-default">
				<div class="box-header">
					<h3 class="box-title">Statistik Kelas</h3>
				</div>
				<div class="box-body">
					<strong class="text-danger">Temporarily Unavailable</strong>
					<!--
					
					-->
				</div>
			</div>
		</div>
	</div>

</section><!-- /.content -->

{{ HTML::script('assets/js/plugins/jqueryKnob/jquery.knob.js') }}

<script type="text/javascript">
    $(function(){
        $('.knob').knob();
        $('#onProgress').hide();
    })

    function changeCase()
    {
    	$('#onProgress').show();
    	
    	$.ajax({
            url:"{{ URL::to('change') }}",
            type:'GET',
            success:function(){
                window.location = "{{ URL::to('/') }}";
            }
        });
    }
</script>
@stop