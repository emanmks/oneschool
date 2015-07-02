@extends('templates/base')

@section('content')

<section class="content-header">
    <h1>Laporan - Laporan</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="laporan"><i class="active"></i> Laporan</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12"><center><h2 class="page-header">Laporan Detail</h2></center></div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/siswa-per-tingkatan') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Siswa per Tingkatan
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/siswa-per-kelas') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Siswa per Kelas
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/siswa-per-sekolah') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Siswa per Sekolah Asal
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/siswa-per-program') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Siswa per Program
                </a>
            </center>
        </div>
    </div><br/><br/>
    <div class="row">
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/siswa-masuk') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Siswa Masuk
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/siswa-keluar') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Siswa Keluar
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/estimasi') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Estimasi Bulanan
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/penerimaan') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Penerimaan Bulanan
                </a>
            </center>
        </div>
    </div><br/><br/>
    <div class="row">
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/menunggak') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Siswa Menunggak
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/pemotongan') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Penerima Potongan
                </a>
            </center>
        </div>
    </div><br/><br/>

    <div class="row">
        <div class="col-xs-12"><center><h2 class="page-header">Laporan Rekap</h2></center></div>
    </div>

    <div class="row">
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/rekap-tingkat') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Rekap Tingkatan Periodik
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/rekap-kelas') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Rekap Kelas Periodik
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/rekap-sekolah-periodik') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Rekap Sekolah Periodik
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/rekap-sekolah-tingkat') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Rekap Sekolah per Tingkatan 
                </a>
            </center>
        </div>
    </div><br/><br/>

    <div class="row">
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/rekap-sirkulasi-periodik') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Sirkulasi Periodik
                </a>
            </center>
        </div>
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/rekap-sirkulasi-tingkat') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Sirkulasi per Tingkatan
                </a>
            </center>
        </div>
        <!--
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/rekap-potongan-periodik') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Rekap Potongan Periodik
                </a>
            </center>
        </div> 
        <div class="col-xs-3">
            <center>
                <a href="{{ URL::to('laporan/rekap-potongan-tingkat') }}">
                    <i class="fa fa-3x fa-files-o"></i><br/> Rekap Potongan per Tingkatan
                </a>
            </center>
        </div>-->
    </div><br/><br/>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>
@stop