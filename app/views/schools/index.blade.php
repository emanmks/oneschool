@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Sekolah Asal
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('sekolah') }}"><i class="active"></i> Sekolah</a></li>
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
                    <button class="btn btn-success" onClick="showFormCreate()"><i class="fa fa-plus"></i> Sekolah Baru</button>
                    <div class="clear-fix"><br/></div>

                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Kota Asal</th>
                                <th>Nama Sekolah</th>
                                <th>Tingkatan</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                                <th>Kontak Person</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($schools as $school)
                            <tr>
                                <td>{{ $school->city->name }}</td>
                                <td><strong class="text-primary"><i class="fa fa-home"></i> {{ $school->name }}</strong></td>
                                <td><span class="badge bg-blue">{{ $school->level }}</span></td>
                                <td>{{ $school->address }}</td>
                                <td>{{ $school->contact }}</td>
                                <td>{{ $school->contact_person }}</td>
                                <td>
                                    <input type="hidden" id="state-{{ $school->id }}" value="{{ $school->city->state_id }}">
                                    <input type="hidden" id="city-{{ $school->id }}" value="{{ $school->city_id }}">
                                    <input type="hidden" id="name-{{ $school->id }}" value="{{ $school->name }}">
                                    <input type="hidden" id="address-{{ $school->id }}" value="{{ $school->address }}">
                                    <input type="hidden" id="contact-{{ $school->id }}" value="{{ $school->contact }}">
                                    <input type="hidden" id="contact_person-{{ $school->id }}" value="{{ $school->contact_person }}">
                                    <input type="hidden" id="level-{{ $school->id }}" value="{{ $school->level }}">
                                    <div class="mytooltip">
                                        <button type="button" class="btn btn-primary btn-circle" onclick="showFormUpdate({{ $school->id }})" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="destroy({{ $school->id }})" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i>
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

<!-- Form Add School [modal]
===================================== -->
<div id="formCreate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Sekolah Baru</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="state">Pilih Propinsi Asal</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="state" onchange="loadCities()">
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            <script type="text/javascript">
                                $('select[name=state]').val("25");
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="city">Pilih Kota Asal</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="city">
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                                <script type="text/javascript">
                                    $('select[name=city]').val("393");
                                </script>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="level">Tingkat</label>
                        <div class="col-lg-3">
                            <select class="form-control" name="level">
                                <option value="SMA">SMA</option>
                                <option value="SMP">SMP</option>
                                <option value="SD">SD</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">Nama Sekolah</label>
                        <div class="col-lg-6">
                            <input name="name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="address">Alamat</label>
                        <div class="col-lg-7">
                            <input name="address" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="contact">Kontak</label>
                        <div class="col-lg-5">
                            <input name="contact" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="contact_person">Kontak Person</label>
                        <div class="col-lg-5">
                            <input name="contact_person" type="text" class="form-control">
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
<!-- End of Add School [modal] -->

<!-- Form Update School [modal]
===================================== -->
<div id="formUpdate" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Update Sekolah</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_level">Tingkat</label>
                        <div class="col-lg-3">
                            <select class="form-control" name="updated_level">
                                <option value="SMA">SMA</option>
                                <option value="SMP">SMP</option>
                                <option value="SD">SD</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_name">Nama Sekolah</label>
                        <div class="col-lg-6">
                            <input name="updated_name" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_address">Alamat</label>
                        <div class="col-lg-7">
                            <input name="updated_address" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_contact">Kontak</label>
                        <div class="col-lg-5">
                            <input name="updated_contact" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_contact_person">Kontak Person</label>
                        <div class="col-lg-5">
                            <input name="updated_contact_person" type="text" class="form-control">
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
<!-- End of Update School [modal] -->

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

    function loadCities()
    {
        var state_id = $('select[name=state]').val();

        $.ajax({
            url:"{{ URL::to('loadcities') }}/"+state_id,
            type:"GET",
            dataType:"json",
            success:function(cities){
                $('select[name=city]').html('');

                for (var i = cities.length - 1; i >= 0; i--) {
                    $('select[name=city]').append("<option value='"+cities[i].id+"'>"+cities[i].name+"</option>");
                };
            }
        });
    }

    function showFormCreate()
    {
        $('#formCreate').modal('show');
    }

    function showFormUpdate(id)
    {
        $('#formUpdate').modal('show');

        $('[name=school_id]').val(id);

        $('[name=updated_name]').val($('#name-'+id).val());
        $('[name=updated_address]').val($('#address-'+id).val());
        $('[name=updated_contact]').val($('#contact-'+id).val());
        $('[name=updated_contact_person]').val($('#contact_person-'+id).val());
        $('[name=updated_level]').val($('#level-'+id).val());
    }

    function create()
    {
        var city = $('select[name=city]').val();
        var name = $('input[name=name]').val();
        var address = $('input[name=address]').val();
        var contact = $('input[name=contact]').val();
        var contact_person = $('input[name=contact_person]').val();
        var level = $('select[name=level]').val();

        if(name != '')
        {
            $.ajax({
                url:'sekolah',
                type:'POST',
                data:{city:city, name:name, address:address, contact:contact, contact_person:contact_person, level:level},
                success:function(){
                    window.location = "sekolah";
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
        var id = $('[name=school_id]').val();
        var name = $('[name=updated_name]').val();
        var address = $('[name=updated_address]').val();
        var contact = $('[name=updated_contact]').val();
        var contact_person = $('[name=updated_contact_person]').val();
        var level = $('[name=updated_level]').val();

        if(name != '')
        {
            $.ajax({
                url:'sekolah/'+id,
                type:'PUT',
                data:{city:city, name:name, address:address, contact:contact, contact_person:contact_person, level:level},
                success:function(){
                    window.location = "sekolah";
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
        if(confirm("Yakin akan menghapus data sekolah ini?!"))
        {
             $.ajax({
                url:'sekolah/'+id,
                type:'DELETE',
                success:function(){
                    window.location = "sekolah";
                }
            });
        }
    }
</script>
@stop