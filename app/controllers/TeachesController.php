<?php

class TeachesController extends \BaseController {

	public function index()
	{
		$curr_date = date('Y-m-d');

		$teaches = Teach::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->where('course_date','=',$curr_date)
						->get();
		$menu = 'employee';

		return View::make('teaches.index', compact('teaches','curr_date','menu'));
	}

	public function filter($date)
	{
		$curr_date = $date;

		$teaches = Teach::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->where('course_date','=',$curr_date)
						->get();

		$menu = 'employee';

		return View::make('presences.index', compact('teaches','curr_date','menu'));
	}

	public function show($id)
	{
		$teach = Teach::findOrFail($id);
		$menu = 'employee';

		return View::make('teaches.show', compact('teach','menu'));
	}

	public function edit($id)
	{
		$teach = Teach::find($id);
		$employees = Employee::where('teach_salary','>',0.00)->get();
		$subjects = Subject::all();
		$hours = Hour::all();

		$menu = 'employee';

		return View::make('teaches.edit', compact('teach','employees','subjects','hours','menu'));
	}

	public function update($id)
	{
		$teach = Teach::find($id);
		$teach->subject_id = Input::get('subject_id');
		$teach->employee_id = Input::get('employee_id');
		$teach->hour_id = Input::get('hour_id');
		$teach->course_date = Input::get('course_date');
		$teach->title = Input::get('title');
		$teach->comments = Input::get('comments');
		$teach->save();

		Session::flash('message','Sukses mengupdate info Pertemuan');
	}

	public function destroy($id)
	{
		$teach = Teach::with('presences')->find($id);

		if($teach->presences->count() > 0)
		{
			Session::flash('message','Tidak dapat menghapus pertemuan!!');
		}
		else
		{
			Teach::destroy($id);
			Session::flash('message','Sukses mengupdate info Pertemuan');	
		}
		
	}

}
