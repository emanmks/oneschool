<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            {{ HTML::image('assets/img/avatar5.png', 'User Avatar', array('class' => 'img-circle')) }}
        </div>
        <div class="pull-left info">
            <p>Halo, K' {{ Auth::user()->username }}</p>

            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Cari..."/>
            <span class="input-group-btn">
                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        @if($menu == 'dashboard')<li class="active">@else<li>@endif
            <a href="{{ URL::to('/') }}"><i class="fa fa-desktop fa-fw"></i> Dashboard</a>
        </li>

        @if($menu == 'registration')<li class="active">@else<li>@endif
            <a href="{{ URL::to('pendaftaran') }}"><i class="fa fa-book fa-fw"></i> Pendaftaran</a>
        </li>

        @if($menu == 'project')<li class="treeview active">@else<li class="treeview">@endif
            <a href="#">
                <i class="fa fa-rocket"></i>
                <span>Manajemen Project</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ URL::to('project') }}">Data Project</a>
                </li>
                <li>
                    <a href="{{ URL::to('program') }}">Program Kursus</a>
                </li>
                <li>
                    <a href="{{ URL::to('kelas') }}">Data Kelas</a>
                </li>
                <li>
                    <a href="{{ URL::to('handbook') }}">Handbook</a>
                </li>
                <li>
                    <a href="{{ URL::to('kegiatan') }}">Agenda</a>
                </li>
                <li>
                    <a href="{{ URL::to('voucher') }}">Voucher</a>
                </li>
                <li>
                    <a href="{{ URL::to('promo') }}">Promo</a>
                </li>
                <li>
                    <a href="{{ URL::to('diskon') }}">Diskon</a>
                </li>
                <li>
                    <a href="{{ URL::to('charge') }}">Charge</a>
                </li>
            </ul>
        </li>

        @if($menu == 'data')<li class="treeview active">@else<li class="treeview">@endif
            <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Manajemen Data</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ URL::to('cabang') }}">Cabang</a>
                </li>
                <li>
                    <a href="{{ URL::to('ruangan') }}">Ruangan</a>
                </li>
                <li>
                    <a href="{{ URL::to('jam') }}">Jam Belajar</a>
                </li>
                <li>
                    <a href="{{ URL::to('sekolah') }}">Sekolah</a>
                </li>
                @if(Auth::user()->role == 'Super Admin')
                <li>
                    <a href="{{ URL::to('user') }}">User</a>
                </li>
                @endif
                <li>
                    <a href="{{ URL::to('klasifikasi') }}">Klasifikasi</a>
                </li>
                <li>
                    <a href="{{ URL::to('aset') }}">Aset Perusahaan</a>
                </li>
                <li>
                    <a href="{{ URL::to('mitra') }}">Mitra / Kontak Person</a>
                </li>
            </ul>
        </li>

        @if($menu == 'student')<li class="treeview active">@else<li class="treeview">@endif
            <a href="#">
                <i class="fa fa-user"></i>
                <span>Kesiswaan</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ URL::to('siswa') }}">Kesiswaan</a>
                </li>
                <li>
                    <a href="{{ URL::to('perpindahan') }}">Perpindahan</a>
                </li>
                <li>
                    <a href="{{ URL::to('keluar') }}">Keluar</a>
                </li>
                <li>
                    <a href="{{ URL::to('pengambilan') }}">Pengambilan Handbook</a>
                </li>
            </ul>
        </li>

        @if($menu == 'academic')<li class="treeview active">@else<li class="treeview">@endif
            <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Akademik</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ URL::to('jadwal') }}">Jadwal Bimbingan</a>
                </li>
                <li>
                    <a href="{{ URL::to('presensi') }}">Presensi Siswa</a>
                </li>
                <li>
                    <a href="{{ URL::to('partisipasi') }}">Partisipasi Kegiatan</a>
                </li>
                <li>
                    <a href="{{ URL::to('quiz') }}">Quiz</a>
                </li>
                <li>
                    <a href="{{ URL::to('nilai') }}">Nilai</a>
                </li>
                <li>
                    <a href="{{ URL::to('penguasaan') }}">Penguasaan Materi</a>
                </li>
            </ul>
        </li>

        @if($menu == 'finance')<li class="treeview active">@else<li class="treeview">@endif
            <a href="#">
                <i class="fa fa-money"></i>
                <span>Keuangan</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ URL::to('angsuran') }}">Angsuran</a>
                </li>
                <li>
                    <a href="{{ URL::to('penerimaan') }}">Penerimaan</a>
                </li>
                <li>
                    <a href="{{ URL::to('pengeluaran') }}">Pengeluaran</a>
                </li>
                <li>
                    <a href="{{ URL::to('pengembalian') }}">Pengembalian</a>
                </li>
                <li>
                    <a href="{{ URL::to('denda') }}">Denda</a>
                </li>
            </ul>
        </li>

        @if($menu == 'employee')<li class="treeview active">@else<li class="treeview">@endif
            <a href="#">
                <i class="fa fa-group"></i>
                <span>Kepegawaian</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ URL::to('karyawan') }}">Pegawai</a>
                </li>
                <li>
                    <a href="{{ URL::to('mengajar') }}">Mengajar</a>
                </li>
                <li>
                    <a href="{{ URL::to('payroll') }}">Payroll</a>
                </li>
                <li>
                    <a href="{{ URL::to('income') }}">Incomes</a>
                </li>
                <li>
                    <a href="{{ URL::to('deduction') }}">Deductions</a>
                </li>
            </ul>
        </li>

        @if($menu == 'report')<li class="active">@else<li>@endif
            <a href="{{ URL::to('laporan') }}"><i class="fa fa-file fa-fw"></i> Laporan-laporan</a>
        </li>

        @if($menu == 'setup')<li class="active">@else<li>@endif
            <a href="{{ URL::to('pengaturan') }}"><i class="fa fa-gear fa-fw"></i> Pengaturan</a>
        </li>
    </ul>
</section>
<!-- /.sidebar -->