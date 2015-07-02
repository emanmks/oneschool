@extends('templates/base')

@section('content')

<!-- Page-Level Plugin CSS - Tables -->
{{ HTML::style('assets/css/datatables/dataTables.bootstrap.css') }}

<section class="content-header">
    <h1>Nilai Siswa</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Akademik</a></li>
        <li><a href="{{ URL::to('quiz') }}"><i class="active"></i> Quiz</a></li>
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

            <div class="box">
                <div class="box-body table-responsive">
                    <button class="btn btn-primary" onclick="showFormSelectCourse()"><i class="fa fa-plus"></i> Input Nilai Quiz</button>
                    <div class="clear-fix"><br/></div>
                    <table class="table table-bordered table-hover table-condensed" id="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kelas</th>
                                <th>Bidang Studi</th>
                                <th>Materi</th>
                                <th>Tentor</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($quizzes as $quiz)
                                <tr>
                                	<td>{{ date('d-m-Y', strtotime($quiz->quiz_date)) }}</td>
                                	<td>{{ $quiz->course->name }}</td>
                                	<td>{{ $quiz->subject->name }}</td>
                                	<td>
                                		<a href="{{ URL::to('quiz') }}/{{ $quiz->id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Klik untuk Detail">
                                			{{ $quiz->name }}
                                		</a>
                                	</td>
                                	<td>{{ $quiz->employee->name }}</td>
                                	<td>
                                		<a href="{{ URL::to('quiz') }}/{{ $quiz->id }}/edit" class="btn btn-primary btn-circle"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Klik untuk Koreksi"></i></a>
                                		<button class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Klik untuk Hapus" onclick="destroy($quiz->id)"><i class="fa fa-trash-o"></i></button>
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

<!-- Form Select Course [modal]
===================================== -->
<div id="formSelectCourse" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Input Nilai Quiz</h3>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="coursess">Pilih Kelas</label>
                        <div class="col-lg-8">
                           <select class="form-control" name="courses">
                               <option value="0">--Pilih Kelas</option>
                               @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }} / {{ $course->course_days }}</option>
                               @endforeach
                           </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button class="btn btn-primary" onClick="showFormCreateQuizPoint()" data-dismiss="modal" aria-hidden="true">Pilih Kelas</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Form Select Course [modal] -->

<!-- Page-Level Plugin Scripts - Tables -->
{{ HTML::script('assets/js/plugins/datatables/jquery.dataTables.js') }}
{{ HTML::script('assets/js/plugins/datatables/dataTables.bootstrap.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').dataTable();
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

    });

    function showFormSelectCourse()
    {
        $('#formSelectCourse').modal('show');
    }

    function showFormCreateQuizPoint()
    {
        var course_id = $('[name=courses]').val();

        window.location = "{{ URL::to('quiz') }}/create/"+course_id;
    }

    function destroy(id)
    {
    	if(confirm("Yakin akan membatalkan Quiz ini?!"))
    	{
    		$.ajax({
	            url:"{{ URL::to('quiz') }}/"+id,
	            type:"DELETE",
	            success:function(){
	                window.location = "{{ URL::to('quiz') }}";
	            },
	            error:function(){
	            	window.alert("Terjadi Kesalahan : Gagal membatalkan Quiz!");
	            }
	        });
    	}
    }
</script>
@stop