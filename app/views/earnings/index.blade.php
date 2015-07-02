@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Penerimaan Keuangan
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('penerimaan') }}"><i class="active"></i> Penerimaan</a></li>
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
                    <button class="btn btn-warning" onclick="showFormFilter()"><i class="fa fa-filter"></i> Filter Penerimaan</button>
                    <button class="btn btn-success" onclick="showFormBeforeCreate()"><i class="fa fa-plus"></i> Terima Pembayaran</button>
                    <div class="clear-fix"><br/></div>

                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Nomor Kwitansi</th>
                                <th>Siswa</th>
                                <th>Tgl Terima</th>
                                <th>Front Office</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($earnings as $earning)
                            <tr>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('penerimaan') }}/{{ $earning->code }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Lihat Kwitansi"><i class="fa fa-files-o"></i> {{ $earning->code }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="pull-left image">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $earning->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $earning->issue_id }}" data-toggle="tooltip" data-placement="top" title="Klik untuk Lihat Profile">
                                            {{ $earning->issue->issue }} /
                                            {{ $earning->issue->student->name }}
                                        </a>
                                    </div>
                                </td>
                                <td>{{ date('d-m-Y', strtotime($earning->earning_date)) }}</td>
                                <td>{{ $earning->employee->name }}</td>
                                <td>
                                    <div class="mytooltip">
                                        <!--<a href="{{ URL::to('penerimaan') }}/{{ $earning->id }}/edit" class="btn btn-circle btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Koreksi"><i class="fa fa-edit"></i></a>-->
                                        <button class="btn btn-circle btn-danger" onclick="destroy({{ $earning->code }})" data-toggle="tooltip" data-placement="top" title="Batalkan!!!"><i class="fa fa-trash-o"></i></button>
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

<!-- Form Create Earnings [modal]
===================================== -->
<div id="formBeforeCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Terima Pembayaran</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="students">Cari Siswa</label>
                        <div class="col-lg-8">
                           <input type="text" name="students" class="form-control" data-provide="typeahead" placeholder="Ketikkan Nomor Pokok">
                           <input type="hidden" name="issue" value="0">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onClick="showFormCreate()" data-dismiss="modal" aria-hidden="true">Pilih!!!</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Form Create Earnings [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/typeahead/bootstrap-typeahead.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();

        $('[name=month]').val("{{ $curr_month }}");
        $('[name=year]').val("{{ $curr_year }}");

        $('[name=students]').typeahead({
            source : function(query, process){
                return $.get("{{ URL::to('softfilterstudents') }}/"+query, function(response){
                    //response = $.parseJSON(response);
                    var sourceArr = []; 
                    for(var i = 0; i < response.length; i++)
                    {
                        sourceArr.push(
                            response[i].id +"#"+ response[i].issue +"#"+ response[i].student_id +"#"+ response[i].student.name
                            );
                    }
                    return process(sourceArr);
                })
            },
            highlighter : function(item){
                var student = item.split('#');
                var item = ''
                        + "<div class='typeahead_wrapper'>"
                        + "<span class='typeahead_photo fa fa-2x fa-user'></span>"
                        + "<div class='typeahead_labels'>"
                        + "<div class='typeahead_primary'>" + student[1] + "</div>"
                        + "<div class='typeahead_secondary'>" + student[3] + "</div>"
                        + "</div>"
                        + "</div>";
                return item;
            },
            updater : function(item){
                var student = item.split('#');
                $('[name=issue]').val(student[0]);
                return student[1]+ ' / ' +student[3];
            }
        });
    });

    function showFormFilter()
    {
        $('#formFilter').modal('show');
    }

    function showFormBeforeCreate()
    {
        $('#formBeforeCreate').modal('show');
    }

    function showFormCreate()
    {
        var issue = $('[name=issue]').val();
        if(issue != '0')
        {
            window.location = "{{ URL::to('penerimaan') }}/"+issue+"/create";
        }
    }

    function filter()
    {
        var curr_month = $('[name=month]').val();
        var curr_year = $('[name=year]').val();

        window.location = "{{ URL::to('penerimaan/filter') }}/"+curr_month+"/"+curr_year;
    }

    function destroy(code)
    {
        if(confirm("Yakin akan membatalkan penerimaan?!"))
        {
            $.ajax({
                url:"{{ URL::to('penerimaan') }}/"+code,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('penerimaan') }}";
                }
            });
        }
    }
</script>
@stop