@extends('templates/base')

@section('content')

{{ HTML::style('assets/css/datepicker/datepicker.css') }}

<section class="content-header">
    <h1>
       	Edit Biodata Siswa <small>{{ $student->student->name }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('/') }}"><i class="fa fa-desktop"></i> Home</a></li>
        <li><a href="#"> Manajemen</a></li>
        <li><a href="{{ URL::to('siswa') }}"><i class="active"></i> Siswa</a></li>
    </ol>
</section>

<section class="content">
	<div class="row">
		@if(Session::has('message'))
            <div class="alert alert-info alert-dismissable">
                <i class="fa fa-warning"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('message') }}
            </div>
        @endif
	</div>
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
            	<div class="box-header">
            		<h2 class="box-title">
            			Biodata Siswa
            		</h2>
            	</div>
                <div class="box-body">
                	<div class="row">
                		<div class="col-md-12">
                			<form class="form form-horizontal">
                				<div class="form-group">
	                				<label class="col-md-4 col-md-4 control-label" for="name">Nama Lengkap</label>
	                				<div class="col-md-8">
	                					<input type="hidden" name="issue" value="{{ $student->id }}">
	                					<input class="form-control" type="text" name="name" value="{{ $student->student->name }}">
	                				</div>
	                			</div>

	                			<div class="form-group">
	                				<label class="col-md-4 col-md-4 control-label" for="sex">Jenis Kelamin</label>
		                			<div class="col-md-4">
		                				<select class="form-control" type="text" name="sex">
			                				<option value="L">Laki-laki</option>
			                				<option value="P">Perempuan</option>
			                			</select>
			                			<script type="text/javascript">
			                				$('select[name=sex]').val("{{ $student->student->sex }}");
			                			</script>
		                			</div>
	                			</div>

	                			<div class="form-group">
	                				<label class="col-md-4 control-label" for="birthplace">Tempat Lahir</label>
	                				<div class="col-md-7">
	                					<input class="form-control" type="text" name="birthplace" value="{{ $student->student->birthplace }}">
	                				</div>
	                			</div>

	                			<div class="form-group">
	                				<label class="col-md-4 control-label" for="birthdate">Tanggal Lahir</label>
	                				<div class="col-md-4">
	                					<input class="form-control" type="text" name="birthdate" value="{{ $student->student->birthdate }}">
	                				</div>
                			
	                			</div>

	                			<div class="form-group">
	                				<label class="col-md-4 control-label" for="religion">Agama</label>
		                			<div class="col-md-4">
		                				<select class="form-control" type="text" name="religion">
			                				<option value="Islam">Islam</option>
				                            <option value="Katolik">Katolik</option>
				                            <option value="Kristen">Kristen</option>
				                            <option value="Hindu">Hindu</option>
				                            <option value="Budha">Budha</option>
				                            <option value="Kong Hu Chu">Kong Hu Chu</option>
			                			</select>
		                			</div>
		                			<script type="text/javascript">
		                				$('select[name=religion]').val("{{ $student->student->religion }}");
		                			</script>
	                			</div>

	                			<div class="form-group">
	                				<label class="col-md-4 control-label" for="address">Alamat</label>
		                			<div class="col-md-8">
		                				<input name="address" class="form-control" type="text" value="{{ $student->student->address }}">
		                			</div>
	                			</div>

	                			<div class="form-group">
	                				<label class="col-md-4 control-label" for="contact">Kontak</label>
                					<div class="col-md-5">
                						<input class="form-control" type="text" name="contact" value="{{ $student->student->contact }}">
                					</div>
	                			</div>

	                			<div class="form-group">
	                				<label class="col-md-4 control-label" for="email">Email</label>
                					<div class="col-md-5">
                						<input class="form-control" type="text" name="email" value="{{ $student->student->email }}">
                					</div>
	                			</div>

	                			<div class="form-group">
	                				<label class="col-md-4 control-label" for="email"></label>
                					<div class="col-md-5">
                						
                					</div>
	                			</div>

	                			<br/><br/>
                			</form>
                				<div class="form-group">
	                				<label class="col-md-4 control-label" for="email"></label>
                					<div class="col-md-5">
                						<button class="btn btn-success" onclick="update({{ $student->student->id }})"><i class="fa fa-floppy-o"></i> Simpan Perubahan</button>
                					</div>
	                			</div>
                		</div>
                	</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box box-success">
            	<div class="box-header">
            		<h2 class="box-title">
            			Data Orang Tua
            		</h2>
            	</div>
                <div class="box-body">
                	<div class="row">
                		<div class="col-md-12">
                			<form class="form form-horizontal">
                				<div class="form-group">
                					<label class="col-md-4 control-label" for="father_name">Nama Ayah</label>
                					<div class="col-md-7">
                						<input class="form-control" type="text" name="father_name" value="{{ $student->student->father_name }}">
                					</div>
                				</div>

                				<div class="form-group">
                					<label class="col-md-4 control-label" for="father_occupation">Pekerjaan Ayah</label>
                					<div class="col-md-6">
                						<input class="form-control" type="text" name="father_occupation" value="{{ $student->student->father_occupation }}" data-provide="typeahead">
                					</div>
                				</div>

                				<div class="form-group">
                					<label class="col-md-4 control-label" for="father_address">Alamat Ayah</label>
		                			<div class="col-md-8">
		                				<input class="form-control" name="father_address" type="text" value="{{ $student->student->father_address }}">
		                			</div>
                				</div>

                				<div class="form-group">
                					<label class="col-md-4 control-label" for="father_contact">Kontak Ayah</label>
                					<div class="col-md-5">
                						<input class="form-control" type="text" name="father_contact" value="{{ $student->student->father_contact }}">
                					</div>
                				</div>

                				<div class="form-group">
                					<label class="col-md-4 control-label" for="father_email">Email Ayah</label>
                					<div class="col-md-6">
                						<input class="form-control" type="text" name="father_email" value="{{ $student->student->father_email }}">
                					</div>
                				</div>

                				<div class="form-group">
                					<label class="col-md-4 control-label" for="mother_name">Nama Ibu</label>
                					<div class="col-md-7">
                						<input class="form-control" type="text" name="mother_name" value="{{ $student->student->mother_name }}">
                					</div>
                				</div>
                				<div class="form-group">
                					<label class="col-md-4 control-label" for="mother_occupation">Pekerjaan Ibu</label>
                					<div class="col-md-6">
                						<input class="form-control" type="text" name="mother_occupation" value="{{ $student->student->mother_occupation }}" data-provide="typeahead">
                					</div>
                				</div>
                				<div class="form-group">
                					<label class="col-md-4 control-label" for="mother_address">Alamat Ibu</label>
                					<div class="col-md-8">
                						<input class="form-control" name="mother_address" type="text" value="{{ $student->student->mother_address }}">
                					</div>
                				</div>
                				<div class="form-group">
                					<label class="col-md-4 control-label" for="mother_contact">Kontak Ibu</label>
                					<div class="col-md-6">
                						<input class="form-control" type="text" name="mother_contact" value="{{ $student->student->mother_contact }}">
                					</div>
                				</div>
                				<div class="form-group">
                					<label class="col-md-4 control-label" for="mother_email">Email Ibu</label>
                					<div class="col-md-6">
                						<input class="form-control" type="text" name="mother_email" value="{{ $student->student->mother_email }}">
                					</div>
                				</div>
                			</form>

                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}
{{ HTML::script('assets/js/plugins/typeahead/bootstrap-typeahead.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $('.mytooltip').tooltip({
            selector: "[data-toggle=tooltip]",
            container: "body"
        });

        $('[name=birthdate]').datepicker({format:"yyyy-mm-dd"});

        $('input[name=father_occupation]').typeahead({
	        source : function(query, process){
	            return $.get("{{ URL::to('loadfatherjobs') }}/"+query, function(response){
	                response = $.parseJSON(response);
	                var sourceArr = []; 
	                for(var i = 0; i < response.length; i++)
	                {
	                    sourceArr.push(response[i].father_occupation);
	                }
	                return process(sourceArr);
	            })
	        },
	        highlighter : function(item){
	            var item = ''
	                    + "<div class='typeahead_wrapper' style='height:30px'>"
	                    + "<div class='typeahead_labels'>"
	                    + "<div class='typeahead_primary'>" + item + "</div>"
	                    + "</div>"
	                    + "</div>";
	            return item;
	        },
	        updater : function(item){
	            return item;
	        }
	    });

	    $('input[name=mother_occupation]').typeahead({
	        source : function(query, process){
	            return $.get("{{ URL::to('loadmotherjobs') }}/"+query, function(response){
	                response = $.parseJSON(response);
	                var sourceArr = []; 
	                for(var i = 0; i < response.length; i++)
	                {
	                    sourceArr.push(response[i].mother_occupation);
	                }
	                return process(sourceArr);
	            })
	        },
	        highlighter : function(item){
	            var item = ''
	                    + "<div class='typeahead_wrapper' style='height:30px'>"
	                    + "<div class='typeahead_labels'>"
	                    + "<div class='typeahead_primary'>" + item + "</div>"
	                    + "</div>"
	                    + "</div>";
	            return item;
	        },
	        updater : function(item){
	            return item;
	        }
	    });
    });

	function update(id)
	{
		var issue = $('[name=issue]').val();
		var name = $('[name=name]').val();
		var sex = $('[name=sex]').val();
		var birthplace = $('[name=birthplace]').val();
		var birthdate = $('[name=birthdate]').val();
		var religion = $('[name=religion]').val();
		var address = $('[name=address]').val();
		var contact = $('[name=contact]').val();
		var email = $('[name=email]').val();

		var father_name = $('[name=father_name]').val();
		var father_occupation = $('[name=father_occupation]').val();
		var father_address = $('[name=father_address]').val();
		var father_contact = $('[name=father_contact]').val();
		var father_email = $('[name=father_email]').val();

		var mother_name = $('[name=mother_name]').val();
		var mother_occupation = $('[name=mother_occupation]').val();
		var mother_address = $('[name=mother_address]').val();
		var mother_contact = $('[name=mother_contact]').val();
		var mother_email = $('[name=mother_email]').val();

		$.ajax({
			url:"{{ URL::to('siswa') }}/"+id,
			type:"PUT",
			data:{
				name:name,sex:sex,birthplace:birthplace,birthdate:birthdate,
				religion:religion,address:address,contact:contact,email:email,
				father_name:father_name,father_occupation:father_occupation,father_address:father_address,
				father_contact:father_contact,father_email:father_email,
				mother_name:mother_name,mother_occupation:mother_occupation,mother_address:mother_address,
				mother_contact:mother_contact,mother_email:mother_email
			},
			success:function(){
				window.location = "{{ URL::to('siswa') }}/"+issue+"/edit";
			}
		});
	}
</script>
@stop