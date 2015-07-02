@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datepicker/datepicker.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}

<section class="content-header">
    <h1>
        Form Penon-aktifan Siswa
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Kesiswaan</a></li>
        <li><a href="{{ URL::to('keluar') }}"><i class="active"></i> Non Aktif</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <button class="btn btn-success" onclick="create()"><i class="fa fa-floppy-o"></i> Simpan</button>
                    </div>
                </div>

                <div class="box-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="course">Pilih Kelas Asal</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="course" onchange="loadStudents()">
                                    <option value="0">--Pilih Kelas Asal</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="student">Pilih Siswa</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="student">
                                    <option value="0">--Pilih Siswa</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="date">Tanggal Resmi</label>
                            <div class="col-lg-2">
                                <input name="date" type="text" class="form-control" data-provide="datepicker" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="classifications">Alasan Keluar</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="classifications">
                                    <option value="0">--Pilih Alasan Keluar</option>
                                    @foreach($classifications as $classification)
                                        <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="fine">Biaya / Denda (Jika ada)</label>
                            <div class="col-lg-2">
                                <input name="fine" type="text" class="form-control currency" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="returnment">Pengembalian Biaya (Jika ada)</label>
                            <div class="col-lg-2">
                                <input name="returnment" type="text" class="form-control currency" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="employees">Diproses Oleh</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="employees">
                                    <option value="0">--Pilih Pegawai</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="comments">Informasi/Penjelasan Tambahan</label>
                            <div class="col-lg-8">
                                <textarea name="comments" class="textarea form-control" placeholder="Tambahkan Informasi dan Penjelasan disini"style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Page-Level Plugin Scripts -->
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}
{{ HTML::script('assets/js/currency.js') }}

<script type="text/javascript">
    $(document).ready(function() {
    	$('input[name=date]').datepicker({format:'yyyy-mm-dd',autoclose:true});
        $('.textarea').wysihtml5();
        
        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });
    });

    function loadStudents()
    {
        var course_id = $('select[name=course]').val();

        $.ajax({
            url:"{{ URL::to('loadstudents') }}/"+course_id,
            type:"GET",
            dataType:"json",
            success:function(students){
                $('select[name=student]').html('');

                $('select[name=student]').append("<option value='0'>Pilih Siswa</option>");

                for (var i = students.length - 1; i >= 0; i--) {
                    $('[name=student]').append("<option value='"+students[i].issue.id+"'>"+students[i].issue.issue+" / "+students[i].issue.student.name+"</option>");
                };
            }
        });
    }

    function create()
    {
        var student = $('[name=student]').val();
        var date = $('[name=date]').val();
        var classification = $('[name=classifications]').val();
        var employee = $('[name=employees]').val();
        var fine = $('[name=fine]').val();
        var returnment = $('[name=returnment]').val();
        var comments = $('[name=comments]').val();

        if(student != '0' && classification != '0')
        {
            $.ajax({
                url:"{{ URL::to('keluar') }}",
                type:'POST',
                data:{issue_id:student, 
                	date:date,
                	classification_id:classification,
                    employee_id:employee,
                	fine:fine,
                	returnment:returnment, 
                	comments:comments},
                success:function(e){
                    if(e.status == 'succeed')
                    {
                        window.location = "{{ URL::to('keluar') }}";
                    }
                    else
                    {
                        window.alert("Gagal Memproses!!");
                    }
                }
            });
        }
        else
        {
            window.alert('Mohon Lengkapi Inputan Anda!');
        }
    }
</script>
@stop