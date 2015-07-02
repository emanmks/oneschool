<?php

class RoomsController extends \BaseController {

	public function index()
	{
		$rooms = Room::all();
		$locations = Location::all();
		$menu = 'data';

		return View::make('rooms.index', compact('rooms','locations','menu'));
	}

	public function store()
	{
		$room = new Room;

		$room->location_id = Input::get('location');
		$room->name = Input::get('name');
		$room->capacity = Input::get('capacity');
		$room->save();

		Session::flash('message','Sukses menambahkan ruangan baru!');
	}

	public function show($id)
	{
		$room = Room::findOrFail($id);

		return View::make('rooms.show', compact('room'));
	}

	public function update($id)
	{
		$room = Room::findOrFail($id);

		$room->location_id = Input::get('location');
		$room->name = Input::get('name');
		$room->capacity = Input::get('capacity');
		$room->save();

		Session::flash('message','Sukses mengupdate ruangan!');
	}

	public function destroy($id)
	{
		$room = Room::with('schedules')->find($id);

		if($room->schedules->count() > 0)
		{
			Session::flash('message','Tidak dapat menghapus ruangan! Ruangan ini digunakan dalam jadwal belajar');
		}
		else
		{
			Room::destroy($id);
			Session::flash('message','Sukses menghapus ruangan!');
		}
		
	}

}
