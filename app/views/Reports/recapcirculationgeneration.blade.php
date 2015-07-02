@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>Rekap Sirkulasi per Tingkatan</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="{{ URL::to('laporan') }}"> Laporan</a></li>
        <li><a href="{{ URL::to('laporan/rekap-sekolah-tingkat') }}"><i class="active"></i> Rekap Sirkulasi per Tingkatan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr class="success">
                                <th colspan="{{ $generations->count() + 3 }}"><center>Rekap Sirkulasi per Tingkatan</center></th>
                            </tr>
                            <tr class="warning">
                                <th colspan="2">Siswa Masuk / Keluar</th>
                                @foreach($generations as $generation)
                                    <th><center>{{ $generation->name }}</center></th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($comes as $come)
                                <tr>
                                    <td><span class="text-success">Siswa Masuk <i class="fa fa-arrow-right"></i></span></td>
                                    <td>{{ $come['name'] }}</td>
                                    <?php $total = 0; ?>
                                    @foreach($come['statistics'] as $statistic)
                                        <td>
                                            @if($statistic['count'] == 0)
                                                <center><span class="text-danger">{{ $statistic['count'] }}</span></center>
                                            @else
                                                <center><span class="text-primary">{{ $statistic['count'] }}</span></center>
                                            @endif
                                        </td>
                                        <?php $total += $statistic['count']; ?>
                                    @endforeach
                                    <td><center><span class="text-success">{{ $total }}</span></center></td>
                                </tr>
                            @endforeach
                            @foreach($leaves as $leave)
                                <tr>
                                    <td><span class="text-danger">Siswa Keluar <i class="fa fa-arrow-left"></i></span></td>
                                    <td>{{ $leave['name'] }}</td>
                                    <?php $total = 0; ?>
                                    @foreach($leave['statistics'] as $statistic)
                                        <td>
                                            @if($statistic['count'] == 0)
                                                <center><span class="text-danger">{{ $statistic['count'] }}</span></center>
                                            @else
                                                <center><span class="text-primary">{{ $statistic['count'] }}</span></center>
                                            @endif
                                        </td>
                                        <?php $total += $statistic['count']; ?>
                                    @endforeach
                                    <td><center><span class="text-success">{{ $total }}</span></center></td>
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
</script>
@stop