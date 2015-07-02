@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Pindah Kelas
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kesiswaan</a></li>
        <li><a href="{{ URL::to('perpindahan') }}"><i class="active"></i> Perpindahan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
           @if(Session::has('message'))
            <div class="alert alert-info alert-dismissable">
                <i class="fa fa-warning"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('message') }}
            </div>
            @endif

            <div class="box">
                <div class="box-body table-responsive">
                    <a href="{{ URL::to('perpindahan') }}/create" class="btn btn-primary"><i class="fa fa-plus"></i> Pindah Kelas</a>
                    <div class="clear-fix"><br/></div>
                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Tgl Proses</th>
                                <th>Perpindahan</th>
                                <th>Biaya</th>
                                <th>Upgrade</th>
                                <th>Diproses Oleh</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($movements as $movement)
                            <tr>
                                <td>
                                    <div class="pull-left image">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $movement->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $movement->issue->id }}">{{ $movement->issue->issue }} /
                                        {{ $movement->issue->student->name }}</a>
                                    </div>
                                </td>
                                <td>{{ date('d-m-Y', strtotime($movement->movement_date)) }}</td>
                                <td>Dari Kelas <span class="badge bg-red">{{ $movement->base->name }}</span> ke Kelas <span class="badge bg-blue">{{ $movement->destination->name }}</span></td>
                                <td><span class="badge bg-yellow">Rp{{ number_format($movement->movement_costs,2,",",".") }}</span></td>
                                <td><span class="badge bg-yellow">Rp{{ number_format($movement->upgrade_costs,2,",",".") }}</span></td>
                                <td>{{ $movement->employee->name }}</td>
                                <td>
                                    <div class="mytooltip">
                                        <!--<a href="{{ URL::to('perpindahan') }}/{{ $movement->id }}/edit" type="button" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </a>-->
                                        <a href="{{ URL::to('perpindahan') }}/{{ $movement->id }}" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Klik untuk Detail"><i class="fa fa-list"></i></a>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $movement->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan!"><i class="fa fa-trash-o"></i>
                                        </button>
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

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        })
    });

    function destroy(id)
    {
        if(confirm("Yakin akan membatalkan Proses Pindah Kelas Ini?!"))
        {
            $.ajax({
                url:"{{ URL::to('perpindahan') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('perpindahan') }}";
                }
            });
        }
    }
</script>
@stop