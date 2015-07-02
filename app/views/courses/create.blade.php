@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/daterangepicker/daterangepicker-bs3.css') }}
{{ HTML::style('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}
{{ HTML::style('assets/css/iCheck/all.css') }}

<section class="content-header">
    <h1>
        Kelas Baru
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('kelas') }}"><i class="active"></i> Kelas</a></li>
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
                            <label class="col-lg-3 control-label" for="classification">Jenis Kelas</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="classification">
                                    <option value="0">--Pilih Jenis Kelas</option>
                                    @foreach($classifications as $classification)
                                        <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="program">Program Kursus</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="program">
                                    <option value="0">--Pilih Program Bimbingan</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="generation">Tingkatan Kelas</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="generation">
                                    <option value="0">--Pilih Tingkatan</option>
                                    @foreach($generations as $generation)
                                        <option value="{{ $generation->id }}">{{ $generation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">Nama Kelas</label>
                            <div class="col-lg-4">
                                <input name="name" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="days">Hari Belajar</label>
                            <div class="col-lg-9">
                                <input type="checkbox" name="days" class="flat-red" value="Senin"> Senin &nbsp;
                                <input type="checkbox" name="days" class="flat-red" value="Selasa"> Selasa &nbsp;
                                <input type="checkbox" name="days" class="flat-red" value="Rabu"> Rabu &nbsp;
                                <input type="checkbox" name="days" class="flat-red" value="Kamis"> Kamis &nbsp;
                                <input type="checkbox" name="days" class="flat-red" value="Jum`at"> Jumat &nbsp;
                                <input type="checkbox" name="days" class="flat-red" value="Sabtu"> Sabtu &nbsp;
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="costs">Biaya Bimbingan</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control currency" name="costs" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="capacity">Daya Tampung</label>
                            <div class="col-lg-1">
                                <input type="text" class="form-control" name="capacity">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="availability">Status</label>
                            <div class="col-lg-9">
                                <input type="checkbox" name="availability" id="availability" class="flat-red" value="1" checked> <span id="availability_status">Terbuka / Menerima Siswa</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="description">Informasi/Penjelasan Tambahan</label>
                            <div class="col-lg-8">
                                <textarea name="description" class="textarea" placeholder="Tambahkan Informasi dan Penjelasan disini"style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Page-Level Plugin Scripts -->
{{ HTML::script('assets/js/plugins/daterangepicker/daterangepicker.js') }}
{{ HTML::script('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}
{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}
{{ HTML::script('assets/js/currency.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('input[name=daterange]').daterangepicker();
        $('.textarea').wysihtml5();
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $('#availability').on("ifClicked", function(){
            if(!this.checked){
                $('#availability_status').html('Terbuka / Menerima Siswa');
            }else{
                $('#availability_status').html('Tertutup / Tidak Menerima Siswa');
            }
        });

        $('.currency').keyup(function(){
            $(this).val(formatCurrency($(this).val()));
        });
    });

    function create()
    {
        var classification = $('select[name=classification]').val();
        var program = $('select[name=program]').val();
        var generation = $('select[name=generation]').val();
        var name = $('input[name=name]').val();
        var days = [];
        var costs = $('input[name=costs]').val();
        var capacity = $('input[name=capacity]').val();
        var status = '0';
        var description = $('textarea[name=description]').val(); 

        $('input:checkbox[name=days]:checked').each(function(){
            days.push($(this).val());
        });

        $('input:checkbox[name=availability]:checked').each(function(){
            status = $(this).val();
        });

        if(classification != '0' && program != '0' && name != '' && days.length > 0)
        {
            $.ajax({
                url:"{{ URL::to('kelas') }}",
                type:'POST',
                data:{
                        classification : classification, 
                        program : program,
                        generation : generation,
                        name : name,
                        days : days,
                        costs : costs,
                        capacity : capacity, 
                        status : status, 
                        description : description},
                success:function(){
                    window.location = "{{ URL::to('kelas') }}";
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