<?php

class InstallmentsController extends \BaseController {

	public function index()
	{
		$curr_month = date('m');
		$curr_year = date('Y');
		$installments = Installment::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(schedule)'),'=',$curr_year)
								->where(DB::raw('month(schedule)'),'=',$curr_month)->get();
		$employees = Employee::where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'finance';

		return View::make('installments.index', compact('installments','employees','curr_year','curr_month','menu'));
	}

	public function filter($month,$year)
	{
		$curr_month = $month;
		$curr_year = $year;
		$installments = Installment::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(schedule)'),'=',$curr_year)
								->where(DB::raw('month(schedule)'),'=',$curr_month)->get();
		$employees = Employee::where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'finance';

		return View::make('installments.index', compact('installments','employees','curr_year','curr_month','menu'));
	}

	public function store()
	{
		$receivable = Receivable::find(Input::get('receivable_id'));

		$curr_month = date('m', strtotime(Input::get('first_installment')));
		$curr_year = date('Y', strtotime(Input::get('first_installment')));
		$schedule = Input::get('first_installment');

		$counts = Input::get('counts');

		if($receivable->installments->count() > 0)
		{
			$total_installments = 0.00;

			$installments = Installment::where('receivable_id','=',$receivable->id)->get();

			foreach ($installments as $installment) {
				$total_installments += $installment->total;
			}

			$rest_billable = $receivable->billable - $total_installments;

			for ($i=0; $i < $counts; $i++) { 
				$installment = new Installment;

				$installment->project_id = Auth::user()->curr_project_id;
				$installment->location_id = Auth::user()->location_id;
				$installment->receivable_id = $receivable->id;
				$installment->schedule = $schedule;
				$installment->total = $rest_billable / $counts;
				$installment->balance = $rest_billable / $counts;
				$installment->save();

				$curr_month += 1;

				if($curr_month > 12)
				{
					$curr_month -= 12;
					$curr_year += 1;
				}

				$schedule = $curr_year.'-'.$curr_month.'-'.'05';
			}
		}
		else
		{
			for ($i=0; $i < $counts; $i++) { 
				$installment = new Installment;

				$installment->project_id = Auth::user()->curr_project_id;
				$installment->location_id = Auth::user()->location_id;
				$installment->receivable_id = $receivable->id;
				$installment->schedule = $schedule;
				$installment->total = $receivable->billable / $counts;
				$installment->balance = $receivable->billable / $counts;
				$installment->save();

				$curr_month += 1;

				if($curr_month > 12)
				{
					$curr_month -= 12;
					$curr_year += 1;
				}

				$schedule = $curr_year.'-'.$curr_month.'-'.'05';
			}

			$receivable->payment = 'Installment';
			$receivable->save();

			Session::flash('message','Sukses membuat jadwal angsuran!!');
		}
	}

	public function edit($id)
	{
		$installment = Installment::find($id);
		$menu = 'finance';

		return View::make('installments.edit', compact('installment','menu'));
	}

	public function update($id)
	{
		$installment = Installment::find($id);

		$total = Input::get('total');
		
		$total = str_replace(",", ".", $total);
		$total = str_replace(".", "", $total);
		$total = substr($total,0,-2);

		$balance = Input::get('balance');
		$balance = str_replace(",", ".", $balance);
		$balance = str_replace(".", "", $balance);
		$balance = substr($balance,0,-2);

		$installment->schedule = Input::get('schedule');
		$installment->total = $total;
		$installment->balance = $balance;
		if($balance = 0){
			$installment->paid = 1;
		}
		else{
			$installment->paid = 0;
		}
		$installment->save();
	}

	public function destroy($id)
	{
		Installment::destroy($id);
	}

	public function purchase($id)
	{
		$payment = Input::get('payment');
		$payment = str_replace(",", ".", $payment);
		$payment = str_replace(".", "", $payment);
		$payment = substr($payment,0,-2);

		$fines = Input::get('fines');
		$fines = str_replace(",", ".", $fines);
		$fines = str_replace(".", "", $fines);
		$fines = substr($fines,0,-2);

		$installment = Installment::find($id);
		$installment->balance = $installment->balance - $payment;

		if($installment->balance > 0)
		{
			$installment->paid = 0;
		}
		else
		{
			$installment->paid = 1;
		}
		
		$installment->save();

		$earning_code = $this->generateCode();
		$signature = Hash::make(date('Y-m-d H:i:s'));

		$earning = new Earning;
		$earning->project_id = Auth::user()->curr_project_id;
		$earning->location_id = Auth::user()->location_id;
		$earning->issue_id = $installment->receivable->issue_id;
		$earning->employee_id = Input::get('employee_id');
		$earning->earning_date = Input::get('earning_date');
		$earning->earnable_type = 'Installment';
		$earning->earnable_id = $installment->id;
		$earning->code = $earning_code;
		$earning->signature = $signature;
		$earning->payment = $payment;
		$earning->save();

		if($fines > 0)
		{
			$punishment = new Punishment;
			$punishment->project_id = Auth::user()->curr_project_id;
			$punishment->location_id = Auth::user()->location_id;
			$punishment->issue_id = $installment->receivable->issue_id;
			$punishment->installment_id = $installment->id;
			$punishment->release_date = Input::get('earning_date');
			$punishment->fines = $fines;
			$punishment->paid = 1;
			$punishment->save();

			$earning = new Earning;
			$earning->project_id = Auth::user()->curr_project_id;
			$earning->location_id = Auth::user()->location_id;
			$earning->issue_id = $installment->receivable->issue_id;
			$earning->employee_id = Input::get('employee_id');
			$earning->earning_date = Input::get('earning_date');
			$earning->earnable_type = 'Punishment';
			$earning->earnable_id = $punishment->id;
			$earning->code = $earning_code;
			$earning->signature = $signature;
			$earning->payment = $fines;
			$earning->save();
		}

		$receivable = Receivable::find($installment->receivable_id);
		$receivable->balance = $receivable->balance - $payment;
		$receivable->save();

		return Response::json(array('status' => 'Succeed','earning' => $earning->code));
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

}
