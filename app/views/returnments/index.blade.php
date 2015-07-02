@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Pengembalian Biaya Bimbingan
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Keuangan</a></li>
        <li><a href="{{ URL::to('pengembalian') }}"><i class="active"></i> Pengembalian</a></li>
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
                    <a href="{{ URL::to('pengembalian') }}/create" class="btn btn-success"><i class="fa fa-plus"></i> Baru</a>
                    <div class="clear-fix"><br/></div>

                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Siswa</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Diserahkan Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($returnments as $returnment)
                            <tr>
                            	<td>
                            		<div class="mytooltip">
                                        <a href="{{ URL::to('pengembalian') }}/{{ $returnment->id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Lihat Detail">{{ $returnment->code }}</a>
                                    </div>
                            	</td>
                            	<td>
                            		<div class="pull-left image">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $returnment->issue->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $returnment->issue_id }}">
                                            {{ $returnment->issue->issue }} /
                                            {{ $returnment->issue->student->name }}
                                        </a>
                                    </div>
                            	</td>
                                <td>{{ date('d-m-Y', strtotime($returnment->retur_date)) }}</td>
                                <td><span class="badge bg-blue">Rp{{ number_format($returnment->total,2,',',',') }}</span></td>
                                <td>{{ $returnment->employee->name }}</td>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('pengembalian') }}/{{ $returnment->id }}/edit" class="btn btn-circle btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Koreksi"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-circle btn-danger" onclick="destroy({{ $returnment->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan!!!"><i class="fa fa-trash-o"></i></button>
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
    });

    function destroy(id)
    {
        if(confirm("Yakin akan membatalkan pengeluaran?!"))
        {
            $.ajax({
                url:"{{ URL::to('pengembalian') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('pengeluaran') }}";
                }
            });
        }
    }
</script>
@stop