@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Payroll
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kepegawaian</a></li>
        <li><a href="{{ URL::to('payroll') }}"><i class="active"></i> Payroll</a></li>
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
                    <button class="btn btn-warning" onclick="showFormFilter()"><i class="fa fa-filter"></i> Filter</button>
                    <button class="btn btn-success" onclick="showFormGenerate()"><i class="fa fa-plus"></i> Payroll Baru</button>
                    <div class="clear-fix"><br/></div>

                    <table class="table table-bordered table-hover table-condensed" id="data-table">
                        <thead>
                            <tr>
                                <th>Pegawai</th>
                                <th>Tanggal Penerimaan</th>
                                <th>Total Income</th>
                                <th>Total Deduction</th>
                                <th>Take Home Salary</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($payrolls as $payroll)
                            <tr>
                            	<td>{{ $payroll->employee->name }}</td>
                                <td>{{ date('d-m-Y', strtotime($payroll->release_date)) }}</td>
                                <td><span class="badge bg-blue">Rp{{ number_format($payroll->incomes,2,',','.') }}</span></td>
                                <td><span class="badge bg-blue">Rp{{ number_format($payroll->deductions,2,',','.') }}</span></td>
                                <td><span class="badge bg-blue">Rp{{ number_format($payroll->salary,2,',','.') }}</span></td>
                                <td>
                                    <div class="mytooltip">
                                        @if($payroll->taken == 0)
                                            <a href="#" onclick="withdraw({{ $payroll->id }})" data-toggle="tooltip" data-placement="top" title="Klik untuk Pencairan"><i class="text-warning fa fa-money"></i></a>
                                            &nbsp;
                                        @endif
                                        @if($payroll->taken == 1)
                                            <a href="{{ URL::to('payroll') }}/{{ $payroll->id }}" data-toggle="tooltip" data-placement="top" title="Cetak Slip Gaji"><i class="text-warning fa fa-print"></i></a>
                                            &nbsp;
                                        @endif
                                        <!--<a href="{{ URL::to('payroll') }}/{{ $payroll->id }}/edit" data-toggle="tooltip" data-placement="top" title="Klik untuk Koreksi"><i class="fa fa-edit"></i></a>
                                        &nbsp;-->
                                        <a href="#" onclick="destroy({{ $payroll->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan!!!"><i class="text-danger fa fa-trash-o"></i></a>
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

<!-- Form Generate Payroll [modal]
===================================== -->
<div id="formGenerate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Buat Payroll</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                	<div class="form-group">
                        <label class="col-lg-3 control-label" for="employees">Diberikan Kepada</label>
                            <div class="col-lg-8">
                                <input type="text" name="employees" class="form-control" data-provide="typeahead" placeholder="Ketikkan Nama">
                                <input type="hidden" name="employee" value="0">
                            </div>
                    </div>
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
                <button class="btn btn-primary" onClick="generate()" data-dismiss="modal" aria-hidden="true">Pilih</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Form Filter payroll [modal] -->

<!-- Form Filter payroll [modal]
===================================== -->
<div id="formFilter" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Filter</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="filter_month">Bulan</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="filter_month">
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
                        <label class="col-lg-3 control-label" for="filter_year">Tahun</label>
                        <div class="col-lg-3">
                            <select class="form-control" name="filter_year">
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
<!-- End of Form Filter payroll [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/typeahead/bootstrap-typeahead.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();

        $('[name=month]').val("{{ $curr_month }}");
        $('[name=year]').val("{{ $curr_year }}");

        $('[name=filter_month]').val("{{ $curr_month }}");
        $('[name=filter_year]').val("{{ $curr_year }}");

       	$('input[name=employees]').typeahead({
            source : function(query, process){
                return $.get("{{ URL::to('suggestemployee') }}/"+query, function(response){
                    response = $.parseJSON(response);
                    var sourceArr = []; 
                    for(var i = 0; i < response.length; i++)
                    {
                        sourceArr.push(response[i].id +"#"+ response[i].employee_id +"#"+ response[i].code +"#"+ response[i].name);
                    }
                    return process(sourceArr);
                })
            },
            highlighter : function(item){
                var employee = item.split('#');
                var item = ''
                        + "<div class='typeahead_wrapper'>"
                        + "<span class='typeahead_photo fa fa-2x fa-user'></span>"
                        + "<div class='typeahead_labels'>"
                        + "<div class='typeahead_primary'>" + employee[3] + "</div>"
                        + "<div class='typeahead_secondary'>ID: "+ employee[1] +" - Kode: "+ employee[2] +"</div>"
                        + "</div>"
                        + "</div>";
                return item;
            },
            updater : function(item){
                var employee = item.split('#');
                $('input[name=employee]').val(employee[0]);
                return "ID: "+employee[1]+" Kode: "+employee[2]+" Nama: "+employee[3];
            }
        });
    });

    function showFormFilter()
    {
        $('#formFilter').modal('show');
    }

    function filter()
    {
        var curr_month = $('[name=filter_month]').val();
        var curr_year = $('[name=filter_year]').val();

        window.location = "{{ URL::to('payroll/filter') }}/"+curr_month+"/"+curr_year;
    }

    function showFormGenerate()
    {
    	$('#formGenerate').modal('show');
    }

    function generate()
    {
    	var employee_id = $('[name=employee]').val();
    	var curr_month = $('[name=month]').val();
        var curr_year = $('[name=year]').val();

        window.location = "{{ URL::to('payroll/create') }}/"+employee_id+"/"+curr_month+"/"+curr_year;
    }

    function withdraw(id)
    {
        if(confirm("Yakin akan mencairkan Salary?!"))
        {
            $.ajax({
                url:"{{ URL::to('payroll') }}/cairkan/"+id,
                type:"PUT",
                success:function(){
                    window.location = "{{ URL::to('payroll') }}/"+id;
                }
            });
        }
    }

    function destroy(id)
    {
        if(confirm("Yakin akan membatalkan Payroll ini?!"))
        {
            $.ajax({
                url:"{{ URL::to('payroll') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('payroll') }}";
                }
            });
        }
    }
</script>
@stop