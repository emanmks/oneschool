@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Laporan Pemasukan
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Laporan</a></li>
        <li><a href="{{ URL::to('laporan/penerimaan') }}"><i class="active"></i> Penerimaan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <button class="btn btn-warning" onclick="showFormFilter()"><i class="fa fa-filter"></i> Filter Penerimaan</button>
                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-condensed" id="data-table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Siswa</th>
                                <th>Tgl Terima</th>
                                <th>Pos Penerimaan</th>
                                <th>Jumlah</th>
                                <th>Front Office</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($earnings as $earning)
                            <tr>
                                <td>{{ $earning->code }}</td>
                                <td>{{ $earning->issue->issue }} / {{ $earning->issue->student->name }}</td>
                                <td>{{ date('d-m-Y', strtotime($earning->earning_date)) }}</td>
                                <td>
                                	@if($earning->earnable_type == 'Receivable')
                                		Biaya Bimbingan
                                	@elseif($earning->earnable_type == 'Installment')
                                		Angsuran
                                	@elseif($earning->earnable_type == 'Registration')
                                		Biaya PDF
                                	@elseif($earning->earnable_type == 'Movement')
                                		Biaya Pindah Kelas
                                	@elseif($earning->earnable_type == 'Punishment')
                                        Denda
                                    @elseif($earning->earnable_type == 'Resign')
                                		Biaya Penonaktifan
                                	@else
                                		Tidak Diketahui
                                	@endif
                                </td>
                                <td>Rp{{ number_format($earning->payment,2,',',',') }}</td>
                                <td>{{ $earning->employee->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Filter Earnings [modal]
===================================== -->
<div id="formFilter" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Filter Angsuran</h3>
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

        window.location = "{{ URL::to('laporan/penerimaan/filter') }}/"+curr_month+"/"+curr_year;
    }
</script>
@stop