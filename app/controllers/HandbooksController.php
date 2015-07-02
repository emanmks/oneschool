<?php

class HandbooksController extends \BaseController {

	public function index()
	{
		$handbooks = Handbook::where('project_id','=',Auth::user()->curr_project_id)
								->get();
		$employees = Employee::all();
		$generations = Generation::all();
		$majors = Major::all();

		$menu = 'project';

		return View::make('handbooks.index', compact('employees','handbooks','generations','majors','menu'));
	}

	public function store()
	{
		$price = Input::get('price');
		$price = str_replace(",", ".", $price);
		$price = str_replace(".", "", $price);
		$price = substr($price,0,-2);

		$handbook = new Handbook;
		$handbook->project_id = Auth::user()->curr_project_id;
		$handbook->generation_id = Input::get('generation');
		$handbook->title = Input::get('title');
		$handbook->price = $price;
		$handbook->feasible = Input::get('feasible');
		$handbook->infeasible = Input::get('infeasible');
		$handbook->last_opname = date('Y-m-d H:i:s');
		$handbook->employee_id = Auth::user()->employee_id;
		$handbook->save();

		Session::flash('message','Sukses menambahkan Handbook baru!');
	}

	public function update($id)
	{
		$price = Input::get('price');
		$price = str_replace(",", ".", $price);
		$price = str_replace(".", "", $price);
		$price = substr($price,0,-2);

		$handbook = Handbook::find($id);
		$handbook->generation_id = Input::get('generation');
		$handbook->title = Input::get('title');
		$handbook->price = $price;
		$handbook->save();

		Session::flash('message','Info Handbook telah diupdate');
	}

	public function opname($id)
	{
		$handbook = Handbook::find($id);
		$handbook->feasible = Input::get('feasible');
		$handbook->infeasible = Input::get('infeasible');
		$handbook->last_opname = date('Y-m-d H:i:s');
		$handbook->employee_id = Input::get('employee');
		$handbook->save();

		Session::flash('message','Info Opname telah diupdate');
	}

	public function destroy($id)
	{
		$handbook = Handbook::find($id);

		if($handbook->retrievals()->count() > 0)
		{
			Session::flash('message','Data Handbook tidak dapat dihapus! Handbook ini pernah digunakan');
		}
		else
		{
			Handbook::destroy($id);
			Session::flash('message','Data Handbook telah dihapus');
		}

		
	}

}
