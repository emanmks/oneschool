@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Charges
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('charge') }}"><i class="active"></i> Charges</a></li>
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
                	<a class="btn btn-success" href="{{ URL::to('charge') }}/create"><i class="fa fa-plus"></i> Charge Baru</a>

                	<div class="clear-fix"><br/></div>

                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nominal</th>
                                <th>Keterangan</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($charges as $charge)
                            <tr>
                                <td><span class="badge bg-green">{{ $charge->name }}</span></td>
                                <td><span class="badge bg-red">Rp{{ number_format($charge->nominal,2,',','.') }}</span></td>
                                <td>{{ substr($charge->description, 0,100) }}...</td>
                                <td>
                                    <div class="mytooltip">
                                        <a class="btn btn-primary btn-circle" href="{{ URL::to('charge') }}/{{ $charge->id }}/edit" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-circle" onclick="destroy({{ $charge->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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
        });
    });

    function destroy(id)
    {
    	if(confirm("Yakin akan menghapus data ini?!"))
    	{
    		 $.ajax({
                url:"{{ URL::to('charge') }}/"+id,
                type:'DELETE',
                success:function(){
                    window.location = "{{ URL::to('charge') }}";
                }
            });
    	}
    }
</script>
@stop