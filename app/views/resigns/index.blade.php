@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Siswa Non Aktif
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kesiswaan</a></li>
        <li><a href="{{ URL::to('keluar') }}"><i class="active"></i> Non Aktif</a></li>
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
                    <a href="{{ URL::to('keluar/create') }}" class="btn btn-danger"><i class="fa fa-plus"></i> Keluarkan Siswa</a>
                    <div class="clear-fix"><br/></div>

                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Tgl Keluar</th>
                                <th>Alasan Keluar</th>
                                <th>Denda</th>
                                <th>Pengembalian</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($resigns as $resign)
                            <tr>
                                <td>
                                    <div class="pull-left image">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $resign->issue->student->photo }}" class="img-polaroid" alt="student Avatar">
                                        <a href="{{ URL::to('siswa') }}/{{ $resign->issue_id }}">{{ $resign->issue->issue }} / {{ $resign->issue->student->name }}</a>
                                    </div>
                                </td>
                                <td>{{ date('d-m-Y', strtotime($resign->resign_date)) }}</td>
                                <td>{{ $resign->classification->name }}</td>
                                <td>
                                    <span class="badge bg-green">Rp{{ number_format($resign->fines,2,",",".") }}</span>
                                    @if($resign->fines > 0.00 && $resign->is_earned == 0)
                                        <a href="#" onclick="earnFines({{ $resign->id }})" data-toggle="tooltip" data-placement="top" title="Klik untuk Penerimaan Denda"><i class="fa fa-money"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-red">Rp{{ number_format($resign->returnment,2,",",".") }}</span>
                                    @if($resign->returnment > 0.00 && $resign->is_returned == 0)
                                        <a href="#" onclick="giveReturnment({{ $resign->id }})" data-toggle="tooltip" data-placement="top" title="Klik untuk Pengembalian Biaya"><i class="fa fa-money"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('keluar') }}/{{ $resign->id }}/edit" class="btn btn-primary btn-circle" data-toggle="tooltip" data-placement="top" title="Koreksi"><i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $resign->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan"><i class="fa fa-trash-o"></i>
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

    function earnFines(id)
    {
        if(confirm("Anda akan menerima Denda?!"))
        {
            $.ajax({
                url:"{{ URL::to('keluar') }}/"+id+"/denda",
                type:"PUT",
                success:function(e){
                    window.location = "{{ URL::to('penerimaan') }}/"+e.earning;
                }
            });
        }
    }

    function giveReturnment(id)
    {
        if(confirm("Anda akan menyerahkan pengembalian Dana?!"))
        {
            $.ajax({
                url:"{{ URL::to('keluar') }}/"+id+"/retur",
                type:"PUT",
                success:function(e){
                    window.location = "{{ URL::to('pengembalian') }}/"+e.returnment;
                }
            });
        }
    }

    function destroy(id)
    {
        if(confirm("Yakin akan membatalkan Penon-aktifan siswa ini?!"))
        {
            $.ajax({
                url:"{{ URL::to('keluar') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('keluar') }}";
                }
            });
        }
    }
</script>
@stop