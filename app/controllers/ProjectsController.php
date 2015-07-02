<?php

class ProjectsController extends \BaseController {

	public function index()
	{
		$projects = Project::all();
		$menu = 'project';

		return View::make('projects.index', compact('projects','menu'));
	}
	
	public function store()
	{
		$daterange = explode('-', Input::get('range'));
		$start_date = trim($daterange[0]);
		$end_date = trim($daterange[1]);

		$project = new Project;
		$project->code = Input::get('code');
		$project->name = Input::get('name');
		$project->start_date = date('Y-m-d', strtotime($start_date));
		$project->end_date = date('Y-m-d', strtotime($end_date));
		$project->save();

		Session::flash('message','Sukses membuat Project Baru');
	}

	public function show($id)
	{
		$project = Project::find($id);
		$menu = 'project';

		return View::make('projects.show', compact('project', 'menu'));
	}

	public function update($id)
	{
		$daterange = explode('-', Input::get('range'));
		$start_date = trim($daterange[0]);
		$end_date = trim($daterange[1]);

		$project = Project::find($id);
		$project->code = Input::get('code');
		$project->name = Input::get('name');
		$project->start_date = $start_date;
		$project->end_date = $end_date;
		$project->save();

		Session::flash('message','Sukses mengupdate Project');
	}

	public function destroy($id)
	{
		$project = Project::with('registrations')->find($id);

		if($project->registrations->count() > 0)
		{
			Session::flash('message','Tidak Dapat Menghapus Project! Project ini Aktif dan memiliki Siswa!');
		}
		else
		{
			Project::destroy($id);
			Session::flash('message','Sukses menghapus Project');
		}
	}

}
