<?php

class PayrollsController extends \BaseController {

	public function index()
	{
		$curr_month = date('m');
		$curr_year = date('Y');

		$payrolls = Payroll::where('location_id','=',Auth::user()->location_id)
							->where(DB::raw('year(release_date)'),'=',$curr_year)
							->where(DB::raw('month(release_date)'),'=',$curr_month)
							->get();
		$menu = 'employee';

		return View::make('payrolls.index', compact('payrolls','curr_month','curr_year','menu'));
	}

	public function filter($month, $year)
	{
		$curr_month = $month;
		$curr_year = $year;

		$payrolls = Payroll::where('location_id','=',Auth::user()->location_id)
							->where(DB::raw('year(release_date)'),'=',$curr_year)
							->where(DB::raw('month(release_date)'),'=',$curr_month)
							->get();
		$menu = 'employee';

		return View::make('payrolls.index', compact('payrolls','curr_month','curr_year','menu'));
	}

	public function create($employee_id,$curr_month,$curr_year)
	{
		$employee = Employee::find($employee_id);

		$incomes = Income::where('employee_id','=',$employee_id)
						->where(DB::raw('year(release_date)'),'=',$curr_year)
						->where(DB::raw('month(release_date)'),'=',$curr_month)
						->get();

		$deductions = Deduction::where('employee_id','=',$employee_id)
						->where(DB::raw('year(release_date)'),'=',$curr_year)
						->where(DB::raw('month(release_date)'),'=',$curr_month)
						->get();

		$teaches = Teach::where('employee_id','=',$employee_id)
						->where(DB::raw('year(course_date)'),'=',$curr_year)
						->where(DB::raw('month(course_date)'),'=',$curr_month)
						->get();

		$menu = 'employee';

		return View::make('payrolls.create', compact('employee','incomes','deductions','teaches','curr_month','curr_year','menu'));
	}

	public function store()
	{
		$employee = Employee::find(Input::get('employee_id'));

		$incomes = Input::get('incomes');
		$deductions = Input::get('deductions');
		$incomes += $employee->basic_salary + Input::get('teaches_salary');
		$salary = $incomes - $deductions;

		$payroll = new Payroll;

		$payroll->location_id = Auth::user()->location_id;
		$payroll->employee_id = Input::get('employee_id');
		$payroll->release_date = Input::get('release_date');
		$payroll->incomes = $incomes;
		$payroll->deductions = $deductions;
		$payroll->salary = $salary;
		$payroll->save();

		Session::flash('message','Sukses membuat perhitungan payroll baru!');
	}

	public function show($id)
	{
		$payroll = Payroll::findOrFail($id);

		$curr_month = (int) date('m', strtotime($payroll->release_date));
		$curr_year = (int) date('Y', strtotime($payroll->release_date));

		$curr_month = $curr_month - 1;

		if($curr_month == 0)
		{
			$curr_month = 12;
			$curr_year = $curr_year - 1;
		}

		$employee = Employee::find($payroll->employee_id);

		$incomes = Income::where('employee_id','=',$employee->id)
						->where(DB::raw('year(release_date)'),'=',$curr_year)
						->where(DB::raw('month(release_date)'),'=',$curr_month)
						->get();

		$deductions = Deduction::where('employee_id','=',$employee->id)
						->where(DB::raw('year(release_date)'),'=',$curr_year)
						->where(DB::raw('month(release_date)'),'=',$curr_month)
						->get();

		$teaches = Teach::where('employee_id','=',$employee->id)
						->where(DB::raw('year(course_date)'),'=',$curr_year)
						->where(DB::raw('month(course_date)'),'=',$curr_month)
						->count();

		$menu = 'employee';

		return View::make('payrolls.show', compact('payroll','employee','incomes','deductions','teaches','curr_year','curr_month','menu'));
	}

	public function destroy($id)
	{
		Payroll::destroy($id);

		return Redirect::route('payrolls.index');
	}

	public function withdraw($id)
	{
		$payroll = Payroll::find($id);

		$payroll->taken = 1;
		$payroll->save();
	}

}
