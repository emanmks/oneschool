@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Laporan
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="{{ URL::to('laporan') }}"> Laporan</a></li>
        <li><a href="{{ URL::to('laporan/siswa-per-kelas') }}"><i class="active"></i> Siswa per Sekolah</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="box-title">Siswa asal Sekolah {{ $school->name }}</h2>
                </div>
                <div class="box-body table-responsive">
                    <button class="btn btn-warning" onclick="showFormFilter()"><i class="fa fa-filter"></i> Filter</button>

                    <div class="clear-fix"><br/></div>
                    
                    <table class="table table-bordered table-hover table-condensed" id="data-table">
                        <small>
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Tgl Lahir</th>
                                    <th>Ayah</th>
                                    <th>Ibu</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($educations as $education)
                                    <tr>
                                        <td>{{ $education->issue->issue }} / {{ $education->issue->student->name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($education->issue->student->birthdate)) }}</td>
                                        <td>{{ $education->issue->student->father_name }}</td>
                                        <td>{{ $education->issue->student->mother_name }}</td>
                                        <td>{{ $education->issue->student->address }}</td>
                                        <td>{{ $education->issue->student->contact }}</td>
                                        <td>{{ $education->issue->student->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </small>
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
                        <label class="col-lg-3 control-label" for="schools">Sekolah</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="schools" data-provide="typeahead" placeholder="Cari Sekolah" autocomplete="off">
                            <input type="hidden" value="0" name="school">
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
{{ HTML::script('assets/js/plugins/typeahead/bootstrap-typeahead.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('.table').dataTable();
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('input[name=schools]').typeahead({
            source : function(query, process){
                return $.get("{{ URL::to('loadschools') }}/"+query, function(response){
                    response = $.parseJSON(response);
                    var sourceArr = []; 
                    for(var i = 0; i < response.length; i++)
                    {
                        sourceArr.push(response[i].id +"#"+ response[i].name +"#"+ response[i].address);
                    }
                    return process(sourceArr);
                })
            },
            highlighter : function(item){
                var school = item.split('#');
                var item = ''
                        + "<div class='typeahead_wrapper'>"
                        + "<span class='typeahead_photo fa fa-2x fa-home'></span>"
                        + "<div class='typeahead_labels'>"
                        + "<div class='typeahead_primary'>" + school[1] + "</div>"
                        + "<div class='typeahead_secondary'>" + school[2] + "</div>"
                        + "</div>"
                        + "</div>";
                return item;
            },
            updater : function(item){
                var school = item.split('#');
                $('[name=school]').val(school[0]);
                return school[1];
            }
        });
    });

    function showFormFilter()
    {
        $('#formFilter').modal('show');
    }

    function filter()
    {
        var school_id = $('[name=school]').val();

        window.location = "{{ URL::to('laporan/siswa-per-sekolah/filter') }}/"+school_id;
    }
</script>
@stop