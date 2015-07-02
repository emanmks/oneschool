<?php

class SubjectsController extends \BaseController {

	public function index()
	{
		$subjects = Subject::all();
		$menu ='project';

		return View::make('subjects.index', compact('subjects','menu'));
	}

	public function store()
	{
		$subject = new Subject;

		$subject->name = Input::get('name');
		$subject->save();

		Session::flash('message','Sukses menambahkan bidang studi baru!');
	}


	public function update($id)
	{
		$subject = Subject::find($id);

		$subject->name = Input::get('name');
		$subject->save();

		Session::flash('message','Sukses menambahkan bidang studi baru!');
	}

	public function destroy($id)
	{
		$subject = Subject::with('masteries','schedules')->find($id);

		if($subject->masteries->count() > 0 || $subject->schedules->count() > 0)
		{
			Session::flash('message','Tidak dapat menghapus Bidang Studi! Bidang Studi ini pernah digunakan');
		}
		else
		{
			Subject::destroy($id);
			Session::flash('message','Sukses menghapus Bidang Studi!');
		}
		
	}

}
