<?php

class ReturnmentsController extends \BaseController {

	public function index()
	{
		$returnments = Returnment::all();
		$menu = 'finance';

		return View::make('returnments.index', compact('returnments','menu'));
	}

	public function create()
	{
		$employees = Employee::where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'finance';

		return View::make('returnments.create', compact('employees','menu'));
	}

	public function store()
	{
		$total = Input::get('total');
		$total = str_replace(",", ".", $total);
		$total = str_replace(".", "", $total);
		$total = substr($total,0,-2);

		$returnment = new Returnment;

		$returnment->project_id = Auth::user()->curr_project_id;
		$returnment->location_id = Auth::user()->location_id;
		$returnment->issue_id = Input::get('issue_id');
		$returnment->employee_id = Input::get('employee_id');
		$returnment->retur_date = Input::get('retur_date');
		$returnment->total = $total;
		$returnment->code = $this->generateCode();
		$returnment->signature = $this->generateSignature();
		$returnment->comments = Input::get('comments');
		$returnment->save();

		return array('id' => $returnment->id);
	}

	private function generateCode()
	{
		$returnments = Returnment::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)->count();

		$returnments += 1;

		$code = Auth::user()->curr_project->code.Auth::user()->location->code.'99'.$returnments;
		return $code;
	}

	private function generateSignature()
	{
		return Hash::make(date('Y-m-d H:i:s'));
	}

	public function show($id)
	{
		$returnment = Returnment::findOrFail($id);
		$menu = 'finance';

		return View::make('returnments.show', compact('returnment','menu'));
	}

	public function edit($id)
	{
		$returnment = Returnment::with('employee')->find($id);
		$employees = Employee::where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'finance';

		return View::make('returnments.edit', compact('returnment','employees','menu'));
	}

	public function update($id)
	{
		$total = Input::get('total');
		$total = str_replace(",", ".", $total);
		$total = str_replace(".", "", $total);
		$total = substr($total,0,-2);

		$returnment = Returnment::find($id);

		$returnment->employee_id = Input::get('employee_id');
		$returnment->retur_date = Input::get('retur_date');
		$returnment->total = $total;
		$returnment->comments = Input::get('comments');
		$returnment->save();

		return array('id' => $returnment->id);
	}

	public function destroy($id)
	{
		Returnment::destroy($id);

		Session::flash('message','Sukses membatalkan pengembalian Dana!');
	}

}
