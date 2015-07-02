@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>
        Rangkuman Pendaftaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="{{ URL::to('pendaftaran') }}"><i class="active"></i> Pendaftaran</a></li>
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
        	<small>
                <table class="table table-condensed">
                    <thead>
                        <tr class="success">
                            <th><i class="fa fa-files-o"></i>  Rangkuman Pendaftaran</th>
                            <th><small class="pull-right">Tanggal : {{ date('d-m-Y', strtotime($registration->registration_date)) }}</small></th>
                        </tr>
                    </thead>
                </table>
            </small>
        </div>
    </div>

    <div class="row invoice-info">
    	<small>
            <div class="col-xs-4 invoice-col">
                Biodata Siswa
                <address>
                    <strong>{{ $registration->student->name }}</strong>  [@if($registration->student->sex == 'L') L @else P @endif]<br/>
                    <small>TTL</small> : {{ $registration->student->birthplace }}, {{ date('d-m-Y', strtotime($registration->student->birthdate)) }} <br/>
                    <small>Agama</small> : {{ $registration->student->religion }} <br/>
                    <small>Alamat</small> : {{ $registration->student->address }} <br/>
                    <small>Kontak</small> : {{ $registration->student->contact }} <br/>
                    <small>Email</small> : {{ $registration->student->email }} 
                </address>
            </div>

            <div class="col-xs-4 invoice-col">
                Ayah
                <address>
                    <small>Nama</small> : {{ $registration->student->father_name }}<br/>
                    <small>Pekerjaan</small> : {{ $registration->student->father_occupation }}<br/>
                    <small>Alamat</small> : {{ $registration->student->father_address }} <br/>
                    <small>Kontak</small> : {{ $registration->student->father_contact }} <br/>
                    <small>Email</small> : {{ $registration->student->father_email }}
                </address>
            </div>

            <div class="col-xs-4 invoice-col">
                Ibu
                <address>
                    <small>Nama</small> : {{ $registration->student->mother_name }}<br/>
                    <small>Pekerjaan</small> : {{ $registration->student->mother_occupation }}<br/>
                    <small>Alamat</small> : {{ $registration->student->mother_address }} <br/>
                    <small>Kontak</small> : {{ $registration->student->mother_contact }} <br/>
                    <small>Email</small> : {{ $registration->student->mother_email }}
                </address>
            </div>   
        </small>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <small>
                <table class="table table-condensed">
                    <thead>
                        <tr class="success">
                            <th width="30%">Nomor Pokok</th>
                            <th width="30%">Tingkatan</th>
                            <th width="30%">Sekolah Asal</th>
                        </tr>
                        <tr class="warning">
                            <th>{{ $registration->issue->issue }}</th>
                            <th>{{ $registration->issue->generation->name }}</th>
                            <th>{{ $registration->issue->education->school->name or 'N/A' }}</th>
                        </tr>
                    </thead>
                </table>
            </small>
        </div>
    </div>

    <div class="row">
    	<small>
            <div class="col-xs-6">
                <table class="table table-condensed">
                    <thead>
                        <tr class="success">
                            <th colspan="2"><center>Biaya</center></th>
                        </tr>
                        <tr class="warning">
                            <th>Keterangan</th>
                            <th>Nilai (Rp)</th>
                        </tr>   
                    </thead>

                    <tbody>
                        <tr>
                            <td>Biaya Pendaftaran</td>
                            <td><strong>Rp{{ number_format($registration->registration_cost,2,",",".") }}</strong></td>
                        </tr>
                        <tr>
                            <td>Biaya Bimbingan</td>
                            <td><strong>Rp{{ number_format($registration->receivable->total,2,",",".") }}</strong></td>
                        </tr>
                        @foreach($registration->receivable->reductions as $reduction)
                            @if($reduction->reductable_type != 'Charge')
                            <tr>
                                <td>
                                    <small>{{ $reduction->reductable->name }} [Rp{{ number_format($reduction->reductable->nominal,2,",",".")}}]</small>
                                </td>
                                <td></td>
                            </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td>Total Potongan yang diberikan</td>
                            <td><strong>(Rp{{ number_format($reduction = $registration->receivable->total - $registration->receivable->billable,2,",",".")}})</strong></td>
                        </tr>
                        <tr>
                            <td>Total Biaya yang Dibebankan</td>
                            <td><strong>Rp{{ number_format($registration->receivable->billable,2,",",".") }}</strong></td>
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
                            <th>Angsuran</th>
                            <th>Jadwal</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach($registration->receivable->installments as $installment)
                            <tr>
                                <td>Angsuran Ke-{{ $counter }}</td>
                                <td>{{ date('d-m-Y', strtotime($installment->schedule)) }}</td>
                                <td>Rp{{ number_format($installment->total,2,",",".") }}</td>
                            </tr>
                            <?php $counter += 1; ?>
                        @endforeach    
                    </tbody>
                </table>
            </div>   
        </small>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <small>
                <strong>Kontrol Pengambilan Handbook</strong><br/>
                @foreach($handbooks as $handbook)
                    <div class="col-xs-4">{{ $handbook->title }} [....]</div>
                @endforeach
            </small>
        </div>
    </div>

    <br/><br/>

    <div class="row">
        <small>
            <div class="col-xs-1"></div>
            <div class="col-xs-5">
                <center>
                    Front Office<br/><br/><br/>
                    {{ $registration->employee->name }} 
                </center> 
            </div>
            <div class="col-xs-5">
                <center>
                    Direktur Cabang<br/><br/><br/>
                    Nur Indah Aseani, SS
                </center>
            </div>
            <div class="col-xs-1"></div>
        </small>
    </div>

    <div class="row no-print">
        <div class="col-xs-12">
            <button class="btn btn-primary" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>
@stop