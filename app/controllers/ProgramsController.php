<?php

class ProgramsController extends \BaseController {

	public function index()
	{
		$programs = Program::where('project_id','=',Auth::user()->curr_project_id)->get();
		$menu = 'project';

		return View::make('programs.index', compact('programs','menu'));
	}

	public function create()
	{
		$generations = Generation::all();
		$menu = 'project';

		return View::make('programs.create', compact('generations','menu'));
	}

	public function store()
	{
		$daterange = explode('-', Input::get('range'));
		$start_date = trim($daterange[0]);
		$end_date = trim($daterange[1]);

		$program = new Program;
		$program->project_id = Auth::user()->curr_project_id;
		$program->location_id = Auth::user()->location_id;
		$program->name = Input::get('name');
		$program->description = Input::get('description');
		$program->start_date = date('Y-m-d', strtotime($start_date));
		$program->end_date = date('Y-m-d', strtotime($end_date));
		$program->save();

		Session::flash('message','Sukses membuka program baru!');
	}

	public function show($id)
	{
		$program = Program::findOrFail($id);

		return View::make('programs.show', compact('program'));
	}

	public function edit($id)
	{
		$program = Program::findOrFail($id);
		$generations = Generation::all();
		$menu = 'project';

		return View::make('programs.edit', compact('program','generations','menu'));
	}

	public function update($id)
	{
		$daterange = explode('-', Input::get('range'));
		$start_date = trim($daterange[0]);
		$end_date = trim($daterange[1]);

		$program = Program::findOrFail($id);
		$program->name = Input::get('name');
		$program->description = Input::get('description');
		$program->start_date = date('Y-m-d', strtotime($start_date));
		$program->end_date = date('Y-m-d', strtotime($end_date));
		$program->save();

		Session::flash('message','Sukses mengupdate program!');
	}

	public function destroy($id)
	{
		$program = Program::with('courses')->find($id);

		if($program->courses->count() > 0)
		{
			Session::flash('message','Tidak dapat menutup program! Program ini pernah berjalan');
		}
		else
		{
			Program::destroy($id);
			Session::flash('message','Sukses menutup program!');

			return Redirect::route('programs.index');
		}
		
	}

}
