@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/css/iCheck/all.css') }}
{{ HTML::style('assets/css/datepicker/datepicker.css') }}

<section class="content-header">
    <h1>
        Angsuran Bulan Ini
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#">Keuangan</a></li>
        <li><a href="{{ URL::to('angsuran') }}"><i class="active"></i> Angsuran</a></li>
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
                    <button class="btn btn-warning" onclick="showFormFilter()"><i class="fa fa-filter"></i> Filter Angsuran</button>
                    
                    <div class="clear-fix"><br/></div>

                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Jadwal Angsuran</th>
                                <th>Jumlah Angsuran</th>
                                <th>Sisa Angsuran</th>
                                <th>Lunas</th>
                                <th>Bayar</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($installments as $installment)
                            <tr>
                                <td>
                                    <div class="pull-left image">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $installment->receivable->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $installment->receivable->issue_id }}">
                                            {{ $installment->receivable->issue->issue }} /
                                            {{ $installment->receivable->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>{{ date('d-m-Y', strtotime($installment->schedule)) }}</td>
                                <td><span class="badge bg-blue">Rp{{ number_format($installment->total,2,',',',') }}</span></td>
                                <td><span class="badge bg-green">Rp{{ number_format($installment->balance,2,',',',') }}</span></td>
                                <td>
                                	@if($installment->paid == 1)
                                		<span class="badge bg-green">Sudah</span>
                                	@else
                                		<span class="badge bg-red">Belum</span>
                                	@endif
                                </td>
                                <td>
                                    <input type="hidden" id="installment_id" value="{{ $installment->id }}">
                                    <input type="hidden" id="schedule-{{ $installment->id }}" value="{{ $installment->schedule }}">
                                    <input type="hidden" id="total-{{ $installment->id }}" value="{{ number_format($installment->total,2,',',',') }}">
                                    <input type="hidden" id="balance-{{ $installment->id }}" value="{{ number_format($installment->balance,2,',',',') }}">
                                    <input type="hidden" id="paid-{{ $installment->id }}" value="{{ $installment->paid }}">
                                    <div class="mytooltip">
                                        @if($installment->paid == 0)
                                            <button class="btn btn-circle btn-success" onclick="showFormPurchase({{ $installment->id }})" data-toggle="tooltip" data-placement="top" title="Bayar Sekarang!"><i class="fa fa-money"></i></button>
                                        @endif
                                        <!--<button class="btn btn-circle btn-danger" onclick="destroy({{ $installment->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan!!!"><i class="fa fa-trash-o"></i></button>-->
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
<!-- End of Form Filter Installment [modal] -->

<!-- Form Purchase [modal]
===================================== -->
<div id="formPurchase" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Terima Angsuran</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="purchase_date">Tanggal Terima</label>
                        <div class="col-lg-3">
                            <input type="hidden" name="installmentid" value="0">
                            <input type="text" class="form-control" name="purchase_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="employees">Diterima Oleh</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="employees">
                                <option value="0">--Pilih Pegawai</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="payment">Jumlah Pembayaran</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control currency" name="payment" value="{{ number_format(0,2,",",".") }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="fines">Denda</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control currency" name="fines" value="{{ number_format(0,2,",",".") }}">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onClick="purchase()" data-dismiss="modal" aria-hidden="true">Bayar!</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Purchase [modal] -->

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

        $('#paid').on("ifClicked", function(){
            if(!this.checked){
                $('#paid_status').html('Lunas');
            }else{
                $('#paid_status').html('Belum Lunas');
            }
        });

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

        window.location = "{{ URL::to('angsuran/filter') }}/"+curr_month+"/"+curr_year;
    }

    function showFormPurchase(id)
    {
        $('#formPurchase').modal('show');

        $('[name=installmentid]').val(id);
    }

    function purchase()
    {
        var id = $('[name=installmentid]').val();
        var earning_date = $('[name=purchase_date]').val();
        var employee_id = $('[name=employees]').val();
        var payment = $('[name=payment]').val();
        var fines = $('[name=fines]').val();

        if(employee_id != '0' && earning_date != '')
        {
            $.ajax({
                url:"{{ URL::to('angsuran') }}/"+id+"/bayar",
                type:"PUT",
                data:{earning_date:earning_date, employee_id:employee_id, payment:payment, fines:fines},
                success:function(e){
                    window.location = "{{ URL::to('penerimaan') }}/"+e.earning;
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