<?php

class DeductionsController extends \BaseController {

	public function index()
	{
		$curr_month = date('m');
		$curr_year = date('Y');
		$deductions = Deduction::where('location_id','=',Auth::user()->location_id)
						->where(DB::raw('year(release_date)'),'=',$curr_year)
						->where(DB::raw('month(release_date)'),'=',$curr_month)
						->get();
		$menu = 'employee';

		return View::make('deductions.index', compact('deductions','curr_year','curr_month','menu'));
	}

	public function filter($month, $year)
	{
		$curr_month = $month;
		$curr_year = $year;
		$deductions = Deduction::where('location_id','=',Auth::user()->location_id)
						->where(DB::raw('year(release_date)'),'=',$curr_year)
						->where(DB::raw('month(release_date)'),'=',$curr_month)
						->get();
		$menu = 'employee';

		return View::make('deductions.index', compact('deductions','curr_year','curr_month','menu'));
	}

	public function create()
	{
		$classifications = Classification::where('category','=','Deduction')->get();
		$menu = 'employee';

		return View::make('deductions.create', compact('classifications','menu'));
	}

	public function store()
	{
		$nominal = Input::get('nominal');
		$nominal = str_replace(",", ".", $nominal);
		$nominal = str_replace(".", "", $nominal);
		$nominal = substr($nominal,0,-2);

		$deduction = new Deduction;

		$deduction->location_id = Auth::user()->location_id;
		$deduction->employee_id = Input::get('employee_id');
		$deduction->classification_id = Input::get('classification_id');
		$deduction->release_date = Input::get('release_date');
		$deduction->nominal = $nominal;
		$deduction->comments = Input::get('comments');
		$deduction->save();

		return Response::json(array('id' => $deduction->id));
	}

	public function show($id)
	{
		$deduction = Deduction::findOrFail($id);
		$menu = 'employee';

		return View::make('deductions.show', compact('deduction','menu'));
	}

	public function edit($id)
	{
		$deduction = Deduction::find($id);
		$classifications = Classification::where('category','=','Deduction')->get();
		$menu = 'employee';

		return View::make('deductions.edit', compact('deduction','classifications','menu'));
	}

	public function update($id)
	{
		$nominal = Input::get('nominal');
		$nominal = str_replace(",", ".", $nominal);
		$nominal = str_replace(".", "", $nominal);
		$nominal = substr($nominal,0,-2);

		$deduction = Deduction::findOrFail($id);

		$deduction->employee_id = Input::get('employee_id');
		$deduction->classification_id = Input::get('classification_id');
		$deduction->release_date = Input::get('release_date');
		$deduction->nominal = $nominal;
		$deduction->comments = Input::get('comments');
		$deduction->save();
	}

	public function destroy($id)
	{
		Deduction::destroy($id);

		Session::flash('message', 'Sukses menghapus Income Payroll!!');
	}

}
