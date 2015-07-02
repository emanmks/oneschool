@extends('templates/base')

@section('content')

{{ HTML::style('assets/css/bs-wizard/bootstrap-wizard.css') }}
{{ HTML::style('assets/chosen/chosen.css') }}
{{ HTML::style('assets/css/iCheck/all.css') }}
{{ HTML::style('assets/css/datepicker/datepicker.css') }}

<section class="content-header">
   <h1>
      Pendaftaran Baru
   </h1>
   <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-desktop"></i> Home</a></li>
      <li><a href="#"><i class="active"></i> Pendaftaran</a></li>
      <li><a href="{{ URL::to('pendaftaran/create') }}"><i class="active"></i> Baru</a></li>
   </ol>
</section>

<section class="content">
    <button id="open-wizard" class="btn btn-primary">
      Mulai Pendaftaran
    </button>

    <input type="hidden" value="0" name="registration_id">
    <input type="hidden" value="0" name="issue_id">

    <div class="wizard" id="registration-wizard" data-title="Pendaftaran Siswa">
         <div class="wizard-card" data-cardname="classification">
            <h3>Jenis Pendaftaran</h3>

            <div class="wizard-input-section">
                <p>Pilih Jenis Pendaftaran</p>
                <div class="form-group">
                    <div class="col-sm-6">
                        <select class="form-control" name="classification" onchange="classificationEffect()">
                           @foreach($classifications as $classification)
                              <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Cabang Asal</p>
                <div class="form-group">
                    <div class="col-sm-6">
                        <select class="form-control" name="location" disabled>
                           <option value="0">--Pilih Jika Siswa Pindahan</option>
                           @foreach($locations as $location)
                              <option value="{{ $location->id }}">{{ $location->name }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
               <p>Diterima Oleh</p>
               <div class="form-group">
                  <div class="col-sm-6">
                     <select class="form-control" name="employee">
                        @foreach($employees as $employee)
                           <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                     </select>

                     <script type="text/javascript">
                        $('select[name=employee]').val("{{ Auth::user()->employee_id }}");
                     </script>
                  </div>
               </div>
            </div>

            <div class="wizard-input-section">
               <p>Mendaftar Pada Tanggal</p>
               <div class="form-group">
                  <div class="col-sm-4">
                     <input type="text" class="form-control" name="registration_date" value="{{ date('Y-m-d') }}">
                  </div>
               </div>
            </div>

            <div class="wizard-input-section">
               <p>Teman yang merekomendasikan (SGS)</p>
               <div class="form-group">
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="recommenders" placeholder="Cari Teman" data-provide="typeahead">
                  </div>
               </div>
            </div>

            <div class="wizard-input-section">
               <p>Direkomendasikan Oleh</p>
               <div class="form-group">
                  <div class="col-sm-4">
                    <select class="form-control" name="partners" onchange="changeRecommender()">
                      <option value="0">Pilih Contact Person</option>
                      @foreach($partners as $partner)
                        <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                      @endforeach
                    </select>
                  </div>
               </div>
            </div>

            <input type="hidden" name="recommender_type" value="">
            <input type="hidden" name="recommender_id" value="0">

         </div>
         <div class="wizard-card" data-cardname="biodata">
            <h3>Biodata Siswa</h3>

            <div class="wizard-input-section">
               <p>Nama Lengkap</p>
               <div class="form-group">
                  <div class="col-sm-6">
                     <input type="hidden" name="student_id" value="0">
                     <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" data-provide="typeahead" autocomplete="off" data-validate="validateName">
                  </div>
               </div>
            </div>

            <div class="wizard-input-section">
                <p>Tempat Kelahiran</p>
                <div class="form-group">
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="birthplace" placeholder="Tempat Lahir">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Tanggal Lahir</p>
                <div class="form-group">
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="birthdate" placeholder="Tgl Lahir">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Agama</p>
                <div class="form-group">
                    <div class="col-sm-3">
                        <select name="religion" class="form-control">
                            <option value="Islam">Islam</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Kong Hu Chu">Kong Hu Chu</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Jenis Kelamin</p>
                <div class="form-group">
                    <div class="col-sm-3">
                        <select name="sex" class="form-control">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Alamat Tempat Tinggal</p>
                <div class="form-group">
                    <div class="col-sm-8">
                       <textarea class="form-control" name="address" placeholder="Alamat Lengkap"></textarea>
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Alamat Email</p>
                <div class="form-group">
                    <div class="col-sm-5">
                       <input type="text" class="form-control" name="email" placeholder="Email">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Kontak</p>
                <div class="form-group">
                    <div class="col-sm-5">
                       <input type="text" class="form-control" name="contact" placeholder="Kontak">
                    </div>
                </div>
            </div>
        </div>

        <div class="wizard-card" data-cardname="parent">
            <h3>Data Orang Tua</h3>

            <div class="wizard-input-section">
              <p>Cari Saudara</p>
              <div class="form-group">
                  <div class="col-sm-6">
                      <input type="text" class="form-control" name="sibling" data-provide="typeahead" autocomplete="off">
                  </div>
              </div>
            </div>

            <div class="wizard-input-section">
              <p>Nama Ayah</p>
              <div class="form-group">
                  <div class="col-sm-6">
                     <input type="text" class="form-control" name="father_name" placeholder="Nama Ayah">
                  </div>
              </div>
            </div>

            <div class="wizard-input-section">
                <p>Alamat Ayah</p>
                <div class="form-group">
                    <div class="col-sm-8">
                        <textarea class="form-control" name="father_address" placeholder="Alamat Ayah"></textarea>
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Pekerjaan Ayah</p>
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="father_occupation" data-provide="typeahead" autocomplete="off">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Kontak Ayah</p>
                <div class="form-group">
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="father_contact" placeholder="Kontak Ayah">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Email Ayah</p>
                <div class="form-group">
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="father_email" placeholder="Email Ayah">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Nama Ibu</p>
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="mother_name" placeholder="Nama Ibu">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Alamat Ibu</p>
                <div class="form-group">
                    <div class="col-sm-8">
                        <textarea class="form-control" name="mother_address" placeholder="Alamat Ibu"></textarea>
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Pekerjaan Ibu</p>
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="mother_occupation" data-provide="typeahead">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Kontak Ibu</p>
                <div class="form-group">
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="mother_contact" placeholder="Kontak Ibu">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
                <p>Email Ibu</p>
                <div class="form-group">
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="mother_email" placeholder="Email Ibu">
                    </div>
                </div>
            </div>
        </div>

        <div class="wizard-card" data-cardname="education">
            <h3>Data Pendidikan</h3>

            <div class="wizard-input-section">
               <p>Tingkatan Kelas</p>
               <div class="form-group">
                  <div class="col-sm-4">
                     <select class="form-control" name="generation">
                        @foreach($generations as $generation)
                           <option value="{{ $generation->id }}">Kelas {{ $generation->name }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>

            <div class="wizard-input-section">
                <p>Cari Sekolah</p>
                <div class="form-group">
                    <div class="col-sm-8">
                        <input name="schools" class="form-control" data-provide="typeahead" autocomplete="off" data-validate="validateSchool">
                        <input type="hidden" name="school" value="0">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="wizard-card" data-cardname="courses">
            <h3>Program Bimbingan</h3>

            <div class="wizard-input-section">
               <p>Pilih Kelas</p>
               <div class="form-group">
                  <div class="col-sm-6">
                     <select class="chzn-select form-control" name="course" style="width:450px;" data-validate="validateCourses" multiple>
                        @foreach($courses as $course)
                           <option value="{{ $course->id }}#{{ $course->costs }}">
                              {{ $course->name }} / 
                              Biaya: Rp{{ number_format($course->costs,2,',','.') }} / 
                              Hari: {{ $course->course_days }} / 
                              Tingkat: {{ $course->generation->code }} / 
                              Jenis: {{ $course->classification->name }}
                           </option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>

            <div class="wizard-input-section">
               <p>Tentukan Nomor Pokok Siswa</p>
               <div class="form-group">
                  <div class="col-sm-3">
                     <input name="issue" type="text" class="form-control">
                  </div>
               </div>
            </div>
        </div>

        <div class="wizard-card" data-cardname="reductions">
            <h3>Potongan</h3>

            <div class="wizard-input-section">
               <p>Diskon / Rekomendasi</p>
               <div class="form-group">
                  <div class="col-sm-5">
                     <select class="chzn-select form-control" name="discounts" style="width:350px;" multiple>
                        @foreach($discounts as $discount)
                           <option value="{{ $discount->id }}#{{ $discount->nominal }}">{{ $discount->name }} dari {{ $discount->given_by }}, Nilai Rp{{ number_format($discount->nominal,2,",",".") }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>

            <div class="wizard-input-section">
               <p>Promo</p>
               <div class="form-group">
                  <div class="col-sm-8">
                     <select class="chzn-select form-control" name="promotions" style="width:350px;" multiple>
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
            </div>

            <div class="wizard-input-section">
               <p>Voucher</p>
               <div class="form-group">
                  <div class="col-sm-8">
                     <select class="chzn-select form-control" name="vouchers" style="width:350px;" multiple>
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
            </div>

            <div class="wizard-input-section">
               <p>Charges</p>
               <div class="form-group">
                  <div class="col-sm-8">
                     <select class="chzn-select form-control" name="charges" style="width:350px;" multiple>
                        @foreach($charges as $charge)
                           <option value="{{ $charge->id }}#{{ $charge->nominal }}">
                              {{ $charge->name }} / 
                              Nilai: Rp{{ number_format($charge->nominal,2,',','.') }}
                           </option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
        </div>

        <div class="wizard-card" data-cardname="installment">
            <h3>Pembayaran</h3>

            <div class="wizard-input-section">
                <p>Biaya Pendaftaran</p>
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="fee" value="50000">
                    </div>
                </div>
            </div>

            <div class="wizard-input-section">
              <p>Total Biaya Kursus</p>
              <div class="form-group">
                  <div class="col-sm-6">
                     <input type="text" class="form-control" name="total" value="0">
                  </div>
              </div>
            </div>

            <div class="wizard-input-section">
              <p>Total Potongan</p>
              <div class="form-group">
                <div class="col-sm-6">
                   <input type="text" class="form-control" name="reductions" value="0">
                </div>
              </div>
            </div>

            <div class="wizard-input-section">
              <p>Sisa Beban Biaya</p>
              <div class="form-group">
                  <div class="col-sm-6">
                      <input type="text" class="form-control" name="billable" value="0">
                  </div>
              </div>
            </div>

            <div class="wizard-input-section">
              <p>Pendapatan Bersih</p>
              <div class="form-group">
                  <div class="col-sm-6">
                      <input type="text" class="form-control" name="receivables" value="0">
                  </div>
              </div>
            </div>

            <div id="paymentSetup">
               <div class="wizard-input-section">
                  <p>Sistem Pembayaran</p>
                  <div class="form-group">
                     <div class="col-sm-6">
                        <select class="form-control" name="payment">
                           <option value="0">Langsung Lunas</option>
                           <option value="1">1 Kali Angsuran</option>
                           <option value="2">2 Kali Angsuran</option>
                           <option value="3">3 Kali Angsuran</option>
                           <option value="4">4 Kali Angsuran</option>
                           <option value="5">5 Kali Angsuran</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
        </div>

        <div class="wizard-error">
            <div class="alert alert-error">
               <strong>Uuuupps!!</strong> Terjadi Kesalahan.
               Reload ulang halaman, lalu Coba Ulangi Kembali
            </div>
        </div>

        <div class="wizard-failure">
            <div class="alert alert-error">
               <strong>Uuuupps!!</strong> Gagal mensubmit Data.
               Reload ulang halaman, lalu Coba Ulangi Kembali
            </div>
        </div>

        <div class="wizard-success">
            <div class="alert alert-success">
                <span class="create-server-name"></span>Pendaftaran <strong>SUKSES</strong>
            </div>

            <button class="btn btn-default" onclick="payment()">Terima Pembayaran</a>
            <span style="padding:0 10px">atau</span>
            <button class="btn btn-success" onclick="summary()">Lihat Summary Pendaftaran</a>
        </div>
    </div>

</section>

{{ HTML::script('assets/js/plugins/bs-wizard/bootstrap-wizard.js') }}
{{ HTML::script('assets/js/plugins/typeahead/bootstrap-typeahead.js') }}
{{ HTML::script('assets/chosen/chosen.jquery.js') }}
{{ HTML::script('assets/js/plugins/iCheck/icheck.min.js') }}
{{ HTML::script('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}

<script type="text/javascript">
    $(document).ready(function() {
        $.fn.wizard.logging = false;
        var wizard = $('#registration-wizard').wizard({
            keyboard : false,
            contentHeight : 550,
            contentWidth : 950,
            backdrop: 'static',
            submitUrl: "{{ URL::to('pendaftaran') }}",
        });

        $('#open-wizard').click(function(e) {
            e.preventDefault();
            wizard.show();
        });

        wizard.on('closed', function() {
            wizard.reset();
        });

        wizard.on("reset", function() {
            wizard.modal.find(':input').val('').removeAttr('disabled');
            wizard.modal.find('.form-group').removeClass('has-error').removeClass('has-succes');
        });

        wizard.on("submit", function(wizard) {

            $.ajax({
                 type: "POST",
                 url: wizard.args.submitUrl,
                 data: {
                     student_id:$('input[name=student_id]').val(),name:$('input[name=name]').val(),
                     sex:$('select[name=sex]').val(),birthdate:$('input[name=birthdate]').val(),
                     religion:$('select[name=religion]').val(),
                     address:$('textarea[name=address]').val(),contact:$('input[name=contact]').val(),
                     email:$('input[name=email]').val(),father_name:$('input[name=father_name]').val(),
                     father_occupation:$('input[name=father_occupation]').val(),
                     father_address:$('textarea[name=father_address]').val(),
                     father_contact:$('input[name=father_contact]').val(),
                     father_email:$('input[name=father_email]').val(),mother_name:$('input[name=mother_name]').val(),
                     mother_occupation:$('input[name=mother_occupation]').val(),
                     mother_address:$('textarea[name=mother_address]').val(),
                     mother_contact:$('input[name=mother_contact]').val(),mother_email:$('input[name=mother_email]').val(),
                     school:$('input[name=school]').val(),generation:$('select[name=generation]').val(),
                     major:$('select[name=major]').val(),classification:$('select[name=classification]').val(),
                     location:$('select[name=location]').val(),registration_date:$('input[name=registration_date]').val(),
                     fee:$('input[name=fee]').val(),recommender_type:$('input[name=recommender_type]').val(),
                     recommender_id:$('input[name=recommender_id]').val(),
                     employee:$('select[name=employee]').val(),generation:$('select[name=generation]').val(),
                     issue:$('input[name=issue]').val(),course:$('select[name=course]').val(),
                     total:$('input[name=total]').val(),billable:$('[name=billable]').val(),discounts:$('select[name=discounts]').val(),
                     promotions:$('select[name=promotions]').val(),vouchers:$('select[name=vouchers]').val(),
                     reductions:$('input[name=reductions]').val(),receivables:$('input[name=receivables]').val(),
                     charges:$('select[name=charges]').val(),payment:$('select[name=payment]').val()
                 },
                 dataType: "json"
             }).done(function(response) {
                  if(response.status == 'Succeed'){
                    wizard.submitSuccess();
                    wizard.hideButtons();
                    wizard.updateProgressBar(0);

                    $('input[name=registration_id]').val(response.registration_id);
                  }
                  else{
                    wizard.submitFailure();
                    wizard.hideButtons();
                    return 0;
                  }
             }).fail(function() {
                 wizard.submitFailure();
                 wizard.hideButtons();
             });

            setTimeout(function() {
                wizard.trigger("success");
                wizard.hideButtons();
                wizard._submitting = false;
                wizard.showSubmitCard("success");
                wizard.updateProgressBar(0);
            }, 2000);
        });

        wizard.el.find(".wizard-success .im-done").click(function() {
            wizard.hide();
            setTimeout(function() {
                wizard.reset(); 
            }, 250);
        });
    
        wizard.el.find(".wizard-success .recieve-payments").click(function() {
            wizard.reset();
        });

        $(".chzn-select").chosen();

        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-red',
            radioClass: 'iradio_flat-red'
        });

        $('input[name=sample_date]').datepicker({format:"yyyy-mm-dd"});
        $('input[name=birthdate]').datepicker({format:"yyyy-mm-dd"});
        $('input[name=registration_date]').datepicker({format:"yyyy-mm-dd"});

        $('input[name=schools]').typeahead({
            source : function(query, process){
                return $.get("{{ URL::to('loadschools') }}/"+query, function(response){
                    response = $.parseJSON(response);
                    var sourceArr = []; 
                    for(var i = 0; i < response.length; i++)
                    {
                        sourceArr.push(response[i].id +"#"+ response[i].name +"#"+ response[i].address);
                    }
                    return process(sourceArr);
                })
            },
            highlighter : function(item){
                var school = item.split('#');
                var item = ''
                        + "<div class='typeahead_wrapper'>"
                        + "<span class='typeahead_photo fa fa-2x fa-home'></span>"
                        + "<div class='typeahead_labels'>"
                        + "<div class='typeahead_primary'>" + school[1] + "</div>"
                        + "<div class='typeahead_secondary'>" + school[2] + "</div>"
                        + "</div>"
                        + "</div>";
                return item;
            },
            updater : function(item){
                var school = item.split('#');
                $('input[name=school]').val(school[0]);
                return school[1];
            }
        });

        $('input[name=name]').typeahead({
            source : function(query, process){
                return $.get("{{ URL::to('hardfilterstudents') }}/"+query, function(response){
                    response = $.parseJSON(response);
                    var sourceArr = []; 
                    for(var i = 0; i < response.length; i++)
                    {
                        sourceArr.push(
                            response[i].id +"#"+ response[i].name +"#"+ response[i].sex +"#"+ 
                            response[i].birthplace +"#"+ response[i].birthdate +"#"+ response[i].religion +"#"+ 
                            response[i].address +"#"+ response[i].contact +"#"+ response[i].email +"#"+ 
                            response[i].father_name +"#"+ response[i].father_occupation +"#"+ 
                            response[i].father_address +"#"+ response[i].father_contact +"#"+ response[i].father_email +"#"+ 
                            response[i].mother_name +"#"+ response[i].mother_occupation +"#"+ 
                            response[i].mother_address +"#"+ response[i].mother_contact +"#"+ response[i].mother_email
                            );
                    }
                    return process(sourceArr);
                })
            },
            highlighter : function(item){
                var student = item.split('#');
                var item = ''
                        + "<div class='typeahead_wrapper'>"
                        + "<span class='typeahead_photo fa fa-2x fa-user'></span>"
                        + "<div class='typeahead_labels'>"
                        + "<div class='typeahead_primary'>" + student[1] + "</div>"
                        + "<div class='typeahead_secondary'>" + student[3] + "-" + student[4] + "</div>"
                        + "</div>"
                        + "</div>";
                return item;
            },
            updater : function(item){
                var student = item.split('#');
                $('input[name=student_id]').val(student[0]);
                $('select[name=sex]').val(student[2]);
                $('input[name=birthplace]').val(student[3]);
                $('input[name=birthdate]').val(student[4]);
                $('select[name=religion]').val(student[5]);
                $('input[name=address]').val(student[6]);
                $('input[name=contact]').val(student[7]);
                $('input[name=email]').val(student[8]);
                $('input[name=father_name]').val(student[9]);
                $('input[name=father_occupation]').val(student[10]);
                $('input[name=father_address]').val(student[11]);
                $('input[name=father_contact]').val(student[12]);
                $('input[name=father_email]').val(student[13]);
                $('input[name=mother_name]').val(student[14]);
                $('input[name=mother_occupation]').val(student[15]);
                $('input[name=mother_address]').val(student[16]);
                $('input[name=mother_contact]').val(student[17]);
                $('input[name=mother_email]').val(student[18]);
                return student[1];
            }
         });

        $('input[name=recommenders]').typeahead({
            source : function(query, process){
                return $.get("{{ URL::to('softfilterstudents') }}/"+query, function(response){
                    //response = $.parseJSON(response);
                    var sourceArr = []; 
                    for(var i = 0; i < response.length; i++)
                    {
                        sourceArr.push(
                            response[i].id +"#"+ response[i].issue +"#"+ response[i].student_id +"#"+ response[i].student.name
                            );
                    }
                    return process(sourceArr);
                })
            },
            highlighter : function(item){
                var student = item.split('#');
                var item = ''
                        + "<div class='typeahead_wrapper'>"
                        + "<span class='typeahead_photo fa fa-2x fa-user'></span>"
                        + "<div class='typeahead_labels'>"
                        + "<div class='typeahead_primary'>" + student[1] + "</div>"
                        + "<div class='typeahead_secondary'>" + student[3] + "</div>"
                        + "</div>"
                        + "</div>";
                return item;
            },
            updater : function(item){
                var student = item.split('#');
                $('input[name=recommender_type]').val("Issue");
                $('input[name=recommender_id]').val(student[0]);
                return student[1]+ ' / ' +student[3];
            }
         });

        $('input[name=sibling]').typeahead({
            source : function(query, process){
                return $.get("{{ URL::to('hardfilterstudents') }}/"+query, function(response){
                    response = $.parseJSON(response);
                    var sourceArr = []; 
                    for(var i = 0; i < response.length; i++)
                    {
                        sourceArr.push(
                            response[i].id +"#"+ response[i].name +"#"+ response[i].sex +"#"+ 
                            response[i].birthplace +"#"+ response[i].birthdate +"#"+ response[i].religion +"#"+ 
                            response[i].address +"#"+ response[i].contact +"#"+ response[i].email +"#"+ 
                            response[i].father_name +"#"+ response[i].father_occupation +"#"+ 
                            response[i].father_address +"#"+ response[i].father_contact +"#"+ response[i].father_email +"#"+ 
                            response[i].mother_name +"#"+ response[i].mother_occupation +"#"+ 
                            response[i].mother_address +"#"+ response[i].mother_contact +"#"+ response[i].mother_email
                            );
                    }
                    return process(sourceArr);
                })
            },
            highlighter : function(item){
                var student = item.split('#');
                var item = ''
                        + "<div class='typeahead_wrapper'>"
                        + "<span class='typeahead_photo fa fa-2x fa-user'></span>"
                        + "<div class='typeahead_labels'>"
                        + "<div class='typeahead_primary'>" + student[1] + "</div>"
                        + "<div class='typeahead_secondary'>" + student[3] + "-" + student[4] + "</div>"
                        + "</div>"
                        + "</div>";
                return item;
            },
            updater : function(item){
                var student = item.split('#');
                $('input[name=father_name]').val(student[9]);
                $('input[name=father_occupation]').val(student[10]);
                $('input[name=father_address]').val(student[11]);
                $('input[name=father_contact]').val(student[12]);
                $('input[name=father_email]').val(student[13]);
                $('input[name=mother_name]').val(student[14]);
                $('input[name=mother_occupation]').val(student[15]);
                $('input[name=mother_address]').val(student[16]);
                $('input[name=mother_contact]').val(student[17]);
                $('input[name=mother_email]').val(student[18]);
                return student[1];
            }
        });
        
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

        $('select[name=course]').chosen().change(function(){
            updateCosts();
            suggestIssue();
        });

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
  function payment()
  {
      var issue_id = $('[name=issue_id]').val();
      window.location = "{{ URL::to('penerimaan') }}/"+issue_id;+"/create";
  }

  function summary()
  {
      var registration_id = $('[name=registration_id]').val();
      window.location = "{{ URL::to('pendaftaran') }}/"+registration_id;
  }

   function updateCosts()
   {
      // Deklarasi variabel costs
      // Ambil Value Course
      // Hitung panjang array Value
      // Lakukan perulangan
      // Jadikan setiap Value menjadi array menggunakan Split
      // update nilai costs
      // Bind nilai costs ke input costs

      // declare costs
      var costs = 0.00;

      // get value from select / chosen
      var courses = $('select[name=course]').val();

      // extracting value from select / chosen
      for (var i = courses.length - 1; i >= 0; i--) {
         
         var val = '';

         // get current queue/rows of data
         var val = courses[i];

         // turn it into an array
         val = val.split("#");

         // update costs value
         costs += parseFloat(val[1]);
      };

      // Bind it into input costs
      $('input[name=total]').val(costs);
      $('input[name=reductions]').val(0);
      $('input[name=costs]').val(costs);
      $('input[name=receivables]').val(costs);
   }

   function updateReduction()
   {
      // Deklarasi variabel reduction
      // Deklarasi variabel receivables
      // Ambil Value discounts
      // Ambil Value promotion
      // Ambil Value Voucher
      // Lakukan Perulangan untuk Extract value promotion hanya jika memiliki nilai alisa tidak null
         // Jadikan setiap value sebagai array menggunakan split
         // Jika nilai promosi berupa persentase
            // jadikan nilai persentase menjadi nilai uang berdasarkan nilai costs
            // update nilai reduksi
            // nilai receivables adalah total nilai costs dikurangi nilai reduksi
         // jika nilai promosi berupa nilai
            // update nilai reduksi
            // nilai receivables adalah total nilai costs dikurangi nilai reduksi
      // bind nilai reduksi ke input reduction
      // bind nilai receivables ke input receivables

      var total = parseFloat($('input[name=total]').val());
      var billable = 0.00;
      var reductions = 0.00;
      var receivables =  0.00;

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
            
            reductions += parseFloat(val[1]);
            billable = total - reductions;
            receivables = total - reductions;
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
               reductions += (parseFloat(val[1])/100)*total;
               billable = total - reductions;
               receivables = total - reductions;
            }
            else
            {
               reductions += parseFloat(val[2]);
               billable = total - reductions;
               receivables = total - reductions;
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
               reductions += (parseFloat(val[1])/100)*total;
               billable = total - reductions;
               receivables = total - reductions;
            }
            else
            {
               reductions += parseFloat(val[2]);
               billable = total - reductions;
               receivables = total - reductions;
            }
         };
      }

      if(charges)
      {
         for (var i = charges.length - 1; i >= 0; i--) {
            var val = "";

            val = charges[i];

            val = val.split("#");

           reductions += parseFloat(val[1]);
           receivables = total - reductions;
         };
      }

      $('input[name=billable]').val(billable);
      $('input[name=receivables]').val(receivables);
      $('input[name=reductions]').val(reductions);
   }

    function loadCourses()
    {
        var generation = $('select[name=generation]').val();

        $.ajax({
            url:"{{ URL::to('loadcourses') }}/"+generation,
            type:"GET",
            dataType:"json",
            success:function(courses){
                $('select[name=course]').html('');

                for (var i = courses.length - 1; i >= 0; i--) {
                    $('select[name=course]').append("<option value='"+courses[i].id+"'>"+courses[i].name+"</option>");
                };
            }
        });
    }

   function suggestIssue()
   {
      var course = $('select[name=course]').val();

      $.ajax({
         url:"{{ URL::to('suggestissue') }}/"+course,
         type:"GET",
         dataType:"json",
         success:function(issue){
            $('input[name=issue]').val(issue.issue);
         }
      });
   }

   function classificationEffect()
   {
      var cls = $('select[name=classification] :selected').text();

      if(cls == 'Siswa Pindahan')
      {
         $('select[name=location]').removeAttr('disabled');
      }
      else
      {
         $('select[name=location]').disabled();
      }
   }

   function validateName(el)
   {
      var name = el.val();
      var retValue = {};

      if (name == "") {
         retValue.status = false;
         retValue.msg = "Masukkan Nama Siswa";
      } else {
         retValue.status = true;
      }

      return retValue;
   }

   function validateSchool(el)
   {
      var schools = el.val();
      var school = $('input[name=school]').val();
      var retValue = {};

      if (schools == "" || school == "0") {
         retValue.status = false;
         retValue.msg = "Masukkan Sekolah Asal";
      } else {
         retValue.status = true;
      }

      return retValue;
   }

   function validateCourses(el)
   {
      var courses = el.val();
      var retValue = {};

      if (courses == "") {
         retValue.status = false;
         retValue.msg = "Pilih Kelas Bimbingan";
      } else {
         retValue.status = true;
      }

      return retValue;
   }

   function changeRecommender()
   {
      var recommender_id = $('select[name=partners]').val();

      $('input[name=recommender_type]').val("Partner");
      $('input[name=recommender_id]').val(recommender_id);
   }
</script>
@stop