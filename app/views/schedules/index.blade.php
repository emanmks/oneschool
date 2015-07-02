@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Jadwal Bimbingan
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Akademik</a></li>
        <li><a href="presensi-siswa"><i class="active"></i> Jadwal Bimbingan</a></li>
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
                <div class="box-body">
                    <div class="nav-tabs-costum">
                        <ul class="nav nav-tabs">
                            <li><a href="#senin" data-toggle="tab"><strong>Senin</strong></a></li>
                            <li><a href="#selasa" data-toggle="tab"><strong>Selasa</strong></a></li>
                            <li><a href="#rabu" data-toggle="tab"><strong>Rabu</strong></a></li>
                            <li><a href="#kamis" data-toggle="tab"><strong>Kamis</strong></a></li>
                            <li><a href="#jumat" data-toggle="tab"><strong>Jum'at</strong></a></li>
                            <li><a href="#sabtu" data-toggle="tab"><strong>Sabtu</strong></a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="senin">
                                <div class="clear-fix"><br/></div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kelas</th>
                                            <th colspan="10"><span class="text-center">Jam Belajar</span></th>
                                        </tr>
                                        <tr>
                                            <th>08:00-08:45</th>
                                            <th>09:00-09:45</th>
                                            <th>10:15-11:00</th>
                                            <th>11:15-12:00</th>
                                            <th>13:00-13:45</th>
                                            <th>14:00-14:45</th>
                                            <th>16:00-16:45</th>
                                            <th>17:00-17:45</th>
                                            <th>18:00-18:45</th>
                                            <th>19:00-20:00</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>E-1</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">F-1</span></td>
                                            <td><span class="badge bg-blue">M-1</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>E-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-green">F-1</span></td>
                                            <td><span class="badge bg-green">M-1</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>6-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">M-2</span></td>
                                            <td><span class="badge bg-blue">E-7</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="selasa">
                                <div class="clear-fix"><br/></div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kelas</th>
                                            <th colspan="10"><span class="text-center">Jam Belajar</span></th>
                                        </tr>
                                        <tr>
                                            <th>08:00-08:45</th>
                                            <th>09:00-09:45</th>
                                            <th>10:15-11:00</th>
                                            <th>11:15-12:00</th>
                                            <th>13:00-13:45</th>
                                            <th>14:00-14:45</th>
                                            <th>16:00-16:45</th>
                                            <th>17:00-17:45</th>
                                            <th>18:00-18:45</th>
                                            <th>19:00-20:00</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>E-1</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">F-1</span></td>
                                            <td><span class="badge bg-blue">M-1</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>E-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-green">F-1</span></td>
                                            <td><span class="badge bg-green">M-1</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>6-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">M-2</span></td>
                                            <td><span class="badge bg-blue">E-7</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="rabu">
                                <div class="clear-fix"><br/></div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kelas</th>
                                            <th colspan="10"><span class="text-center">Jam Belajar</span></th>
                                        </tr>
                                        <tr>
                                            <th>08:00-08:45</th>
                                            <th>09:00-09:45</th>
                                            <th>10:15-11:00</th>
                                            <th>11:15-12:00</th>
                                            <th>13:00-13:45</th>
                                            <th>14:00-14:45</th>
                                            <th>16:00-16:45</th>
                                            <th>17:00-17:45</th>
                                            <th>18:00-18:45</th>
                                            <th>19:00-20:00</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>E-1</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">F-1</span></td>
                                            <td><span class="badge bg-blue">M-1</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>E-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-green">F-1</span></td>
                                            <td><span class="badge bg-green">M-1</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>6-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">M-2</span></td>
                                            <td><span class="badge bg-blue">E-7</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="kamis">
                                <div class="clear-fix"><br/></div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kelas</th>
                                            <th colspan="10"><span class="text-center">Jam Belajar</span></th>
                                        </tr>
                                        <tr>
                                            <th>08:00-08:45</th>
                                            <th>09:00-09:45</th>
                                            <th>10:15-11:00</th>
                                            <th>11:15-12:00</th>
                                            <th>13:00-13:45</th>
                                            <th>14:00-14:45</th>
                                            <th>16:00-16:45</th>
                                            <th>17:00-17:45</th>
                                            <th>18:00-18:45</th>
                                            <th>19:00-20:00</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>E-1</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">F-1</span></td>
                                            <td><span class="badge bg-blue">M-1</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>E-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-green">F-1</span></td>
                                            <td><span class="badge bg-green">M-1</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>6-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">M-2</span></td>
                                            <td><span class="badge bg-blue">E-7</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="jumat">
                                <div class="clear-fix"><br/></div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kelas</th>
                                            <th colspan="10"><span class="text-center">Jam Belajar</span></th>
                                        </tr>
                                        <tr>
                                            <th>08:00-08:45</th>
                                            <th>09:00-09:45</th>
                                            <th>10:15-11:00</th>
                                            <th>11:15-12:00</th>
                                            <th>13:00-13:45</th>
                                            <th>14:00-14:45</th>
                                            <th>16:00-16:45</th>
                                            <th>17:00-17:45</th>
                                            <th>18:00-18:45</th>
                                            <th>19:00-20:00</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>E-1</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">F-1</span></td>
                                            <td><span class="badge bg-blue">M-1</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>E-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-green">F-1</span></td>
                                            <td><span class="badge bg-green">M-1</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>6-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">M-2</span></td>
                                            <td><span class="badge bg-blue">E-7</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="sabtu">
                                <div class="clear-fix"><br/></div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kelas</th>
                                            <th colspan="10"><span class="text-center">Jam Belajar</span></th>
                                        </tr>
                                        <tr>
                                            <th>08:00-08:45</th>
                                            <th>09:00-09:45</th>
                                            <th>10:15-11:00</th>
                                            <th>11:15-12:00</th>
                                            <th>13:00-13:45</th>
                                            <th>14:00-14:45</th>
                                            <th>16:00-16:45</th>
                                            <th>17:00-17:45</th>
                                            <th>18:00-18:45</th>
                                            <th>19:00-20:00</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>E-1</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">F-1</span></td>
                                            <td><span class="badge bg-blue">M-1</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>E-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-green">F-1</span></td>
                                            <td><span class="badge bg-green">M-1</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>6-3</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="badge bg-blue">M-2</span></td>
                                            <td><span class="badge bg-blue">E-7</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        })
    });
</script>
@stop