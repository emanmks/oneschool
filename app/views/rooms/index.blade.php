@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Ruangan
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('ruangan') }}"><i class="active"></i> Ruangan</a></li>
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
                <div class="box-header">
                    <div class="box-title">
                        <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> Ruangan Baru</button>
                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Nama Ruangan</th>
                                <th>Kapasitas</th>
                                <th>Lihat Kelas</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($rooms as $room)
                            <tr>
                                <td><strong class="text-primary">{{ $room->name }}</strong></td>
                                <td><span class="badge bg-red">{{ $room->capacity }}</span></td>
                                <td><a href="{{ URL::to('ruangan') }}/{{ $room->id }}" class="btn btn-xs btn-primary">Lihat Kelas</a></td>
                                <td>
                                    <input type="hidden" id="name-{{ $room->id }}" value="{{ $room->name }}">
                                    <input type="hidden" id="capacity-{{ $room->id }}" value="{{ $room->capacity }}">
                                    <input type="hidden" id="location-{{ $room->id }}" value="{{ $room->location_id }}">
                                    <div class="mytooltip">
                                        <button type="button" class="btn btn-primary btn-circle" onclick="showFormUpdate({{ $room->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $room->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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

<!-- Form Add Room [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Ruangan Baru</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="location">Nama Cabang</label>
                        <div class="col-lg-7">
                            @if(Auth::user()->role == 'Super Admin')
                                <select name="location" class="form-control">
                            @else
                                <select name="location" class="form-control" disabled>
                            @endif
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                            <script type="text/javascript">
                                $('select[name=location]').val("{{ Auth::user()->location_id }}");
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Nama Ruangan</label>
                        <div class="col-lg-7">
                            <input name="name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="capacity">Kapasitas</label>
                        <div class="col-lg-2">
                            <input name="capacity" type="text" class="form-control">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="create()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Add place [modal] -->

<!-- Form Update place [modal]
===================================== -->
<div id="formUpdate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Update Ruangan</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_location">Nama Cabang</label>
                        <div class="col-lg-7">
                            <input type="hidden" name="room_id" value="0">

                            @if(Auth::user()->role == 'Super Admin')
                                <select name="updated_location" class="form-control">
                            @else
                                <select name="updated_location" class="form-control" disabled>
                            @endif
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_name">Nama Ruangan</label>
                        <div class="col-lg-7">
                            <input name="updated_name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_capacity">Kapasitas</label>
                        <div class="col-lg-2">
                            <input name="updated_capacity" type="text" class="form-control">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onClick="update()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Update place [modal] -->

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

    function showFormCreate()
    {
        $('#formCreate').modal('show');
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');

        $('input[name=room_id]').val(id);
        $('select[name=updated_location]').val($('#location-'+id).val());
        $('input[name=updated_name').val($('#name-'+id).val());
        $('input[name=updated_capacity]').val($('#capacity-'+id).val());
    }

    function create()
    {
        var location = $('select[name=location]').val();
        var name = $('input[name=name]').val();
        var capacity = $('input[name=capacity]').val();

        if(name != '')
        {
            $.ajax({
                url:'ruangan',
                type:'POST',
                data:{location:location, name:name, capacity:capacity},
                success:function(){
                    window.location = "ruangan";
                }
            });
        }
        else
        {
            window.alert('Mohon Lengkapi Inputan Anda!');
        }
    }

    function update()
    {
        var id = $('input[name=room_id]').val();
        var location = $('select[name=updated_location]').val();
        var name = $('input[name=updated_name]').val();
        var capacity = $('input[name=updated_capacity]').val();

        if(name != '')
        {
            $.ajax({
                url:'ruangan/'+id,
                type:'PUT',
                data:{location:location, name:name, capacity:capacity},
                success:function(){
                    window.location = "ruangan";
                }
            });
        }
        else
        {
            window.alert('Mohon Lengkapi Inputan Anda!');
        }
    }

    function destroy(id)
    {
        if(confirm("Yakin akan menghapus ruangan ini?!"))
        {
             $.ajax({
                url:'ruangan/'+id,
                type:'DELETE',
                success:function(){
                    window.location = "ruangan";
                }
            });
        }
    }
</script>
@stop