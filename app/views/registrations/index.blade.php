@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>
        Pendaftaran
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="{{ URL::to('pendaftaran') }}"><i class="active"></i> Pendaftaran</a></li>
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
                    <a href="{{ URL::to('pendaftaran') }}/create" class="btn btn-success"><i class="fa fa-plus"></i> Pendaftaran Baru</a>
                    <div class="clear-fix"><br/></div>

                    <table class="table table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>Pendaftar</th>
                                <th>Tgl Daftar</th>
                                <th>Pendaftaran</th>
                                <th>PDF</th>
                                <!--<th>Beban Biaya</th>-->
                                <th>Front Office</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($registrations as $registration)
                            <tr>
                                <td>
                                    <div class="pull-left image mytooltip">
                                        <img src="{{ URL::to('assets/img/students') }}/{{ $registration->student->photo }}" class="img-polaroid" alt="Student Avatar">
                                        <a href="{{ URL::to('pendaftaran') }}/{{ $registration->id }}" data-toggle="tooltip" data-placement="right" title="Klik untuk lihat Rangkuman Pendaftaran">
                                            {{ $registration->issue->issue }} /
                                            {{ $registration->issue->student->name }}
                                        </a>
                                    </div>

                                </td>
                                <td>{{ date('d-m-Y', strtotime($registration->registration_date)) }}</td>
                                <td>
                                    @if($registration->classification->name == 'Siswa Pindahan')
                                        <span class="badge bg-yellow">{{ $registration->classification->name }} dari {{ $registration->base->name }}</span>
                                    @else
                                        <span class="badge bg-yellow">{{ $registration->classification->name }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-blue">Rp{{ number_format($registration->registration_cost,2,',',',') }}</span>
                                    @if($registration->cost_is_paid == 0)
                                        <a href="#" onclick="purchaseCost({{ $registration->id }})" data-toggle="tooltip" data-placement="top" title="Bayar Biaya Pendaftaran"><i class="fa fa-money"></i></a>
                                    @endif
                                </td>
                                <!--
                                <td><span class="badge bg-green">Rp{{ number_format($registration->receivable->billable,2,',','.')}}</span></td>
                                -->
                                <td>{{ $registration->employee->name }}</td>
                                <td>
                                    <div class="mytooltip">
                                        <a href="{{ URL::to('pendaftaran') }}/{{ $registration->id }}/edit" class="btn btn-circle btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Koreksi"><i class="fa fa-edit"></i></a>
                                        @if(Auth::user()->role == 'Super Admin')
                                            <button class="btn btn-circle btn-danger" onclick="destroy({{ $registration->id }})" data-toggle="tooltip" data-placement="top" title="Batalkan!!!"><i class="fa fa-trash-o"></i></button>
                                        @endif
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
    });

    function destroy(id)
    {
        if(confirm("Yakin akan membatalkan pendaftaran?!"))
        {
            $.ajax({
                url:"{{ URL::to('pendaftaran') }}/"+id,
                type:"DELETE",
                success:function(){
                    window.location = "{{ URL::to('pendaftaran') }}";
                }
            });
        }
    }

    function purchaseCost(id)
    {
        if(confirm("Anda akan menerima Biaya Pendaftaran?!"))
        {
            $.ajax({
                url:"{{ URL::to('pendaftaran') }}/"+id+"/biaya",
                type:"PUT",
                success:function(response){
                    window.location = "{{ URL::to('penerimaan') }}/"+response.code;
                }
            });
        }
    }
</script>
@stop