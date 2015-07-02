<?php

class SchoolsController extends \BaseController {

	public function index()
	{
		$schools = School::all();
		$states = State::all();
		$cities = City::where('state_id','=',25)->get();
		$menu = 'data';

		return View::make('schools.index', compact('schools','states','cities','menu'));
	}

	public function store()
	{
		$school = new School;

		$school->city_id = Input::get('city');
		$school->name = Input::get('name');
		$school->address = Input::get('address');
		$school->contact = Input::get('contact');
		$school->contact_person = Input::get('contact_person');
		$school->level = Input::get('level');
		$school->save();

		Session::flash('message', 'Sukses menambahkan Sekolah Baru!');
	}

	public function show($id)
	{
		$school = School::findOrFail($id);

		return View::make('schools.show', compact('school'));
	}

	public function update($id)
	{
		$school = School::findOrFail($id);

		$school->name = Input::get('name');
		$school->address = Input::get('address');
		$school->contact = Input::get('contact');
		$school->contact_person = Input::get('contact_person');
		$school->level = Input::get('level');
		$school->save();

		Session::flash('message', 'Sukses mengupdate Sekolah!');
	}

	public function destroy($id)
	{
		$school = School::with('educations')->find($id);

		if($school->educations->count() > 0)
		{
			Session::flash('message', 'Tidak dapat menghapus sekolah! Sekolah ini merupakan sekolah asal salah satu siswa');
		}
		else
		{
			School::destroy($id);
			Session::flash('message', 'Sukses menghapus data sekolah!');
		}
	}

}
