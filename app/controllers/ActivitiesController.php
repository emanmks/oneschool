<?php

class ActivitiesController extends \BaseController {

	public function index()
	{
		$activities = Activity::all();
		$menu = 'project';

		return View::make('activities.index', compact('activities','menu'));
	}

	public function create()
	{
		$locations = Location::all();
		$generations = Generation::all();
		$menu = 'project';

		return View::make('activities.create', compact('locations','generations','menu'));
	}

	public function store()
	{
		$activity = new Activity;

		$activity->project_id = Auth::user()->curr_project_id;
		$activity->location_id = Input::get('location');
		$activity->name = Input::get('name');
		$activity->description = Input::get('description');
		$activity->agenda = Input::get('agenda');
		$activity->coordination = Input::get('coordination');
		$activity->save();

		Session::flash('message','Sukses menambahkan agenda baru');
	}

	public function show($id)
	{
		$activity = Activity::findOrFail($id);

		return View::make('activities.show', compact('activity'));
	}

	public function edit($id)
	{
		$activity = Activity::find($id);
		$generations = Generation::all();
		$locations = Location::all();
		$menu = 'project';

		return View::make('activities.edit', compact('activity','generations','locations','menu'));
	}

	public function update($id)
	{
		$activity = Activity::find($id);

		$activity->location_id = Input::get('location');
		$activity->name = Input::get('name');
		$activity->description = Input::get('description');
		$activity->agenda = Input::get('agenda');
		$activity->coordination = Input::get('coordination');
		$activity->save();

		Session::flash('message','Sukses mengupdate agenda kegiatan');
	}

	public function destroy($id)
	{
		$activity = Activity::find($id);

		if($activity->participations()->count() > 0)
		{
			Session::flash('message','Tidak dapat membatalkan agenda kegiatan! Kegiatan ini pernah dijalankan!');
		}
		else
		{
			Activity::destroy($id);
			Session::flash('message','Sukses membatalkan agenda kegiatan');
		}
		
	}

}
