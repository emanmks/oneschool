<?php

class EarningsController extends \BaseController {

	public function index()
	{
		$curr_month = date('m');
		$curr_year = date('Y');
		$earnings = Earning::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(earning_date)'),'=',$curr_year)
								->where(DB::raw('month(earning_date)'),'=',$curr_month)
								->groupBy('code')
								->get();
		$menu = 'finance';

		return View::make('earnings.index', compact('earnings','curr_year','curr_month','menu'));
	}

	public function filter($month,$year)
	{
		$curr_month = $month;
		$curr_year = $year;
		$earnings = Earning::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(earning_date)'),'=',$curr_year)
								->where(DB::raw('month(earning_date)'),'=',$curr_month)
								->groupBy('code')
								->get();
		$menu = 'finance';

		return View::make('earnings.index', compact('earnings','curr_year','curr_month','menu'));
	}

	public function create($issue_id)
	{
		$issue = Issue::find($issue_id);

		$receivable = Receivable::with('installments')->where('issue_id','=',$issue_id)->first();
		$registration = Registration::where('student_id','=',$issue->student_id)->where('cost_is_paid','=',0)->first();
		$movements = Movement::where('issue_id','=',$issue_id)->where('paid','=',0)->get();
		$punishments = Punishment::where('issue_id','=',$issue_id)->where('paid','=',0)->get();
		$resigns = Resign::where('issue_id','=',$issue_id)->where('fines','>',0.00)->where('is_earned','=',0)->get();

		$employees = Employee::where('location_id','=',Auth::user()->location_id)->get();

		$menu = 'finance';

		return View::make('earnings.create', compact('issue','receivable','registration','movements','punishments','resigns','employees','menu'));
	}

	public function store()
	{
		$receivables = Input::get('receivables');
		$installments = Input::get('installments');
		$registrations = Input::get('registrations');
		$movements = Input::get('movements');
		$punishments = Input::get('punishments');
		$resigns = Input::get('resigns');

		$code = $this->generateCode();
		$signature = Hash::make(date('Y-m-d H:i:s'));

		try 
		{
			DB::beginTransaction();

			if($receivables)
			{
				foreach ($receivables as $key => $value) {

					$receivable = explode("#", $value);

					$earning = new Earning;
					$earning->project_id = Auth::user()->curr_project_id;
					$earning->location_id = Auth::user()->location_id;
					$earning->issue_id = Input::get('issue_id');
					$earning->employee_id = Input::get('employee_id');
					$earning->earning_date = Input::get('earning_date');
					$earning->earnable_type = 'Receivable';
					$earning->earnable_id = $receivable[0];
					$earning->code = $code;
					$earning->signature = $signature;
					$earning->payment = $receivable[1];
					$earning->save();

					$receivable = Receivable::find($receivable[0]);
					$receivable->balance = 0;
					$receivable->save();
				}
			}

			if($installments)
			{

				foreach ($installments as $key => $value) {
					$installment = explode("#", $value);

					$payment = str_replace(",", ".", $installment[1]);
					$payment = str_replace(".", "", $payment);

					$earning = new Earning;
					$earning->project_id = Auth::user()->curr_project_id;
					$earning->location_id = Auth::user()->location_id;
					$earning->issue_id = Input::get('issue_id');
					$earning->employee_id = Input::get('employee_id');
					$earning->earning_date = Input::get('earning_date');
					$earning->earnable_type = 'Installment';
					$earning->earnable_id = $installment[0];
					$earning->code = $code;
					$earning->signature = $signature;
					$earning->payment = $installment[1];
					$earning->save();

					$installment = Installment::find($installment[0]);
					$installment->balance = 0;
					$installment->paid = 1;
					$installment->save();

					$receivable = Receivable::find($installment->receivable_id);
					$receivable->balance = $receivable->balance - $payment;
					$receivable->save();
				}
			}

			if($registrations)
			{
				foreach ($registrations as $key => $value) {
					$registration = explode("#", $value);

					$earning = new Earning;
					$earning->project_id = Auth::user()->curr_project_id;
					$earning->location_id = Auth::user()->location_id;
					$earning->issue_id = Input::get('issue_id');
					$earning->employee_id = Input::get('employee_id');
					$earning->earning_date = Input::get('earning_date');
					$earning->earnable_type = 'Registration';
					$earning->earnable_id = $registration[0];
					$earning->code = $code;
					$earning->signature = $signature;
					$earning->payment = $registration[1];
					$earning->save();

					$registration = Registration::find($registration[0]);
					$registration->cost_is_paid = 1;
					$registration->save();
				}
			}

			if($movements)
			{
				foreach ($movements as $key => $value) {
					$movement = explode("#", $value);

					$earning = new Earning;
					$earning->project_id = Auth::user()->curr_project_id;
					$earning->location_id = Auth::user()->location_id;
					$earning->issue_id = Input::get('issue_id');
					$earning->employee_id = Input::get('employee_id');
					$earning->earning_date = Input::get('earning_date');
					$earning->earnable_type = 'Movement';
					$earning->earnable_id = $movement[0];
					$earning->code = $code;
					$earning->signature = $signature;
					$earning->payment = $movement[1] + $movement[2];
					$earning->save();

					$movement = Movement::find($movement[0]);
					$movement->paid = 1;
					$movement->save();
				}
			}

			if($punishments)
			{
				foreach ($punishments as $key => $value) {
					$punishment = explode("#", $value);

					$earning = new Earning;
					$earning->project_id = Auth::user()->curr_project_id;
					$earning->location_id = Auth::user()->location_id;
					$earning->issue_id = Input::get('issue_id');
					$earning->employee_id = Input::get('employee_id');
					$earning->earning_date = Input::get('earning_date');
					$earning->earnable_type = 'Punishment';
					$earning->earnable_id = $punishment[0];
					$earning->code = $code;
					$earning->signature = $signature;
					$earning->payment = $punishment[1];
					$earning->save();

					$punishment = Punishment::find($punishment[0]);
					$punishment->paid = 1;
					$punishment->save();
				}
			}

			if($resigns)
			{
				foreach ($resigns as $key => $value) {
					$resign = explode("#", $value);

					$earning = new Earning;
					$earning->project_id = Auth::user()->curr_project_id;
					$earning->location_id = Auth::user()->location_id;
					$earning->issue_id = Input::get('issue_id');
					$earning->employee_id = Input::get('employee_id');
					$earning->earning_date = Input::get('earning_date');
					$earning->earnable_type = 'Resign';
					$earning->earnable_id = $resign[0];
					$earning->code = $code;
					$earning->signature = $signature;
					$earning->payment = $resign[1];
					$earning->save();

					$resign = Resign::find($resign[0]);
					$resign->is_earned = 1;
					$resign->save();
				}
			}

			DB::commit();

			return array('status' => 'succeed', 'code' => $code);
		} 
		catch (Exception $e) 
		{
			DB::rollback();

			return array('status' => 'failed', 'message' => $e);
		}
	}

	private function generateCode()
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

	public function show($id)
	{
		$earnings = Earning::where('code','=',$id)->get();
		$earning = Earning::where('code','=',$id)->first();
		$menu = 'finance';

		return View::make('earnings.show', compact('earnings','earning','menu'));
	}

	public function edit($id)
	{
		$earning = Earning::find($id);

		return View::make('earnings.edit', compact('earning'));
	}

	public function destroy($code)
	{
		$earnings = Earning::where('code','=',$code)->get();

		foreach($earnings as $earning)
		{
			switch ($earning->earnable_type) {
				case 'Receivable':
					$receivable = Receivable::find($earning->earnable_id);
					$receivable->balance += $receivable->balance + $earning->payment;
					$receivable->save();

					$earning->delete();
					break;

				case 'Installment':
					$installment = Installment::find($earning->earnable_id);
					$installment->balance += $installment->balance + $earning->payment;
					$installment->paid = 0;
					$installment->save();

					$earning->delete();
					break;

				case 'Registration':
					$registration = Registration::find($earning->earnable_id);
					$registration->cost_is_paid = 0;
					$registration->save();

					$earning->delete();
					break;

				case 'Movement':
					$movement = Movement::find($earning->earnable_id);
					$movement->paid = 0;
					$movement->save();

					$earning->delete();
					break;

				case 'Punishment':
					$punishment = Punishment::find($earning->earnable_id);
					$punishment->paid = 0;
					$punishment->save();

					$earning->delete();
					break;

				case 'Resign':
					$resign = Resign::find($earning->earnable_id);
					$resign->is_earned = 0;
					$resign->save();

					$earning->delete();
					break;
				
				default:
					$earning->delete();
					break;
			}
		}
	}

}
