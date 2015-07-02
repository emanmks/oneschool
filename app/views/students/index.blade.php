@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Manajemen Siswa
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="siswa"><i class="active"></i> Siswa</a></li>
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
                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Tgl Lahir</th>
                                <th>Ayah</th>
                                <th>Ibu</th>
                                <th>Profil</th>
                                <th>Edit</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($issues as $issue)
                            <tr>
                                <td>
                                	<div class="pull-left image">
							            <img src="{{ URL::to('assets/img/students') }}/{{ $issue->student->photo }}" class="img-polaroid" alt="student Avatar">
							            <a href="{{ URL::to('siswa') }}/{{ $issue->id }}/raport" data-toggle="tooltip" data-placement="right" title="Klik untuk Lihat Raport">
                                            {{ $issue->issue }} / {{ $issue->student->name }}
                                        </a>
							        </div>
                                </td>
                                <td>{{ date('d-m-Y', strtotime($issue->student->birthdate)) }}</td>
                                <td>{{ $issue->student->father_name }}</td>
                                <td>{{ $issue->student->mother_name }}</td>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('siswa') }}/{{ $issue->id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="left" title="Klik Untuk Lihat Profile Lengkap">
                                            <i class="fa fa-edit"></i> Profil
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('siswa') }}/{{ $issue->student->id }}/edit" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="left" title="Klik Untuk Koreksi Biodata">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
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
</script>
@stop