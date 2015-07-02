@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/css/iCheck/all.css') }}
{{ HTML::style('assets/css/datepicker/datepicker.css') }}

<section class="content-header">
    <h1>
		Denda-denda
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#">Keuangan</a></li>
        <li><a href="{{ URL::to('denda') }}"><i class="active"></i> Denda</a></li>
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
                    <button class="btn btn-warning" onclick="showFormFilter()"><i class="fa fa-filter"></i> Filter Denda</button>
                    <a href="{{ URL::to('denda') }}/create" class="btn btn-danger"><i class="fa fa-plus"></i> Denda Baru</a>
                    
                    <div class="clear-fix"><br/></div>

                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Tanggal Rilis</th>
                                <th>Jumlah Denda</th>
                                <th>Lunas</th>
                                <th width="25%">Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($punishments as $punishment)
                            <tr>
                                <td>
                                    <div class="pull-left image">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $punishment->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $punishment->issue_id }}">
                                            {{ $punishment->issue->issue }} /
                                            {{ $punishment->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>{{ date('d-m-Y', strtotime($punishment->release_date)) }}</td>
                                <td><span class="badge bg-red">Rp{{ number_format($punishment->fines,2,',',',') }}</span></td>
                                <td>
                                	@if($punishment->paid == 1 && $punishment->installment_id > 0)
                                        <span class="badge bg-green">Sudah</span>&nbsp;
                                    @elseif($punishment->paid == 1)
                                		<span class="badge bg-green">Sudah</span>&nbsp;
                                        <a href="#" onclick="unPurchase({{ $punishment->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan Pembayaran"><i class="text-danger fa fa-close"></i></a>
                                	@else
                                		<span class="badge bg-red">Belum</span>&nbsp;
                                        <a href="#" onclick="purchase({{ $punishment->id }})" data-toggle="tooltip" data-placement="top" title="Bayar Sekarang"><i class="text-primary fa fa-money"></i></a>
                                	@endif
                                </td>
                                <td>
                                    <small>
                                        {{ $punishment->comments }}
                                    </small>
                                </td>
                                <td>
                                    <div class="mytooltip">
                                        @if($punishment->paid == 0)
                                            <button class="btn btn-circle btn-danger" onclick="destroy({{ $punishment->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan Denda"><i class="fa fa-trash-o"></i></button>
                                        @endif
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

<!-- Form Filter Installment [modal]
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
<!-- End of Update Installment [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}
{{ HTML::script('assets/js/currency.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();

        $('[name=schedule]').datepicker({format:"yyyy-mm-dd"});
        $('[name=purchase_date]').datepicker({format:"yyyy-mm-dd"});

        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });

        $('[name=month]').val("{{ $curr_month }}");
        $('[name=year]').val("{{ $curr_year }}");

        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        })
    });

    function showFormFilter()
    {
        $('#formFilter').modal('show');
    }

    function filter()
    {
        var curr_month = $('[name=month]').val();
        var curr_year = $('[name=year]').val();

        window.location = "{{ URL::to('denda/filter') }}/"+curr_month+"/"+curr_year;
    }

    function purchase(id)
    {   

        if(confirm("Anda akan menerima Pembayaran Denda?!"))
        {
            $.ajax({
                url:"{{ URL::to('denda') }}/"+id+"/bayar",
                type:"PUT",
                success:function(earning){
                    window.location = "{{ URL::to('penerimaan') }}/"+earning.code;
                }
            });
        }
    }

    function unPurchase(id)
    {   

        if(confirm("Anda akan membatalkan Pembayaran Denda?!"))
        {
            $.ajax({
                url:"{{ URL::to('denda') }}/"+id+"/batal",
                type:"PUT",
                success:function(){
                    window.location = "{{ URL::to('denda') }}";
                }
            });
        }
    }

    function destory(id)
    {
        if(confirm("Yakin akan membatalkan Angsuran?!"))
        {
            $.ajax({
                url:"{{ URL::to('angsuran') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('angsuran') }}";
                }
            });
        }
    }
</script>
@stop