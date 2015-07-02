<?php

class SpendingsController extends \BaseController {

	public function index()
	{
		$curr_month = date('m');
		$curr_year = date('Y');
		$spendings = Spending::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->where(DB::raw('year(spend_date)'),'=',$curr_year)
							->where(DB::raw('month(spend_date)'),'=',$curr_month)->get();
		$menu = 'finance';

		return View::make('spendings.index', compact('spendings','curr_year','curr_month','menu'));
	}

	public function filter($month,$year)
	{
		$curr_month = $month;
		$curr_year = $year;
		$spendings = Spending::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->where(DB::raw('year(spend_date)'),'=',$curr_year)
							->where(DB::raw('month(spend_date)'),'=',$curr_month)->get();
		$menu = 'finance';

		return View::make('spendings.index', compact('spendings','curr_year','curr_month','menu'));
	}

	public function create()
	{
		$menu = 'finance';
		$employees = Employee::where('location_id','=',Auth::user()->location_id)->get();
		$classifications = Classification::where('category','=','Operational')->get();

		return View::make('spendings.create', compact('employees','classifications','menu'));
	}

	public function store()
	{
		$total = Input::get('total');
		$total = str_replace(",", ".", $total);
		$total = str_replace(".", "", $total);
		$total = substr($total,0,-2);

		$spending = new Spending;

		$spending->project_id = Auth::user()->curr_project_id;
		$spending->location_id = Auth::user()->location_id;
		$spending->employee_id = Input::get('employee_id');
		$spending->spendable_type = 'Classification';
		$spending->spendable_id = Input::get('classification_id');
		$spending->spend_date = Input::get('spend_date');
		$spending->total = $total;
		$spending->code = $this->generateCode();
		$spending->signature = $this->generateSignature();
		$spending->comments = Input::get('comments');
		$spending->save();

		Session::flash('message','Sukses menambahkan Pengeluaran');

		return array('id' => $spending->id);
	}

	public function show($id)
	{
		$spending = Spending::with('employee')->findOrFail($id);
		$menu = 'finance';

		return View::make('spendings.show', compact('spending','menu'));
	}

	public function edit($id)
	{
		$spending = Spending::with('employee')->find($id);
		$employees = Employee::where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'finance';

		return View::make('spendings.edit', compact('spending','employees','menu'));
	}

	public function update($id)
	{
		$total = Input::get('total');
		$total = str_replace(",", ".", $total);
		$total = str_replace(".", "", $total);
		$total = substr($total,0,-2);
		
		$spending = Spending::find($id);

		$spending->project_id = Auth::user()->curr_project_id;
		$spending->location_id = Auth::user()->location_id;
		$spending->employee_id = Input::get('employee_id');
		$spending->spend_date = Input::get('spend_date');
		$spending->total = $total;
		$spending->comments = Input::get('comments');
		$spending->save();

		Session::flash('message','Sukses mengupdate informasi Pengeluaran');
	}

	public function destroy($id)
	{
		Spending::destroy($id);

		Session::flash('message','Sukses membatalkan pengeluaran!');
	}

	private function generateCode()
	{
		$spendings = Spending::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->where('spendable_type','=','Classification')->count();

		$spendings += 1;

		$code = Auth::user()->curr_project->code.Auth::user()->location->code.'02'.$spendings;
		return $code;
	}

	private function generateSignature()
	{
		return Hash::make(date('Y-m-d H:i:s'));
	}

}
