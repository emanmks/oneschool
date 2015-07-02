@extends('templates/base')

@section('content')

{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/verticaltabs/bootstrap.vertical-tabs.min.css') }}
{{ HTML::style('assets/chosen/chosen.css') }}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Profile Siswa
        <small>{{ $student->name }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Profile</a></li>
        <li><a href="{{ URL::to('siswa') }}"><i class="active"></i> Siswa</a></li>
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
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="profile">           
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="mytooltip">
                                <a href="{{ URL::to('siswa') }}/{{ $student->id }}/edit" data-toggle="tooltip" data-placement="top" title="Klik Untuk Koreksi"><i class="fa fa-edit"></i></a>
                            </div>
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user"></i>   {{ $student->student->name }}
                                    <span class="pull-right text-muted small">Nama Lengkap</span>
                                    <input type="hidden" name="studentID" value="{{ $student->id }}">
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user"></i>   
                                    @if($student->student->sex == 'L') Laki-laki @else Perempuan @endif
                                    <span class="pull-right text-muted small">Jenis Kelamin</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-calendar"></i>   {{ $student->student->birthplace }}, {{ date('d-m-Y', strtotime($student->student->birthdate)) }}
                                    <span class="pull-right text-muted small">Tempat, Tgl Lahir</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user"></i>   {{ $student->student->religion }}
                                    <span class="pull-right text-muted small">Agama</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-home"></i>   {{ $student->student->address }}
                                    <span class="pull-right text-muted small">Alamat</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-phone"></i>   {{ $student->student->contact }}
                                    <span class="pull-right text-muted small">Kontak</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope"></i>   {{ $student->student->email }}
                                    <span class="pull-right text-muted small">Email</span>
                                </a>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="tab-pane fade" id="parent">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user"></i>  {{ $student->student->father_name }}
                                    <span class="pull-right text-muted small">Nama Ayah</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-institution"></i> {{ $student->student->father_occupation }}
                                    <span class="pull-right text-muted small">Pekerjaan Ayah</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-home"></i>   {{ $student->student->father_address }}
                                    <span class="pull-right text-muted small">Alamat Ayah</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-phone"></i>   {{ $student->student->father_contact }}
                                    <span class="pull-right text-muted small">Kontak Ayah</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope"></i>  {{ $student->student->father_email }}
                                    <span class="pull-right text-muted small">Email Ayah</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user"></i>   {{ $student->student->mother_name }}
                                    <span class="pull-right text-muted small">Nama Ibu</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-institution"></i> {{ $student->student->mother_occupation }}
                                    <span class="pull-right text-muted small">Pekerjaan Ibu</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-home"></i>   {{ $student->student->mother_address }}
                                    <span class="pull-right text-muted small">Alamat Ibu</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-phone"></i>   {{ $student->student->mother_contact }}
                                    <span class="pull-right text-muted small">Kontak Ibu</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope"></i>   {{ $student->student->mother_email }}
                                    <span class="pull-right text-muted small">Email Ibu</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="education">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="list-group">
                                @foreach($student->educations as $education)
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-institution"></i>  {{ $education->school->name }}
                                        <span class="pull-right text-muted small">Sekolah</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="course">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="mytooltip">
                                <a href="#" onclick="showFormUpdateIssue({{ $student->id }},{{ $student->issue }})" data-toggle="tooltip" data-placement="top" title="Klik Untuk Koreksi"><i class="fa fa-edit"></i></a>
                            </div>
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-barcode"></i> {{{ $student->issue or 'Tidak Terdaftar' }}}
                                    <span class="pull-right text-muted small">Nomor Pokok</span>
                                </a>
                            </div>
                            @foreach($student->placements as $placement)
                                <div class="mytooltip">
                                    <a href="#" onclick="showFormUpdateCourse({{ $placement->id }},{{ $placement->course_id }})" data-toggle="tooltip" data-placement="top" title="Klik Untuk Koreksi"><i class="fa fa-edit"></i></a>
                                    <a href="#" onclick="removePlacement({{ $placement->id }})" data-toggle="tooltip" data-placement="top" title="Klik Untuk Hapus"><i class="fa fa-trash-o"></i></a>
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-institution"></i>   {{ $placement->course->name }}
                                        <span class="pull-right text-muted small">Nama Kelas</span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-calendar"></i> {{ $placement->course->course_days }}
                                        <span class="pull-right text-muted small">Hari Belajar</span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-database"></i>   {{ $placement->course->capacity }}
                                        <span class="pull-right text-muted small">Kapasitas</span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-database"></i>   {{ $placement->course->placements->count() }}
                                        <span class="pull-right text-muted small">Jumlah Siswa</span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="fa fa-check"></i>   @if($placement->course->availability) Buka @else Tutup @endif
                                        <span class="pull-right text-muted small">Status</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="academic">
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
                </div>
                <div class="tab-pane fade" id="finance">
                    <div class="row">
                        <div class="col-xs-12">
                            Komponen Biaya Bimbingan
                            <div class="text-center mytooltip">
                                <a href="#" onclick="showFormUpdateReceivable({{ $student->receivable->id }},'{{ number_format($student->receivable->billable,2,",",".") }}','{{ number_format($student->receivable->receivable,2,",",".") }}','{{ number_format($student->receivable->balance,2,",",".") }}')" data-toggle="tooltip" data-placement="top" title="Klik Untuk Koreksi"><i class="fa fa-edit"></i> Koreksi</a>&nbsp;&nbsp;&nbsp;
                                <a href="#" onclick="showFormCreateInstallments({{ $student->receivable->id }})" data-toggle="tooltip" data-placement="top" title="Klik Untuk Buat Jadwal Angsuran"><i class="fa fa-flash"></i> Angsuran</a>&nbsp;&nbsp;&nbsp;
                                <a href="#" onclick="makeItCash({{ $student->receivable->id }})" data-toggle="tooltip" data-placement="top" title="Klik untuk Pembayaran Langsung Lunas"><i class="fa fa-money"></i> Tunai</a>
                            </div>

                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tags"></i>   Rp{{ number_format($student->receivable->registration->registration_cost,2,",",".") }}
                                    <span class="pull-right text-muted small">PDF</span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tags"></i>   Rp{{ number_format($student->receivable->total,2,",",".") }}
                                    <span class="pull-right text-muted small">Total Biaya</span>
                                    <input type="hidden" id="receivable-total-{{ $student->receivable->id }}" value="{{ $student->receivable->total }}">
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tags"></i>   Rp{{ number_format($student->receivable->total - $student->receivable->billable,2,",",".") }}
                                    <span class="pull-right text-muted small">Total Potongan</span>
                                    <input type="hidden" id="receivable-receivable-{{ $student->receivable->id }}" value="{{ $student->receivable->receivable }}">
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tags"></i>   Rp{{ number_format($student->receivable->billable,2,",",".") }}
                                    <span class="pull-right text-muted small">Biaya yang Dibebankan</span>
                                    <input type="hidden" id="receivable-billable-{{ $student->receivable->id }}" value="{{ $student->receivable->billable }}">
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tags"></i>   Rp{{ number_format($student->receivable->balance,2,",",".") }}
                                    <span class="pull-right text-muted small">Sisa Beban Biaya Belum  Terbayar</span>
                                    <input type="hidden" id="receivable-balance-{{ $student->receivable->id }}" value="{{ $student->receivable->balance }}">
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tags"></i>   Rp{{ number_format($student->receivable->receivable,2,",",".") }}
                                    <span class="pull-right text-muted small">Potensi Pendapatan</span>
                                    <input type="hidden" id="receivable-receivable-{{ $student->receivable->id }}" value="{{ $student->receivable->receivable }}">
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tags"></i>   @if($student->receivable->payment == 'Cash') Bayar Tunai @else Angsur @endif
                                    <span class="pull-right text-muted small">Metode Pembayaran</span>
                                </a>
                            </div>

                            <div class="text-center mytooltip">
                                <a href="#" onclick="showFormCreateReductions({{ $student->receivable->id }})" data-toggle="tooltip" data-placement="top" title="Klik untuk Tambah Potongan"><i class="fa fa-plus"></i> Tambah</a>&nbsp;&nbsp;
                            </div>
                            <table class="table table-condensed">
                                <thead>
                                    <tr class="success">
                                        <th colspan="4"><center>Potongan yang diperoleh</center></th>
                                    </tr>
                                    <tr class="warning">
                                        <th>No</th>
                                        <th>Jenis Potongan</th>
                                        <th>Nilai Potongan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter = 1; ?>
                                    @foreach($student->receivable->reductions as $reduction)
                                        <tr>
                                            <td>{{ $counter }}</td>
                                            <td>{{ $reduction->reductable->name }}</td>
                                            <td>
                                                @if($reduction->reductable->discount)
                                                    @if($reduction->reductable->discount > 0)
                                                        {{ $reduction->reductable->discount }}%
                                                    @endif
                                                @elseif($reduction->reductable->nominal)
                                                    @if($reduction->reductable->nominal > 0)
                                                        <small>
                                                            Rp{{ number_format($reduction->reductable->nominal,2,",",".") }}                              
                                                        </small>
                                                    @endif
                                                @else
                                                    Rp{{{ number_format($reduction->reductable->nominal,2,",",".") }}}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="mytooltip">
                                                    <a href="#" onclick="removeReduction({{ $reduction->id }})" data-toggle="tooltip" data-placement="top" title="Klik Untuk Batalkan">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $counter += 1; ?>
                                    @endforeach
                                </tbody>
                            </table>

                            <table class="table table-condensed">
                                <thead>
                                    <tr class="success">
                                        <th colspan="6"><center>Jadwal Angsuran</center></th>
                                    </tr>
                                    <tr class="warning">
                                        <th>Angsuran</th>
                                        <th>Jadwal</th>
                                        <th>Nominal</th>
                                        <th>Sisa</th>
                                        <th>Lunas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $counter = 1; ?>
                                    @foreach($student->receivable->installments as $installment)
                                        <tr>
                                            <td>Ke-{{ $counter }}</td>
                                            <td>
                                                {{ date('d-m-Y', strtotime($installment->schedule)) }}
                                            </td>
                                            <td>
                                                Rp{{ number_format($installment->total,2,",",".") }}
                                            </td>
                                            <td>
                                                Rp{{ number_format($installment->balance,2,",",".") }}
                                            </td>
                                            <td>
                                                @if($installment->balance == 0)
                                                    <span class="badge bg-green">Yes</span>
                                                @else
                                                    <span class="badge bg-red">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="mytooltip">
                                                    <a href="#" onclick="showFormUpdateInstallment({{ $installment->id }},'{{ $installment->schedule }}','{{ number_format($installment->total,2,",",".") }}','{{ number_format($installment->balance,2,",",".") }}')" data-toggle="tooltip" data-placement="top" title="Klik Untuk Koreksi">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @if($installment->paid <> '1')
                                                        <a href="#" onclick="removeInstallment({{ $installment->id }})" data-toggle="tooltip" data-placement="top" title="Klik Untuk Hapus">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $counter += 1; ?>
                                    @endforeach   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="earning">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-condensed">
                                <thead>
                                    <tr class="success">
                                        <th colspan="4"><center>Riwayat Pembayaran</center></th>
                                    </tr>
                                    <tr class="warning">
                                        <th>Tanggal</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $counter = 1; ?>
                                    @foreach($student->earnings as $earning)
                                        <tr>
                                            <td>{{ date('d-m-Y',strtotime($earning->earning_date)) }}</td>
                                            <td>
                                                <a href="{{ URL::to('penerimaan') }}/{{ $earning->id }}" class="btn btn-xs btn-primary">{{ $earning->code }}</a>
                                            </td>
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
                                        <?php $counter += 1; ?>
                                    @endforeach  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="handbook">  
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-condensed">
                                <thead>
                                    <tr class="success">
                                        <th colspan="2"><center>Jatah Handbook</center></th>
                                    </tr>
                                    <tr class="warning">
                                        <th>Judul Handbook</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($handbooks as $handbook)
                                        <tr>
                                            <td>{{ $handbook->title }}</td>
                                            <td>Rp{{ number_format($handbook->price,2,",",".") }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-12">
                            <table class="table table-condensed">
                                <thead>
                                    <tr class="success">
                                        <th colspan="3"><center>Riwayat Pengambilan Handbook</center></th>
                                    </tr>
                                    <tr class="warning">
                                        <th>Tanggal Ambil</th>
                                        <th>Judul Handbook</th>
                                        <th>Yang Menyerahkan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if($student->retrievals)
                                        @foreach($student->retrievals as $retrieval)
                                            <tr>
                                                <td>
                                                    {{ date('d-m-Y', strtotime($retrieval->retrieval_date)) }}
                                                </td>
                                                <td>{{ $retrieval->handbook->title }}</td>
                                                <td>{{ $retrieval->employee->name }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3"><small class="text-center">Belum Ada data untuk Ditampilkan</small></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="timeline">
                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="timeline">
                                @foreach($student->timelines as $timeline)
                                    <li>
                                        <i class="fa fa-comment bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{ date('d-m-Y H:i:s', strtotime($timeline->created_at)) }}</span>
                                            <h3 class="timeline-header"><a href="#">{{ $timeline->informable->name }}</a></h3>
                                            <div class="timeline-body">
                                                {{ $timeline->content }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <ul class="nav nav-tabs tabs-right">
                <li class="active"><a href="#profile" data-toggle="tab"><i class="fa fa-user"></i> Biodata</a></li>
                <li><a href="#parent" data-toggle="tab"><i class="fa fa-user"></i> Orang Tua</a></li>
                <li><a href="#education" data-toggle="tab"><i class="fa fa-mortar-board"></i> Pendidikan</a></li>
                <li><a href="#course" data-toggle="tab"><i class="fa fa-suitcase"></i> Program Bimbingan</a></li>
                <li><a href="#academic" data-toggle="tab"><i class="fa fa-suitcase"></i> Akademik</a></li>
                <li><a href="#finance" data-toggle="tab"><i class="fa fa-tags"></i> Beban Biaya</a></li>
                <li><a href="#earning" data-toggle="tab"><i class="fa fa-money"></i> Pembayaran</a></li>
                <li><a href="#handbook" data-toggle="tab"><i class="fa fa-book"></i> Handbook</a></li>
                <li><a href="#timeline" data-toggle="tab"><i class="fa fa-twitter"></i> Timeline</a></li>
            </ul>
        </div>
    </div>
</section>

<!-- Form Update Issue [modal]
===================================== -->
<div id="formUpdateIssue" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Koreksi Nomor Pokok</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="generation">Nomor Pokok</label>
                        <div class="col-lg-5">
                            <input type="hidden" name="issue_id" value="0">
                            <input type="text" name="issue" class="form-control">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="updateIssue()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Update Issue [modal] -->

<!-- Form Update Course [modal]
===================================== -->
<div id="formUpdateCourse" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Koreksi Kelas</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="courses">Kelas Baru</label>
                        <div class="col-lg-7">
                            <input type="hidden" value="0" name="placement_id">
                            <select class="form-control" name="courses">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }} / {{ $course->course_days }} / {{ $course->generation->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="updateCourse()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Update Course [modal] -->

<!-- Form Update Receivable [modal]
===================================== -->
<div id="formUpdateReceivable" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Koreksi Biaya Bimbingan</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="receivable">Total Beban Biaya</label>
                        <div class="col-lg-5">
                            <input type="hidden" name="receivable_id">
                            <input type="text" name="billable" class="form-control currency">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="receivable">Potensi Pendapatan</label>
                        <div class="col-lg-5">
                            <input type="text" name="receivable" class="form-control currency">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="balance">Sisa Belum Terbayar</label>
                        <div class="col-lg-5">
                            <input type="text" name="balance" class="form-control currency">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="updateReceivable()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Update Receivable [modal] -->

<!-- Form Update Installment [modal]
===================================== -->
<div id="formUpdateInstallment" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Koreksi Angsuran</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="schedule">Jadwal Bayar</label>
                        <div class="col-lg-5">
                            <input type="hidden" name="installment_id">
                            <input type="text" name="schedule" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="amount">Nilai Angsuran</label>
                        <div class="col-lg-5">
                            <input type="text" name="amount" class="form-control currency">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="installment_balance">Sisa Angsuran</label>
                        <div class="col-lg-5">
                            <input type="text" name="installment_balance" class="form-control currency">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="updateInstallment()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Update Installment [modal] -->

<!-- Form Create Installments [modal]
===================================== -->
<div id="formCreateInstallments" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Buat Angsuran</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="counts">Jumlah Angsuran</label>
                        <div class="col-lg-5">
                            <input type="hidden" name="receivableid" value="0">
                            <select class="form-control" name="counts">
                                <option value="1">1 Kali Angsuran</option>
                                <option value="2">2 Kali Angsuran</option>
                                <option value="3">3 Kali Angsuran</option>
                                <option value="4">4 Kali Angsuran</option>
                                <option value="5">5 Kali Angsuran</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="first_installment">Angsuran I</label>
                        <div class="col-lg-5">
                            <input type="text" name="first_installment" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="createInstallments()" data-dismiss="modal" aria-hidden="true">Generate Angsuran</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Create Installments [modal] -->

<!-- Form Create Reduction [modal]
===================================== -->
<div id="formCreateReductions" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Tambahkan Potongan</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="discounts">Diskon</label>
                        <div class="col-lg-7">
                            <input type="hidden" name="idreceivable" value="0">
                            <input type="hidden" name="updated_total" value="0">
                            <select class="chzn-select form-control" name="discounts" style="width:300px;" multiple>
                                @foreach($discounts as $discount)
                                    <option value="{{ $discount->id }}#{{ $discount->nominal }}">{{ $discount->name }} dari {{ $discount->given_by }} Nilai Rp{{ number_format($discount->nominal,2,",",".") }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="promotions">Promo</label>
                        <div class="col-lg-7">
                            <select class="chzn-select form-control" name="promotions" style="width:300px;" multiple>
                                @foreach($promotions as $promotion)
                                   <option value="{{ $promotion->id }}#{{ $promotion->discount }}#{{ $promotion->nominal }}">
                                      {{ $promotion->name }} / 
                                      Diskon: {{ $promotion->discount }}% / 
                                      Nominal: Rp{{ number_format($promotion->nominal,2,',','.') }}
                                   </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="vouchers">Voucher</label>
                        <div class="col-lg-7">
                            <select class="chzn-select form-control" name="vouchers" style="width:300px;" multiple>
                                @foreach($vouchers as $voucher)
                                    <option value="{{ $voucher->id }}#{{ $voucher->discount }}#{{ $voucher->nominal }}">
                                        {{ $voucher->name }} / 
                                        Diskon: {{ $voucher->discount }}% / 
                                        Nominal: Rp{{ number_format($voucher->nominal,2,',','.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="charges">Charges</label>
                        <div class="col-lg-7">
                            <select class="chzn-select form-control" name="charges" style="width:300px;" multiple>
                                @foreach($charges as $charge)
                                    <option value="{{ $charge->id }}#{{ $charge->nominal }}">
                                        {{ $charge->name }} / 
                                        Nilai: Rp{{ number_format($charge->nominal,2,',','.') }}
                                    </option>
                                @endforeach
                             </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_reduction">Total Potongan</label>
                        <div class="col-lg-4">
                            <input name="updated_reduction" type="text" value="0" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_billable">Biaya yg Dibebankan</label>
                        <div class="col-lg-4">
                            <input name="updated_billable" type="text" value="0" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_receivable">Potensi Pendapatan</label>
                        <div class="col-lg-4">
                            <input name="updated_receivable" type="text" value="0" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="updated_balance">Sisa Biaya Bimbingan</label>
                        <div class="col-lg-4">
                            <input name="updated_balance" type="text" value="0" class="form-control">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="clear" class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary" onClick="createReductions()" data-dismiss="modal" aria-hidden="true">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Create Reduction [modal] -->

{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/currency.js') }}
{{ HTML::script('assets/chosen/chosen.jquery.js') }}

<script type="text/javascript">
    $(function(){
        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });
        $('[name=schedule]').datepicker({format:"yyyy-mm-dd"});
        $('[name=first_installment]').datepicker({format:"yyyy-mm-dd"});

        $(".chzn-select").chosen();

        $('select[name=promotions]').chosen().change(function(){
            updateReduction();
        });

        $('select[name=vouchers]').chosen().change(function(){
            updateReduction();
        });

        $('select[name=charges]').chosen().change(function(){
          updateReduction();
        });

        $('select[name=discounts]').chosen().change(function(){
          updateReduction();
        });
    });

    function updateReduction()
    { 
        var total = parseFloat($('[name=updated_total]').val());
        var billable = parseFloat($('[name=updated_billable]').val());
        var reduction = parseFloat($('[name=updated_reduction]').val());
        var receivable =  parseFloat($('[name=updated_receivable]').val());
        var balance =  parseFloat($('[name=updated_balance]').val());

        var discounts = $('select[name=discounts]').val();
        var promotions = $('select[name=promotions]').val();
        var vouchers = $('select[name=vouchers]').val();
        var charges = $('select[name=charges]').val();

        if(discounts)
        {
            for (var i = discounts.length - 1; i >= 0; i--) {
                var val = '';

                val = discounts[i];

                val = val.split("#");
                
                reduction += parseFloat(val[1]);
                billable -= parseFloat(val[1]);
                receivable -= parseFloat(val[1]);
                balance -= parseFloat(val[1]);
            };
        }

        if(vouchers)
        {
            for (var i = vouchers.length - 1; i >= 0; i--) {
                var val = '';

                val = vouchers[i];

                val = val.split("#");

                if(parseFloat(val[1]) != 0.00)
                {
                   reduction += (parseFloat(val[1])/100)*total;
                   billable -= (parseFloat(val[1])/100)*total;
                   receivable -= (parseFloat(val[1])/100)*total;
                   balance -= (parseFloat(val[1])/100)*total;
                }
                else
                {
                   reduction += parseFloat(val[2]);
                   billable -= parseFloat(val[2])
                   receivable -= parseFloat(val[2])
                   balance -= parseFloat(val[2]);
                }
            };
        }

        if(promotions)
        {
            for (var i = promotions.length - 1; i >= 0; i--) {
                var val = "";

                val = promotions[i];

                val = val.split("#");

                if(parseFloat(val[1]) != 0.00)
                {
                   reduction += (parseFloat(val[1])/100)*total;
                   billable -= (parseFloat(val[1])/100)*total;
                   receivable -= (parseFloat(val[1])/100)*total;
                   balance -= (parseFloat(val[1])/100)*total;
                }
                else
                {
                   reduction += parseFloat(val[2]);
                   billable -= parseFloat(val[2]);
                   receivable -= parseFloat(val[2]);
                   balance -= parseFloat(val[2]);
                }
            };
        }

        if(charges)
        {
            for (var i = charges.length - 1; i >= 0; i--) {
                var val = "";

                val = charges[i];

                val = val.split("#");

               receivable -= parseFloat(val[1]);
            };
        }

        $('[name=updated_billable]').val(billable);
        $('[name=updated_receivable]').val(receivable);
        $('[name=updated_balance]').val(balance);
        $('[name=updated_reduction]').val(reduction);
    }

    function showFormUpdateIssue(id,issue)
    {
        $('#formUpdateIssue').modal('show');

        $('[name=issue_id]').val(id);
        $('[name=issue]').val(issue);
    }

    function showFormUpdateCourse(placement_id,course_id)
    {
        $('#formUpdateCourse').modal('show');

        $('[name=placement_id]').val(placement_id);
        $('[name=courses]').val(course_id);
    }

    function showFormUpdateReceivable(id,billable,receivable,balance,payment)
    {
        $('#formUpdateReceivable').modal('show');

        $('[name=receivable_id]').val(id);
        $('[name=billable]').val(billable);
        $('[name=receivable]').val(receivable);
        $('[name=balance]').val(balance);
    }

    function showFormCreateReductions(id)
    {
        $('#formCreateReductions').modal('show');
        $('[name=idreceivable]').val(id);

        var total = parseFloat($('#receivable-total-'+id).val());
        var billable = parseFloat($('#receivable-billable-'+id).val());
        var reduction = total - billable;
        var receivable =  parseFloat($('#receivable-receivable-'+id).val());
        var balance =  parseFloat($('#receivable-balance-'+id).val());

        $('[name=updated_billable]').val(billable);
        $('[name=updated_reduction]').val(reduction);
        $('[name=updated_receivable]').val(receivable);
        $('[name=updated_balance]').val(balance);
        $('[name=updated_reduction]').val(reduction);
    }

    function showFormUpdateInstallment(id,schedule,amount,balance)
    {
        $('#formUpdateInstallment').modal('show');

        $('[name=installment_id]').val(id);
        $('[name=schedule]').val(schedule);
        $('[name=amount]').val(amount);
        $('[name=installment_balance]').val(balance);
    }

    function showFormCreateInstallments(receivable_id)
    {
        $('#formCreateInstallments').modal('show');

        $('[name=receivableid]').val(receivable_id);
    }

    function updateIssue()
    {
        var id = $('[name=studentID]').val();
        var issue_id = $('[name=issue_id]').val();
        var new_issue = $('[name=issue]').val();

        if(issue_id != '0' && new_issue != '')
        {
            $.ajax({
                url:"{{ URL::to('nomorpokok') }}/"+issue_id,
                type:"PUT",
                data:{issue:new_issue},
                success:function(){
                    window.location = "{{ URL::to('siswa') }}/"+id;
                }
            });
        }
    }

    function updateCourse()
    {
        var id = $('[name=studentID]').val();
        var placement_id = $('[name=placement_id]').val();
        var course_id = $('[name=courses]').val();

        if(placement_id != '0' && course_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('penempatan') }}/"+placement_id,
                type:"PUT",
                data:{course_id:course_id},
                success:function(){
                    window.location = "{{ URL::to('siswa') }}/"+id;
                }
            });
        }
    }

    function removePlacement(id)
    {
        var student = $('[name=studentID]').val();

        $.ajax({
            url:"{{ URL::to('penempatan') }}/"+id,
            type:"DELETE",
            success:function(){
                window.location = "{{ URL::to('siswa') }}/"+student;
            }
        });
    }

    function updateReceivable()
    {
        var student = $('[name=studentID]').val();
        var receivable_id = $('[name=receivable_id]').val();
        var billable = $('[name=billable]').val();
        var receivable = $('[name=receivable]').val();
        var balance = $('[name=balance]').val();balance

        if(receivable_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('receivable') }}/"+receivable_id,
                type:"PUT",
                data:{billable:billable, receivable:receivable, balance:balance},
                success:function(){
                    window.location = "{{ URL::to('siswa') }}/"+student;
                }
            });
        }
    }

    function createInstallments()
    {
        var student = $('[name=studentID]').val();
        var receivable_id = $('[name=receivableid]').val();
        var counts = $('[name=counts]').val();
        var first_installment = $('[name=first_installment]').val();

        if(receivable_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('angsuran') }}",
                type:"POST",
                data:{receivable_id:receivable_id, counts:counts, first_installment:first_installment},
                success:function(){
                    window.location = "{{ URL::to('siswa') }}/"+student;
                }
            });
        }
    }

    function updateInstallment()
    {
        var student = $('[name=studentID]').val();
        var installment_id = $('[name=installment_id]').val();
        var schedule = $('[name=schedule]').val();
        var total = $('[name=amount]').val();
        var balance = $('[name=installment_balance]').val();

        if(installment_id != '0' && schedule != '')
        {
            $.ajax({
                url:"{{ URL::to('angsuran') }}/"+installment_id,
                type:"PUT",
                data:{schedule:schedule, total:total, balance:balance},
                success:function(){
                    window.location = "{{ URL::to('siswa') }}/"+student;
                }
            });
        }
    }

    function removeInstallment(id)
    {
        var student = $('[name=studentID]').val();

        if(confirm("Yakin akan menghapus data Angsuran ini?!"))
        {
            $.ajax({
                url:"{{ URL::to('angsuran') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('siswa') }}/"+student;
                }
            });
        }
    }

    function makeItCash(id)
    {
        var student = $('[name=studentID]').val();

        if(confirm("Yakin akan menjadikan tagihan ini menjadi Tunai?!"))
        {
            $.ajax({
                url:"{{ URL::to('receivable') }}/"+id+"/cash",
                type:"PUT",
                success:function(){
                    window.location = "{{ URL::to('siswa') }}/"+student;
                }
            });
        }
    }

    function createReductions()
    {
        var student = $('[name=studentID]').val();

        var receivable_id = $('[name=idreceivable]').val();

        var billable = $('[name=updated_billable]').val();
        var receivable = $('[name=updated_receivable]').val();
        var balance = $('[name=updated_balance]').val();

        var discounts = $('[name=discounts]').val();
        var promotions = $('[name=promotions]').val();
        var vouchers = $('[name=vouchers]').val();
        var charges = $('[name=charges]').val();

        if(receivable_id != '0')
        {
            $.ajax({
                url:"{{ URL::to('reduction') }}",
                type:"POST",
                data:{
                    receivable_id:receivable_id, billable:billable, receivable:receivable, balance:balance,
                    discounts:discounts, promotions:promotions, vouchers:vouchers, charges:charges},
                success:function(){
                    window.location = "{{ URL::to('siswa') }}/"+student;
                }
            });
        }
    }

    function removeReduction(id)
    {
        student = $('[name=studentID]').val();

        if(confirm("Yakin akan membatalkan Potongan ini?!"))
        {
            $.ajax({
                url:"{{ URL::to('reduction') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('siswa') }}/"+student;
                }
            });
        }
    }
</script>
@stop