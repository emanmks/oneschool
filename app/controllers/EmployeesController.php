<?php

class EmployeesController extends \BaseController {

	public function index()
	{
		$employees = Employee::all();
		$menu = 'employee';

		return View::make('employees.index', compact('employees','menu'));
	}

	public function store()
	{
		$employee = new Employee;

		$employee->employee_id = Input::get('employee_id');
		$employee->code = Input::get('code');
		$employee->name = Input::get('name');
		$employee->contact = Input::get('contact');
		$employee->basic_salary = Input::get('basic_salary');
		$employee->teach_salary = Input::get('teach_salary');
		$employee->save();

		Session::flash('message','Sukses menambahkan data pegawai!');
	}

	public function show($id)
	{
		$employee = Employee::findOrFail($id);
		$registrations = Registration::where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where('employee_id','=',$id)
									->orderBy('registration_date','desc')->get();

		$earnings = Earning::where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where('employee_id','=',$id)->get();

		$retrievals = Retrieval::where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where('employee_id','=',$id)->get();

		$timelines = Timeline::where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where('informable_type','=','Employee')
									->where('informable_id','=',$id)->get();

		$menu = 'employee';

		return View::make('employees.show', 
				compact('employee','registrations','earnings','retrievals','timelines','menu'));
	}

	public function update($id)
	{
		$employee = Employee::findOrFail($id);

		$employee->employee_id = Input::get('employee_id');
		$employee->code = Input::get('code');
		$employee->name = Input::get('name');
		$employee->contact = Input::get('contact');
		$employee->basic_salary = Input::get('basic_salary');
		$employee->teach_salary = Input::get('teach_salary');
		$employee->save();

		Session::flash('message','Sukses mengupdate data pegawai!');
	}

	public function destroy($id)
	{
		Employee::destroy($id);

		Session::flash('message','Sukses menghapus data pegawai!');
	}

}
