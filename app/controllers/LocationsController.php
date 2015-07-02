<?php

class LocationsController extends \BaseController {

	public function index()
	{
		$locations = Location::all();
		$menu = 'data';

		return View::make('locations.index', compact('locations','menu'));
	}

	public function store()
	{
		$location = new Location;

		$location->code = Input::get('code');
		$location->name = Input::get('name');
		$location->address = Input::get('address');
		$location->contact = Input::get('contact');
		$location->save();

		Session::flash('message','Sukses menambahkan cabang baru!');
	}

	public function update($id)
	{
		$location = Location::find($id);

		$location->code = Input::get('code');
		$location->name = Input::get('name');
		$location->address = Input::get('address');
		$location->contact = Input::get('contact');
		$location->save();

		Session::flash('message','Sukses mengupdate cabang!');
	}

	public function destroy($id)
	{
		$location = Location::with('issues')->find($id);

		if($location->issues->count() > 0)
		{
			Session::flash('message','Tidak dapat menghapus data cabang!');
		}
		else
		{
			Location::destroy($id);
			Session::flash('message','Sukses menghapus cabang!');
		}
		
	}

}
