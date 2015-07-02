@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Raport Siswa
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kesiswaan</a></li>
        <li><a href="{{ URL::to('siswa') }}"><i class="active"></i> Raport</a></li>
    </ol>
</section>

<section class="content invoice">
    <div class="row">
        <div class="col-xs-12">
            <p>
                <h4><strong>One School</strong></h4>
                <small>
                    One School Office<br/>
                    Jl. Poros Limbung No. 55<br/>
                    Telp : 0411 - 8217794 / 085397815928
                </small>
            </p>
        </div>    
    </div>

    <div class="row">
        <div class="col-xs-12">
            <center>
                <h2>LAPORAN AKADEMIK SISWA</h2>   
            </center>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
        	<div class="pull-right">
                Nomor Pokok<br/>
                Nama Lengkap<br/>
                Asal Sekolah<br/>
                Kelas<br/>
                Hari Belajar<br/>
            </div>
        </div>
        <div class="col-xs-6">
            : {{ $student->issue }}<br/>
            : {{ $student->student->name }}<br/>
            : {{ $student->education->school->name }}<br/>
            : {{ $student->placement->course->name }}<br/>
            : {{ $student->placement->course->course_days }}
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-condensed">
                <thead>
                    <tr class="success">
                        <th colspan="7"><center>PERSENTASE KEHADIRAN</center></th>
                    </tr>
                    <tr class="warning">
                        <th>Bulan</th>
                        <th>Total Jam Belajar</th>
                        <th>Hadir</th>
                        <th>Alpa</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($presences as $presence)
                        <tr>
                            <td>{{ $presence['month'] }} / {{ $presence['year'] }}</td>
                            <td>{{ $presence['presences'] }}</td>
                            <td>{{ $presence['presents'] }}</td>
                            <td>{{ $presence['absents'] }}</td>
                            <td>{{ $presence['sicks'] }}</td>
                            <td>{{ $presence['permits'] }}</td>
                            <td>
                                @if($presence['presents'] == 0)
                                    0%
                                @else
                                    {{ ($presence['presents']/$presence['presences'])*100 }}%
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th colspan="4" class="success"><center>PEMBAYARAN</center></th>
                    </tr>
                    <tr class="warning">
                        <th>Total Biaya</th>
                        <th>Total Potongan</th>
                        <th>Total Beban</th>
                        <th>Sisa Beban</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="info">
                        <td>Rp{{ number_format($student->receivable->total,2,",",".") }}</td>
                        <td>Rp{{ number_format($student->receivable->total - $student->receivable->billable,2,",",".") }}</td>
                        <td>Rp{{ number_format($student->receivable->billable,2,",",".") }}</td>
                        <td>Rp{{ number_format($student->receivable->balance,2,",",".") }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-6">
            <table class="table table-condensed">
                <thead>
                    <tr class="success">
                        <th colspan="3"><center>Jadwal Angsuran</center></th>
                    </tr>
                    <tr class="warning">
                        <th>Jadwal</th>
                        <th>Nominal</th>
                        <th>Lunas</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($student->receivable->installments as $installment)
                        <tr>
                            <td>
                                {{ date('d-m-Y', strtotime($installment->schedule)) }}
                            </td>
                            <td>
                                Rp{{ number_format($installment->total,2,",",".") }}
                            </td>
                            <td>
                                @if($installment->balance == 0)
                                    <span class="badge bg-green">Y</span>
                                @else
                                    <span class="badge bg-red">T</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach   
                </tbody>
            </table>
        </div>
        <div class="col-xs-6">
            <table class="table table-condensed">
                <thead>
                    <tr class="success">
                        <th colspan="3"><center>History Pembayaran</center></th>
                    </tr>
                    <tr class="warning">
                        <th>Tanggal</th>
                        <th>Jenis Pembayaran</th>
                        <th>Nominal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($student->earnings as $earning)
                        <tr>
                            <td>{{ date('d-m-Y',strtotime($earning->earning_date)) }}</td>
                            <td>
                                @if($earning->earnable_type == 'Receivable')
                                    <small>Biaya Bimbingan (Cash)</small>
                                @elseif($earning->earnable_type == 'Installment')
                                    <small>Angsuran untuk Tgl : {{ date("d-m-Y",strtotime($earning->earnable->schedule)) }}</small>
                                @elseif($earning->earnable_type == 'Registration')
                                    <small>Biaya Pendaftaran</small>
                                @elseif($earning->earnable_type == 'Movement')
                                    <small>Biaya Pindah Kelas</small>
                                @elseif($earning->earnable_type == 'Punishment')
                                    <small>Denda: {{ substr($earning->earnable->comments, 0,50) }}</small>
                                @endif
                            </td>
                            <td><span class="badge bg-yellow">Rp{{ number_format($earning->payment,2,",",".") }}</span></td>
                        </tr>
                    @endforeach  
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8">
            <table class="table table-condensed">
                <thead>
                    <tr class="success">
                        <th colspan="4"><center>PENILAIAN KUANTITATIF</center></th>
                    </tr>
                    <tr class="warning">
                        <th>Tanggal</th>
                        <th>Bid. Studi</th>
                        <th>Materi</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->points as $point)
                        @if($point->pointable_type == 'Quiz')
                            <tr>
                                <td>{{ date('d-m-Y', strtotime($point->pointable->quiz_date)) }}</td>
                                <td>{{ $point->pointable->subject->name }}</td>
                                <td>{{ $point->pointable->name }}</td>
                                <td>{{ $point->point }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-xs-4">
            <table class="table table-condensed">
                <thead>
                    <tr class="success">
                        <th colspan="2"><center>PENGUASAAN</center></th>
                    </tr>
                    <tr class="warning">
                        <th>Bid. Studi</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->masteries as $mastery)
                        <tr>
                            <td>{{ $mastery->subject->name }}</td>
                            <td>{{ $mastery->mastery }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-condensed">
                <thead>
                    <tr class="success">
                        <th colspan="5"><center>KEGIATAN SISWA</center></th>
                    </tr>
                    <tr class="warning">
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Nilai</th>
                        <th>Terendah</th>
                        <th>Tertinggi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($points as $point)
                        <tr>
                            <td>{{ date('d-m-Y', strtotime($point['date'])) }}</td>
                            <td>{{ $point['event'] }}</td>
                            <td>{{ $point['point'] }}</td>
                            <td>{{ $point['lowest'] }}</td>
                            <td>{{ $point['highest'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row no-print">
        <div class="col-xs-12">
            <button class="btn btn-xs btn-primary" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        
    });

    function pay(id)
    {
    	$.ajax({
    		url:"{{ URL::to('perpindahan') }}/"+id+"/bayar",
    		type:"PUT",
    		success:function()
    		{
    			window.location = "{{ URL::to('perpindahan') }}/"+id;
    		}
    	});
    }
</script>
@stop