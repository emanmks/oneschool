<?php

class HoursController extends \BaseController {

	public function index()
	{
		$hours = Hour::all();
		$programs = Program::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->get();
		$menu = 'data';

		return View::make('hours.index', compact('hours','programs','menu'));
	}

	public function store()
	{
		$hour = new Hour;

		$hour->start = Input::get('start');
		$hour->end = Input::get('end');
		$hour->save();

		Session::flash('message','Sukses menambahkan jam belajar!');
	}

	public function update($id)
	{
		$hour = Hour::find($id);
		
		$hour->start = Input::get('start');
		$hour->end = Input::get('end');
		$hour->save();

		Session::flash('message','Sukses mengupdate jam belajar!');
	}

	public function destroy($id)
	{
		$hour = Hour::with('schedules')->find($id);

		if($hour->schedules->count() > 0)
		{
			Session::flash('message','Tidak dapat menghapus jam belajar! Jam belajar ini digunakan dalam jadwal belajar');
		}
		else
		{
			Hour::destroy($id);
			Session::flash('message','Sukses menghapus jam belajar!');
		}
		
	}

}
