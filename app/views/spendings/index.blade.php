@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Pengeluaran Keuangan
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('pengeluaran') }}"><i class="active"></i> Pengeluaran</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
           @if(Session::has('message'))
            <div class="alert alert-info alert-dismissable">
                <i class="fa fa-warning"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('message') }}
            </div>
            @endif

            <div class="box">
                <div class="box-body table-responsive">
                    <button class="btn btn-warning" onclick="showFormFilter()"><i class="fa fa-filter"></i> Filter Pengeluaran</button>
                    <a href="{{ URL::to('pengeluaran') }}/create" class="btn btn-success"><i class="fa fa-plus"></i> Tambahkan Pengeluaran</a>
                    <div class="clear-fix"><br/></div>

                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Diterima/Digunakan Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($spendings as $spending)
                            <tr>
                            	<td>
                            		<div class="mytooltip">
                                        <a href="{{ URL::to('pengeluaran') }}/{{ $spending->id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Lihat Detail">{{ $spending->code }}</a>
                                    </div>
                            	</td>
                            	<td>
                            		@if($spending->spendable_type == 'Payroll')
                            			Pembayaran Gaji Periode {{ $spending->spendable->payroll_month }} - {{ $spending->spendable->payroll_year }}
                            		@else
                            			{{ $spending->spendable->name }}
                            		@endif
                            	</td>
                                <td>{{ date('d-m-Y', strtotime($spending->spend_date)) }}</td>
                                <td><span class="badge bg-blue">Rp{{ number_format($spending->total,2,',',',') }}</span></td>
                                <td>{{ $spending->employee->name }}</td>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('pengeluaran') }}/{{ $spending->id }}/edit" class="btn btn-circle btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Koreksi"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-circle btn-danger" onclick="destroy({{ $spending->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan!!!"><i class="fa fa-trash-o"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Filter Spendings [modal]
===================================== -->
<div id="formFilter" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Filter Pengeluaran</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="month">Bulan</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="month">
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">Nopember</option>
                                <option value="12">Desember</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="total">Tahun</label>
                        <div class="col-lg-3">
                            <select class="form-control" name="year">
                                <option value="{{ date('Y',strtotime(Auth::user()->curr_project->start_date)) }}">{{ date('Y',strtotime(Auth::user()->curr_project->start_date)) }}</option>
                                <option value="{{ date('Y',strtotime(Auth::user()->curr_project->end_date)) }}">{{ date('Y',strtotime(Auth::user()->curr_project->end_date)) }}</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onClick="filter()" data-dismiss="modal" aria-hidden="true">Filter</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Form Filter Earnings [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();

        $('[name=month]').val("{{ $curr_month }}");
        $('[name=year]').val("{{ $curr_year }}");
    });

    function showFormFilter()
    {
        $('#formFilter').modal('show');
    }

    function filter()
    {
        var curr_month = $('[name=month]').val();
        var curr_year = $('[name=year]').val();

        window.location = "{{ URL::to('pengeluaran/filter') }}/"+curr_month+"/"+curr_year;
    }

    function destroy(id)
    {
        if(confirm("Yakin akan membatalkan pengeluaran?!"))
        {
            $.ajax({
                url:"{{ URL::to('pengeluaran') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('pengeluaran') }}";
                }
            });
        }
    }
</script>
@stop