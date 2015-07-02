<?php

class PresencesController extends \BaseController {

	public function index()
	{
		$curr_date = date('Y-m-d');

		$teaches = Teach::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->where('course_date','=',$curr_date)
						->get();

		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->get();
		$menu = 'academic';

		return View::make('presences.index', compact('teaches','courses','curr_date','menu'));
	}

	public function filter($date)
	{
		$curr_date = $date;

		$teaches = Teach::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->where('course_date','=',$curr_date)
						->get();

		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->get();
		$menu = 'academic';

		return View::make('presences.index', compact('teaches','courses','curr_date','menu'));
	}

	public function create($course_id)
	{
		$course = Course::with('placements')->find($course_id);
		$employees = Employee::where('teach_salary','>',0.00)->get();
		$hours = Hour::all();
		$menu = 'academic';

		return View::make('presences.create', compact('course','subjects','employees','hours','menu'));
	}

	public function store()
	{
		$issues = Input::get('issues');
		$presences = Input::get('presences');
		$descs = Input::get('descs');

		if($this->teached(Input::get('course_id'),Input::get('subject_id'),Input::get('course_date'),Input::get('hour_id')))
		{
			$teach = Teach::where('course_id','=',Input::get('course_id'))
						->where('course_date','=',Input::get('course_date'))
						->where('hour_id','=',Input::get('hour_id'))->first();
		}
		else
		{
			$teach = new Teach;
			$teach->project_id = Auth::user()->curr_project_id;
			$teach->location_id = Auth::user()->location_id;
			$teach->course_id = Input::get('course_id');
			$teach->employee_id = Input::get('employee_id');
			$teach->hour_id = Input::get('hour_id');
			$teach->course_date = Input::get('course_date');
			$teach->title = Input::get('title');
			$teach->comments = Input::get('comments');
			$teach->save();
		}

		for ($i=0; $i < count($issues); $i++) {

			if(!$this->existed($teach->id,$issues[$i]))
			{
				$presence = new Presence;
				$presence->project_id = Auth::user()->curr_project_id;
				$presence->location_id = Auth::user()->location_id;
				$presence->teach_id = $teach->id;
				$presence->issue_id = $issues[$i];
				$presence->presence = $presences[$i];
				$presence->description = $descs[$i];
				$presence->save();
			}

		}

		Session::flash('message','Sukses menambahkan pertemuan dan presensi baru');
	}

	public function teached($course_id,$subject_id,$course_date,$hour_id)
	{
		$countMe = Teach::where('course_id','=',$course_id)
						->where('course_date','=',$course_date)
						->where('hour_id','=',$hour_id)->count();

		if($countMe > 0){
			return true;
		}else{
			return false;
		}
	}

	public function existed($teach_id, $issue_id)
	{
		$countMe = Presence::where('teach_id','=',$teach_id)
						->where('issue_id','=',$issue_id)->count();

		if($countMe > 0){
			return true;
		}else{
			return false;
		}
	}

	public function show($id)
	{
		$teach = Teach::with('presences')->find($id);
		$menu = 'academic';

		return View::make('presences.show', compact('teach','menu'));
	}

	public function edit($id)
	{
		$teach = Teach::with('presences')->find($id);
		$menu = 'academic';

		return View::make('presences.edit', compact('teach','menu'));
	}

	public function update($id)
	{
		$presence = Presence::find($id);

		$presence->presence = Input::get('presence');
		$presence->description = Input::get('description');
		$presence->save();

		Session::flash('message','Sukses mengupdate presensi');
	}

	public function destroy($id)
	{
		Presence::destroy($id);

		Session::flash('message','Sukses menghapus presensi');
	}

}
