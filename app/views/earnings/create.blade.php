@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/chosen/chosen.css') }}

<section class="content-header">
    <h1>
        Penerimaan Pembayaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('perpindahan') }}"><i class="active"></i> Penerimaan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">Form Penerimaan</h2>
                </div>
                <div class="box-body table-responsive">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="earning_date">Tanggal Terima</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="earning_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="students">Siswa</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="students" value="{{ $issue->issue }} / {{ $issue->student->name }}" disabled>
                                <input type="hidden" name="student" value="{{ $issue->id }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="registrations">Biaya Pendaftaran</label>
                            <div class="col-lg-5">
                                <select class="chzn-select form-control" name="registrations" multiple>
                                    <option value="0">--Pilih Sumber Penerimaan</option>
                                    @if(!empty($registration))
                                        <option value="{{ $registration->id }}#{{ $registration->registration_cost }}">
                                            Biaya Pendaftaran Senilai Rp{{ number_format($registration->registration_cost,2,",",".") }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="receivables">Sisa Biaya Bimbingan (untuk Siswa Lunas)</label>
                            <div class="col-lg-5">
                                <select class="chzn-select form-control" name="receivables" multiple>
                                    <option value="0">--Pilih Sumber Penerimaan</option>
                                    @if($receivable->payment == 'Cash')
                                        <option value="{{ $receivable->id }}#{{ $receivable->balance }}">
                                            Sisa Biaya Bimbingan : Rp{{ number_format($receivable->balance,2,",",".") }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="installments">Angsuran</label>
                            <div class="col-lg-5">
                                <select class="chzn-select form-control" name="installments" multiple>
                                    <option value="0">--Pilih Sumber Penerimaan</option>
                                    @if($receivable->installments->count() > 0)
                                        @foreach($receivable->installments as $installment)
                                            <option value="{{ $installment->id }}#{{ $installment->balance }}">Angsuran Jatuh Tempo {{ date('d-m-Y', strtotime($installment->schedule)) }} Nilai Rp{{ number_format($installment->balance,2,",",".")  }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="movements">Biaya Pindah Kelas</label>
                            <div class="col-lg-5">
                                <select class="chzn-select form-control" name="movements" multiple>
                                    <option value="0">--Pilih Sumber Penerimaan</option>
                                    @foreach($movements as $movement)
                                        <option value="{{ $movement->id }}#{{ $movement->movement_costs }}#{{ $movement->upgrade_costs }}">Biaya Pindah Kelas : Rp{{ number_format($movement->movement_costs,2,",",".") }}, Upgrade Kelas : Rp{{ number_format($movement->upgrade_costs,2,",",".") }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="punishments">Denda - Denda</label>
                            <div class="col-lg-5">
                                <select class="chzn-select form-control" name="punishments" multiple>
                                    <option value="0">--Pilih Sumber Penerimaan</option>
                                    @foreach($punishments as $punishment)
                                        <option value="{{ $punishment->id }}#{{ $punishment->fines }}">Denda Senilai Rp{{ number_format($punishment->fines,2,",",".") }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="resigns">Denda/Biaya Penonaktifan</label>
                            <div class="col-lg-5">
                                <select class="chzn-select form-control" name="resigns" multiple>
                                    <option value="0">--Pilih Sumber Penerimaan</option>
                                    @foreach($resigns as $resign)
                                        <option value="{{ $resign->id }}#{{ $resign->fines }}">Biaya Penonaktifan Rp{{ number_format($resign->fines,2,",",".") }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="employees">Diterima Oleh</label>
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
                            <label class="col-xs-3 control-label" for="total">Total Pembayaran</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" value="0" name="total" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <label class="col-xs-3 control-label" for="submit"></label>
                        <div class="col-lg-3">
                            <button class="btn btn-success" onclick="create()"><i class="fa fa-money"></i> Terima Pembayaran!</button>
                        </div>
                    </div>
                    <br/><br/>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Page-Level Plugin Scripts -->
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/chosen/chosen.jquery.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('[name=earning_date]').datepicker({format:'yyyy-mm-dd',autoclose:true});
        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });

        $(".chzn-select").chosen();

        $('[name=receivables]').chosen().change(function(){
            updateTotal();
        });

        $('[name=installments]').chosen().change(function(){
            updateTotal();
        });

        $('[name=registrations]').chosen().change(function(){
            updateTotal();
        });

        $('[name=movements]').chosen().change(function(){
            updateTotal();
        });

        $('[name=punishments]').chosen().change(function(){
            updateTotal();
        });

        $('[name=resigns]').chosen().change(function(){
            updateTotal();
        });
    });

    function updateTotal()
    {
        var total = 0.00;

        var receivables = $('[name=receivables]').val();
        var installments = $('[name=installments]').val();
        var registrations = $('[name=registrations]').val();
        var movements = $('[name=movements]').val();
        var punishments = $('[name=punishments]').val();
        var resigns = $('[name=resigns]').val();

        if(receivables)
        {
            for (var i = receivables.length - 1; i >= 0; i--) {
                var val = '';

                val = receivables[i];

                val = val.split("#");
                
                total += parseFloat(val[1]);
            };
        }

        if(installments)
        {
            for (var i = installments.length - 1; i >= 0; i--) {
                var val = '';

                val = installments[i];

                val = val.split("#");
                
                total += parseFloat(val[1]);
            };
        }

        if(registrations)
        {
            for (var i = registrations.length - 1; i >= 0; i--) {
                var val = '';

                val = registrations[i];

                val = val.split("#");
                
                total += parseFloat(val[1]);
            };
        }

        if(movements)
        {
            for (var i = movements.length - 1; i >= 0; i--) {
                var val = '';

                val = movements[i];

                val = val.split("#");
                
                total += parseFloat(val[1]) + parseFloat(val[2]);
            };
        }

        if(punishments)
        {
            for (var i = punishments.length - 1; i >= 0; i--) {
                var val = '';

                val = punishments[i];

                val = val.split("#");
                
                total += parseFloat(val[1]);
            };
        }

        if(resigns)
        {
            for (var i = resigns.length - 1; i >= 0; i--) {
                var val = '';

                val = resigns[i];

                val = val.split("#");
                
                total += parseFloat(val[1]);
            };
        }

        $('[name=total]').val(total);
    }

    function create()
    {
        var issue_id = $('[name=student]').val();
        var receivables = $('[name=receivables]').val();
        var installments = $('[name=installments]').val();
        var registrations = $('[name=registrations]').val();
        var movements = $('[name=movements]').val();
        var punishments = $('[name=punishments]').val();
        var resigns = $('[name=resigns]').val();
        var earning_date = $('[name=earning_date]').val();
        var employee_id = $('[name=employees]').val();

        if(issue_id != '0' &&  employee_id != '0' && (receivables != '0' || registrations != '0' || installments != '0' || movements != '' || punishments != '' || resigns != '0'))
        {
            $.ajax({
                url:"{{ URL::to('penerimaan') }}",
                type:"POST",
                data:{issue_id:issue_id, receivables:receivables, installments:installments, registrations:registrations,
                    movements:movements, punishments:punishments, resigns:resigns, earning_date:earning_date, employee_id:employee_id},
                success:function(response){
                    if(response.status == 'succeed'){
                        window.location = "{{ URL::to('penerimaan') }}/"+response.code;
                    }else{
                        window.alert("Gagal menginput penerimaan!");
                    }
                }
            });
        }   
        else
        {
            window.alert('Mohon lengkapi data anda!');
        }
    }
</script>
@stop