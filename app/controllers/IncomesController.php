<?php

class IncomesController extends \BaseController {

	public function index()
	{
		$curr_month = date('m');
		$curr_year = date('Y');
		$incomes = Income::where('location_id','=',Auth::user()->location_id)
						->where(DB::raw('year(release_date)'),'=',$curr_year)
						->where(DB::raw('month(release_date)'),'=',$curr_month)
						->get();
		$menu = 'employee';

		return View::make('incomes.index', compact('incomes','curr_year','curr_month','menu'));
	}

	public function filter($month, $year)
	{
		$curr_month = $month;
		$curr_year = $year;
		$incomes = Income::where('location_id','=',Auth::user()->location_id)
						->where(DB::raw('year(release_date)'),'=',$curr_year)
						->where(DB::raw('month(release_date)'),'=',$curr_month)
						->get();
		$menu = 'employee';

		return View::make('incomes.index', compact('incomes','curr_year','curr_month','menu'));
	}

	public function create()
	{
		$classifications = Classification::where('category','=','Income')->get();
		$menu = 'employee';

		return View::make('incomes.create', compact('classifications','menu'));
	}

	public function store()
	{
		$nominal = Input::get('nominal');
		$nominal = str_replace(",", ".", $nominal);
		$nominal = str_replace(".", "", $nominal);
		$nominal = substr($nominal,0,-2);

		$income = new Income;

		$income->location_id = Auth::user()->location_id;
		$income->employee_id = Input::get('employee_id');
		$income->classification_id = Input::get('classification_id');
		$income->release_date = Input::get('release_date');
		$income->nominal = $nominal;
		$income->comments = Input::get('comments');
		$income->save();

		return Response::json(array('id' => $income->id));
	}

	public function show($id)
	{
		$income = Income::findOrFail($id);
		$menu = 'employee';

		return View::make('incomes.show', compact('income','menu'));
	}

	public function edit($id)
	{
		$income = Income::find($id);
		$classifications = Classification::where('category','=','Income')->get();
		$menu = 'employee';

		return View::make('incomes.edit', compact('income','classifications','menu'));
	}

	public function update($id)
	{
		$nominal = Input::get('nominal');
		$nominal = str_replace(",", ".", $nominal);
		$nominal = str_replace(".", "", $nominal);
		$nominal = substr($nominal,0,-2);

		$income = Income::findOrFail($id);

		$income->employee_id = Input::get('employee_id');
		$income->classification_id = Input::get('classification_id');
		$income->release_date = Input::get('release_date');
		$income->nominal = $nominal;
		$income->comments = Input::get('comments');
		$income->save();
	}

	public function destroy($id)
	{
		Income::destroy($id);

		Session::flash('message', 'Sukses menghapus Income Payroll!!');
	}

}
