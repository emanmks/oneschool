<?php

class CoursesController extends \BaseController {


	public function index()
	{
		$courses = Course::all();
		$menu = 'project';

		return View::make('courses.index', compact('courses','menu'));
	}

	public function create()
	{
		$classifications = Classification::where('category','=','Course')->get();
		$programs = Program::where('project_id','=',Auth::user()->curr_project_id)->get();
		$majors = Major::all();
		$generations = Generation::all();
		$menu = 'project';

		return View::make('courses.create', compact('classifications','programs','generations','majors','menu'));
	}

	public function store()
	{
		$course = new Course;

		$days = implode(",", Input::get('days'));

		$costs = Input::get('costs');
		$costs = str_replace(",", ".", $costs);
		$costs = str_replace(".", "", $costs);
		$costs = substr($costs,0,-2);

		$course->project_id = Auth::user()->curr_project_id;
		$course->location_id = Auth::user()->location_id;
		$course->classification_id = Input::get('classification');
		$course->program_id = Input::get('program');
		$course->generation_id = Input::get('generation');
		$course->name = Input::get('name');
		$course->description = Input::get('description');
		$course->course_days = $days;
		$course->costs = $costs;
		$course->capacity = Input::get('capacity');
		$course->availability = Input::get('status');
		$course->save();

		Session::flash('message','Sukses Menambahkan Kelas Baru');
	}

	public function show($id)
	{
		$course = Course::find($id);
		$menu = 'project';

		return View::make('courses.show', compact('course','menu'));
	}

	public function edit($id)
	{
		$course = Course::find($id);
		$classifications = Classification::all();
		$generations = Generation::all();		
		$programs = Program::all();
		$majors = Major::all();
		$menu = 'project';

		return View::make('courses.edit', compact('course','classifications','programs','generations','majors','menu'));
	}

	public function update($id)
	{
		$course = Course::find($id);

		$days = implode(",", Input::get('days'));

		$costs = Input::get('costs');
		$costs = str_replace(",", ".", $costs);
		$costs = str_replace(".", "", $costs);
		$costs = substr($costs,0,-2);

		$course->classification_id = Input::get('classification');
		$course->program_id = Input::get('program');
		$course->generation_id = Input::get('generation');
		$course->name = Input::get('name');
		$course->description = Input::get('description');
		$course->course_days = $days;
		$course->costs = $costs;
		$course->capacity = Input::get('capacity');
		$course->availability = Input::get('status');
		$course->save();

		Session::flash('message','Sukses mengupdate data Kelas!');
	}

	public function destroy($id)
	{
		$course = Course::with('placements')->find($id);

		if($course->placements->count() > 0)
		{
			Session::flash('message','Tidak dapat menghapus data Kelas! Kelas ini pernah digunakan!');
		}
		else
		{
			Course::destroy($id);
			Session::flash('message','Sukses menghapus data Kelas!');
		}
		
	}

}
