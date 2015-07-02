@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Pengaturan
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="{{ URL::to('pengaturan') }}"><i class="active"></i> Pengaturan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-6">
            <div class="jumbotron">
                <h1><i class="fa fa-rocket"></i></h1>
                <h1>{{ Auth::user()->currProject->name }}</h1>
                <p>
                    Periode Project : 
                    {{ date('d-m-Y', strtotime(Auth::user()->currProject->start_date)) }} 
                    s/d
                    {{ date('d-m-Y', strtotime(Auth::user()->currProject->end_date)) }} 
                </p>
                <p>
                     <button class="btn btn-danger" onclick="showFormSelectProject({{ Auth::user()->curr_project_id }})" data-toggle="tooltip" data-placement="bottom" title="Klik untuk Ganti Project"><i class="fa fa-rocket"></i> Klik untuk Pindah Berganti Project</button>
                </p>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="jumbotron">
                <h1><i class="fa fa-map-marker"></i></h1>
                <h1>{{ Auth::user()->location->name }}</h1>
                <p>Alamat : {{ Auth::user()->location->address}}</p>
                <p>
                    @if(Auth::user()->role == 'Super Admin')
                        <button class="btn btn-danger" onclick="showFormSelectLocation({{ Auth::user()->location_id }})" data-toggle="tooltip" data-placement="bottom" title="Klik untuk Ganti Lokasi"><i class="fa fa-map-marker"></i> Klik untuk Pindah Lokasi</button>
                    @endif
                </p>
            </div>
        </div>

        <!--<div class="col-lg-4">
            <div class="jumbotron">
                <h1><i class="fa fa-flash"></i></h1>
                <h1>Normalisasi Nomor Pokok</h1>
                <p>Bismillah Semoga Sukses!!!</p>
                <p>
                    @if(Auth::user()->role == 'Super Admin')
                        <button class="btn btn-danger" onclick="normalizeIssue()" data-toggle="tooltip" data-placement="bottom" title="Klik untuk Ganti Lokasi"><i class="fa fa-map-marker"></i> Normalisasi Nomor Pokok</button>
                    @endif
                </p>
            </div>
        </div>-->
    </div>
</section>

<!-- Form Change Project [modal]
===================================== -->
<div id="formChangeProject" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Ganti Project</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="selectProject"></label>
                        <div class="col-lg-7">
                            @if(Auth::user()->role == 'Super Admin')
                                <select name="selectProject" class="form-control">
                            @else
                                <select name="selectProject" class="form-control" disabled>
                            @endif

                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach

                            </select>

                            <script type="text/javascript">
                                $('select[name=selectProject]').val("{{ Auth::user()->curr_project_id }}");
                            </script>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="changeProject()" data-dismiss="modal" aria-hidden="true">Simpan Pengaturan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Form Change Project [modal] -->

<!-- Form Change Location [modal]
===================================== -->
<div id="formChangeLocation" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Ganti Cabang</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="selectLocation"></label>
                        <div class="col-lg-7">
                            @if(Auth::user()->role == 'Super Admin')
                                <select name="selectLocation" class="form-control">
                            @else
                                <select name="selectLocation" class="form-control" disabled>
                            @endif

                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach

                            </select>

                            <script type="text/javascript">
                                $('select[name=selectLocation]').val("{{ Auth::user()->location_id }}");
                            </script>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="changeLocation()" data-dismiss="modal" aria-hidden="true">Simpan Pengaturan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Form Change Project [modal] -->

<script type="text/javascript">
    function showFormSelectProject(id)
    {
        $('#formChangeProject').modal('show');
    }

    function showFormSelectLocation(id)
    {
        $('#formChangeLocation').modal('show');
    }

    function changeProject()
    {
        var project = $('select[name=selectProject]').val();

        if(confirm("Yakin mau Pindah Project?!"))
        {
            $.ajax({
                url:"{{ URL::to('changeproject') }}",
                type:"PUT",
                data:{project_id:project},
                success:function(){
                    window.location = "{{ URL::to('pengaturan') }}";
                }
            });
        }
    }

    function changeLocation()
    {
        var location = $('select[name=selectLocation]').val();

        if(confirm("Yakin mau Pindah Lokasi"))
        {
            $.ajax({
                url:"{{ URL::to('changelocation') }}",
                type:"PUT",
                data:{location_id:location},
                success:function(){
                    window.location = "{{ URL::to('pengaturan') }}";
                }
            });
        }
    }

    function normalizeIssue()
    {
        if(confirm("Bismillah.. Proses Normalisasi Nomor Pokok akan dimulai"))
        {
            $.ajax({
                url:"{{ URL::to('normalizeissue') }}",
                type:"PUT",
                success:function(){
                    window.alert("Proses Normalisasi Nomor Pokok Berhasil dilakukan! Alhamdulillah");
                }
            });
        }
    }
</script>
@stop