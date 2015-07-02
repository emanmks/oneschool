@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>Rekap Sekolah per Tingkatan</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="{{ URL::to('laporan') }}"> Laporan</a></li>
        <li><a href="{{ URL::to('laporan/rekap-sekolah-tingkat') }}"><i class="active"></i> Rekap Sekolah per Tingkatan</a></li>
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
                                <th colspan="{{ $generations->count() + 2 }}"><center>Rekap Sekolah per Tingkatan</center></th>
                            </tr>
                            <tr class="warning">
                                <th>Sekolah</th>
                                @foreach($generations as $generation)
                                    <th><center>{{ $generation->name }}</center></th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($schools as $school)
                                <tr>
                                    <td>{{ $school['name'] }}</td>
                                    <?php $total = 0; ?>
                                    @foreach($school['statistics'] as $statistic)
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