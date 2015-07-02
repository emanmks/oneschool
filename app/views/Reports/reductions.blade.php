@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>Laporan Penggunaan Potongan</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="{{ URL::to('laporan') }}"> Laporan</a></li>
        <li><a href="{{ URL::to('laporan/pemotongan') }}"><i class="active"></i> Penggunaan Potongan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">Potongan {{ $discount->name }}</h2>
                </div>
                <div class="box-body table-responsive">
                    <button class="btn btn-warning" onclick="showFormFilter()"><i class="fa fa-filter"></i> Filter</button>

                    <div class="clear-fix"><br/></div>
                    
                    <table class="table table-bordered table-hover table-condensed" id="data-table">
                        <small>
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $total = 0.00; ?>
                                @foreach($reductions as $reduction)
                                    <tr>
                                        <td>{{ $reduction->receivable->issue->issue }} / {{ $reduction->receivable->issue->student->name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($reduction->receivable->registration->registration_date)) }}</td>
                                        <td>
                                            @foreach($reduction->receivable->issue->placements as $placement)
                                                {{ $placement->course->name }}
                                            @endforeach
                                        </td>
                                    </tr>
                                    @if($reduction->reductable_type == 'Promotion')
                                        @if($reduction->reductable->discount == 0.00)
                                            <?php $total += $reduction->reductable->nominal; ?>
                                        @else 
                                            <?php $total += ($reduction->reductable->discount/100)*4000000; ?>
                                        @endif
                                    @elseif($reduction->reductable_type == 'Voucher')
                                        @if($reduction->reductable->discount == 0.00)
                                            <?php $total += $reduction->reductable->nominal; ?>
                                        @else 
                                            <?php $total += ($reduction->reductable->discount/100)*4000000; ?>
                                        @endif
                                    @elseif($reduction->reductable_type == 'Discount')
                                        <?php $total += $reduction->reductable->nominal; ?>
                                    @elseif($reduction->reductable_type == 'Charge')
                                        <?php $total += $reduction->reductable->nominal; ?>
                                    @endif
                                @endforeach
                            </tbody>
                        </small>
                    </table>

                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>Jumlah Siswa Penerima Potongan</th>
                                <th>Total Potongan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $reductions->count() }}</td>
                                <td>Rp{{ number_format($total,2,",",".") }}</td>
                            </tr>
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
                <h3 id="myModalLabel">Form Filter</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="reductions">Pilih Jenis Potongan</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="reductions" onchange="loadReductions()">
                                <option value="Promotion">Promo</option>
                                <option value="Voucher">Voucher</option>
                                <option value="Discount">Diskon</option>
                                <option value="Charge">Charge</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="discounts">Pilih Nama Potongan</label>
                        <div class="col-lg-7">
                            <select class="form-control" name="discounts">
                                @foreach($discounts as $discount)
                                    <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                                @endforeach
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
        $('.table').dataTable();

        $('[name=reductions]').val("{{ $reductable_type }}");
        $('[name=discounts]').val("{{ $reduction_id }}");
    });

    function showFormFilter()
    {
        $('#formFilter').modal('show');
    }

    function filter()
    {
        var types = $('[name=reductions]').val();
        var id = $('[name=discounts]').val();

        window.location = "{{ URL::to('laporan/pemotongan/filter') }}/"+types+"/"+id;
    }

    function loadReductions()
    {
        var what = $('[name=reductions]').val();

        $.get("{{ URL::to('loadreductions') }}/"+what,function(responses){
            $('[name=discounts]').html('');

            for (var i = responses.length - 1; i >= 0; i--) {
                $('[name=discounts]').append("<option value='"+ responses[i].id +"'>"+ responses[i].name +"</option>");
            };
        },"json");
    }
</script>
@stop