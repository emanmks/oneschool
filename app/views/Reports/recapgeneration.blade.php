@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>Rekap Per Tingkatan</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="{{ URL::to('laporan') }}"> Laporan</a></li>
        <li><a href="{{ URL::to('laporan/rekap-tingkat') }}"><i class="active"></i> Rekap per Tingkatan</a></li>
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
                                <th colspan="{{ $generations->count() + 1 }}"><center>Rekap Tingkatan Periodik</center></th>
                            </tr>
                            <tr class="warning">
                                <th>Periode</th>
                                @foreach($generations as $generation)
                                    <th><center>{{ $generation->name }}</center></th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($periodizations as $period)
                                <tr>
                                    <td>
                                        @if($period['month'] == 1)
                                            Januari, {{ $period['year'] }}   
                                        @elseif($period['month'] == 2)
                                            Februari, {{ $period['year'] }}
                                        @elseif($period['month'] == 3)
                                            Maret, {{ $period['year'] }}
                                        @elseif($period['month'] == 4)
                                            April, {{ $period['year'] }}
                                        @elseif($period['month'] == 5)
                                            Mei, {{ $period['year'] }}
                                        @elseif($period['month'] == 6)
                                            Juni, {{ $period['year'] }}
                                        @elseif($period['month'] == 7)
                                            Juli, {{ $period['year'] }}
                                        @elseif($period['month'] == 8)
                                            Agustus, {{ $period['year'] }}
                                        @elseif($period['month'] == 9)
                                            September, {{ $period['year'] }}
                                        @elseif($period['month'] == 10)
                                            Oktober, {{ $period['year'] }}
                                        @elseif($period['month'] == 11)
                                            Nopember, {{ $period['year'] }}
                                        @elseif($period['month'] == 12)
                                            Desember, {{ $period['year'] }}
                                        @endif
                                    </td>
                                    @foreach($period['statistics'] as $statistic)
                                        <td>
                                            @if($statistic['count'] == 0)
                                                <center><span class="text-danger">{{ $statistic['count'] }}</span></center>
                                            @else
                                                <center><span class="text-primary">{{ $statistic['count'] }}</span></center>
                                            @endif
                                        </td>
                                    @endforeach    
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