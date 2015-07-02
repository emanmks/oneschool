<?php

class RegistrationsController extends \BaseController {

	public function index()
	{
		$registrations = Registration::has('issue')->has('receivable')
									->where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->orderBy('registration_date','desc')
									->get();
		$menu = 'registration';

		return View::make('registrations.index', compact('registrations','menu'));
	}

	public function create()
	{
		$menu = 'registration';
		$generations = Generation::all();
		$classifications = Classification::where('category','=','Registration')->get();
		$locations = Location::where('id','<>',Auth::user()->location_id)->get();
		$employees = Employee::all();
		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->where('availability','=',1)
							->where('active','=',1)
							->get();
		$discounts = Discount::all();
		$promotions = Promotion::all();
		$vouchers = Voucher::all();
		$charges = Charge::all();
		$partners = Partner::where('location_id','=',Auth::user()->location_id)->get();

		return View::make(
						'registrations.create', 
						compact('classifications','locations','employees',
							'generations','courses','charges',
							'discounts','promotions','vouchers','partners','menu')
						);
	}

	public function store()
	{
		// Get StudentID
		// From student_id or Create New
		// Create Registration
		// Create Issue
		// Create Education
		// Create Placement
		// Create Receivables
		// Reductions
		// Create Installment

		try
		{
			//DB::beginTransaction();

			if(Input::get('student_id') == 0)
			{
				// Create New Student
				$student = new Student;
				$student->name = Input::get('name');
				$student->sex = Input::get('sex');
				$student->birthplace = Input::get('birthplace');
				$student->birthdate = date('Y-m-d', strtotime(Input::get('birthdate')));
				$student->religion = Input::get('religion');
				$student->address = Input::get('address');
				$student->contact = Input::get('contact');
				$student->email = Input::get('email');
				if(Input::get('sex') == 'L')
				{
					$student->photo = 'boy.png';
				}
				else
				{
					$student->photo = 'girl.png';
				}
				$student->father_name = Input::get('father_name');
				$student->father_occupation = Input::get('father_occupation');
				$student->father_address = Input::get('father_address');
				$student->father_contact = Input::get('father_contact');
				$student->father_email = Input::get('father_email');
				$student->mother_name = Input::get('mother_name');
				$student->mother_occupation = Input::get('mother_occupation');
				$student->mother_address = Input::get('mother_address');
				$student->mother_contact = Input::get('mother_contact');
				$student->mother_email = Input::get('mother_email');
				$student->save();

				$id = $student->id;
			}
			else
			{
				$student = Student::find(Input::get('student_id'));
				$student->name = Input::get('name');
				$student->sex = Input::get('sex');
				$student->birthplace = Input::get('birthplace');
				$student->birthdate = date('Y-m-d', strtotime(Input::get('birthdate')));
				$student->religion = Input::get('religion');
				$student->address = Input::get('address');
				$student->contact = Input::get('contact');
				$student->email = Input::get('email');
				if(Input::get('sex') == 'L')
				{
					$student->photo = 'boy.png';
				}
				else
				{
					$student->photo = 'girl.png';
				}
				$student->father_name = Input::get('father_name');
				$student->father_occupation = Input::get('father_occupation');
				$student->father_address = Input::get('father_address');
				$student->father_contact = Input::get('father_contact');
				$student->father_email = Input::get('father_email');
				$student->mother_name = Input::get('mother_name');
				$student->mother_occupation = Input::get('mother_occupation');
				$student->mother_address = Input::get('mother_address');
				$student->mother_contact = Input::get('mother_contact');
				$student->mother_email = Input::get('mother_email');
				$student->save();

				$id = $student->id;
			}

			// Create Registration Data
			$registration = new Registration;
			$registration->project_id = Auth::user()->curr_project_id;
			$registration->location_id = Auth::user()->location_id;
			$registration->student_id = $id;
			$registration->classification_id = Input::get('classification');
			$registration->base_id = Input::get('location');
			$registration->registration_date = date('Y-m-d', strtotime(Input::get('registration_date')));
			$registration->registration_cost = Input::get('fee');
			$registration->recommender_type = Input::get('recommender_type');
			$registration->recommender_id = Input::get('recommender_id');
			$registration->employee_id = Input::get('employee');
			$registration->save();

			// Create Issue
			$issue = new Issue;
			$issue->project_id = Auth::user()->curr_project_id;
			$issue->location_id = Auth::user()->location_id;
			$issue->registration_id = $registration->id;
			$issue->generation_id = Input::get('generation');
			$issue->student_id = $id;
			$issue->issue = Input::get('issue');
			$issue->save();

			//Create Education Data
			if(Input::get('school') != '0'){
				$education = new Education;
				$education->project_id = Auth::user()->curr_project_id;
				$education->issue_id = $issue->id;
				$education->school_id = Input::get('school');
				$education->generation_id = Input::get('generation');
				$education->save();
			}

			// Receivables - Registration Costs
			$receivable = new Receivable;
			$receivable->project_id = Auth::user()->curr_project_id;
			$receivable->location_id = Auth::user()->location_id;
			$receivable->issue_id = $issue->id;
			$receivable->registration_id = $registration->id;
			$receivable->total = Input::get('total');
			$receivable->billable = Input::get('billable');
			$receivable->receivable = Input::get('receivables');
			$receivable->balance = Input::get('billable');
			if(Input::get('payment') == 0)
			{
				$receivable->payment = 'Cash';
			}
			else
			{
				$receivable->payment = 'Installment';
			}
			$receivable->save();

			$billable = Input::get('billable');
			$payment = Input::get('payment');

			if((int)$payment > 0)
			{
				// First Installment
				$installment = new Installment;
				$installment->project_id = Auth::user()->curr_project_id;
				$installment->location_id = Auth::user()->location_id;
				$installment->receivable_id = $receivable->id;
				$installment->schedule = Input::get('registration_date');
				$installment->total = $billable/$payment;
				$installment->balance = $billable/$payment;
				$installment->paid = 0;
				$installment->save();

				// Extracting Date
				$dd = (int)substr(Input::get('registration_date'),8,2);
				$mm = (int)substr(Input::get('registration_date'),5,2);
				$yy = (int)substr(Input::get('registration_date'),0,4);

				if($dd > 25)
				{
					$mm += 2;

					if($mm > 12)
					{
						$new_mm = $mm - 12;
						$yy += 1;
					}
					else
					{
						$new_mm = $mm;
					}
				}
				else
				{
					$mm += 1;

					if($mm > 12)
					{
						$new_mm = $mm - 12;
						$yy += 1;
					}
					else
					{
						$new_mm = $mm;
					}
				}

				for ($i=2; $i <= $payment; $i++) { 
					
					$installment_date = $yy.'-'.str_pad($new_mm,2,"0",STR_PAD_LEFT).'-'.'05';

					$installment = new Installment;
					$installment->project_id = Auth::user()->curr_project_id;
					$installment->location_id = Auth::user()->location_id;
					$installment->receivable_id = $receivable->id;
					$installment->schedule = date('Y-m-d', strtotime($installment_date));
					$installment->total = $billable/$payment;
					$installment->balance = $billable/$payment;
					$installment->paid = 0;
					$installment->save();

					$new_mm += 1;

					if($new_mm > 12)
					{
						$new_mm = $new_mm - 12;
						$yy += 1;
					}
				}
			}	

			// Placements
			$courses = Input::get('course');
			foreach ($courses as $key => $value) {

				$course = explode("#", $value);

				$placement = new Placement;
				$placement->project_id = Auth::user()->curr_project_id;
				$placement->location_id = Auth::user()->location_id;
				$placement->registration_id = $registration->id;
				$placement->issue_id = $issue->id;
				$placement->course_id = $course[0];
				$placement->save();
			}

			// Reductions - Discounts
			$discounts = Input::get('discounts');
			if($discounts)
			{
				foreach ($discounts as $key => $value) {

					$discount = explode("#", $value);

					$reduction = new Reduction;
					$reduction->project_id = Auth::user()->curr_project_id;
					$reduction->location_id = Auth::user()->location_id;
					$reduction->registration_id = $registration->id;
					$reduction->receivable_id = $receivable->id;
					$reduction->reductable_type = 'Discount';
					$reduction->reductable_id = $discount[0];
					$reduction->save();
				}
			}
			

			// Reductions - Promotions
			$promotions = Input::get('promotions');
			if($promotions)
			{
				foreach ($promotions as $key => $value) {

					$promotion = explode("#", $value);

					$reduction = new Reduction;
					$reduction->project_id = Auth::user()->curr_project_id;
					$reduction->location_id = Auth::user()->location_id;
					$reduction->registration_id = $registration->id;
					$reduction->receivable_id = $receivable->id;
					$reduction->reductable_type = 'Promotion';
					$reduction->reductable_id = $promotion[0];
					$reduction->save();
				}
			}

			// Reductions - Vouchers
			$vouchers = Input::get('vouchers');
			if($vouchers)
			{
				foreach ($vouchers as $key => $value) {

					$voucher = explode("#", $value);

					$reduction = new Reduction;
					$reduction->project_id = Auth::user()->curr_project_id;
					$reduction->location_id = Auth::user()->location_id;
					$reduction->registration_id = $registration->id;
					$reduction->receivable_id = $receivable->id;
					$reduction->reductable_type = 'Voucher';
					$reduction->reductable_id = $voucher[0];
					$reduction->save();
				}
			}

			// Reductions - Charges
			$charges = Input::get('charges');
			if($charges)
			{
				foreach ($charges as $key => $value) {

					$charger = explode("#", $value);

					$reduction = new Reduction;
					$reduction->project_id = Auth::user()->curr_project_id;
					$reduction->location_id = Auth::user()->location_id;
					$reduction->registration_id = $registration->id;
					$reduction->receivable_id = $receivable->id;
					$reduction->reductable_type = 'Charge';
					$reduction->reductable_id = $charger[0];
					$reduction->save();
				}
			}

			// Updating Student Timelines
			$content = 'Bergabung menjadi Siswa One School '.Auth::user()->location->name.'untuk periode '.Auth::user()->curr_project->name;
			$timeline = new Timeline;
			$timeline->project_id = Auth::user()->curr_project_id;
			$timeline->location_id = Auth::user()->location_id;
			$timeline->informable_type = 'Issue';
			$timeline->informable_id = $issue->id;
			$timeline->content = $content;
			$timeline->save();

			// Updating Employee Timeline
			$content = 'Menerima Pendaftaran Siswa untuk periode '.Auth::user()->curr_project->name;
			$timeline = new Timeline;
			$timeline->project_id = Auth::user()->curr_project_id;
			$timeline->location_id = Auth::user()->location_id;
			$timeline->informable_type = 'Employee';
			$timeline->informable_id = Input::get('employee');
			$timeline->content = $content;
			$timeline->save();

			//DB::commit();

			return Response::json(array('status' => 'Succeed','registration_id' => $registration->id, 'issue_id' => $issue->id));
		}
		catch(Exception $e)
		{
			DB::rollback();

			return Response::json(array('status' => 'Failed', 'error' => $e));
		}
		
	}

	public function show($id)
	{
		$registration = Registration::has('issue')->has('receivable')->find($id);
		$handbooks = Handbook::where('project_id','=',Auth::user()->curr_project_id)
							->where('generation_id','=',$registration->issue->generation_id)->get();
		$menu = 'registration';

		return View::make('registrations.show',compact('menu','registration','handbooks'));
	}

	public function edit($id)
	{
		$registration = Registration::find($id);
		$locations = Location::all();
		$employees = Employee::where('location_id','=',18)->get();
		$classifications = Classification::where('category','=','Registration')->get();
		$menu = 'registration';

		return View::make('registrations.edit', compact('registration','menu','locations','employees','classifications'));
	}

	public function update($id)
	{
		$costs = Input::get('registration_cost');
		$costs = str_replace(",", ".", $costs);
		$costs = str_replace(".", "", $costs);
		$costs = substr($costs,0,-2);

		$registration = Registration::find($id);
		
		$registration->classification_id = Input::get('classification_id');
		$registration->base_id = Input::get('location_id');
		$registration->employee_id = Input::get('employee_id');
		$registration->registration_date = Input::get('registration_date');
		$registration->registration_cost = $costs;
		$registration->registration_comments = Input::get('registration_comments');
		$registration->save();
	}

	public function destroy($id)
	{
		$issues = Issue::where('registration_id','=',$id)->delete();

		$placements = Placement::where('registration_id','=',$id)->delete();

		$receivables = Receivable::where('registration_id','=',$id)->get();
		foreach ($receivables as $receivable) {
			
			$installments = Installment::where('receivable_id','=',$receivable->id)->get();
			foreach ($installments as $installment) {
				
				$earnings = Earning::where('earnable_type','=','Installment')->where('earnable_id','=',$installment->id)->get();
				foreach ($earnings as $earning) {
					$earning->delete();
				}

				$installment->delete();
			}

			$earnings = Earning::where('earnable_type','=','Receivable')->where('earnable_id','=',$receivable->id)->delete();

			$reductions = Reduction::where('receivable_id','=',$receivable->id)->delete();

			$receivable->delete();
		}
		
		Registration::destroy($id);

		Session::flash('message','Sukses membatalkan Pendaftaran!, Semua Data terkait pendaftaran ini telah dihapus!');
	}

	public function purchaseCost($id)
	{
		$registration = Registration::has('issue')->find($id);

		$earning = new Earning;
		$earning->project_id = $registration->project_id;
		$earning->location_id = $registration->location_id;
		$earning->issue_id = $registration->issue->id;
		$earning->employee_id = Auth::user()->employee_id;
		$earning->earning_date = $registration->registration_date;
		$earning->earnable_type = 'Registration';
		$earning->earnable_id = $registration->id;
		$earning->code = $this->generateEarningCode();
		$earning->signature = $this->generateEarningSignature();
		$earning->payment = $registration->registration_cost;
		$earning->save();

		$registration->cost_is_paid = 1;
		$registration->save();

		return array('code' => $earning->code);
	}

	private function generateEarningCode()
	{
		$earning = Earning::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->orderBy('id','desc')->first();

		if($earning){

			$last_code = (int) substr($earning->code, 4);
			$earning_counter = $last_code + 1;

		}else{

			$earning_counter = 1;
			
		}
		
		$code = Auth::user()->curr_project->code.Auth::user()->location->code.$earning_counter;
		return $code;
	}

	private function generateEarningSignature()
	{
		return Hash::make(date('Y-m-d H:i:s'));
	}
}
