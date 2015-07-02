<?php

class PartnersController extends \BaseController {

	public function index()
	{
		$partners = Partner::all();
		$menu = 'data';

		return View::make('partners.index', compact('partners','menu'));
	}

	public function store()
	{
		$partner = new Partner;

		$partner->location_id = Auth::user()->location_id;
		$partner->name = Input::get('name');
		$partner->address = Input::get('address');
		$partner->contact = Input::get('contact');
		$partner->email = Input::get('email');
		$partner->save();

		Session::flash('message','Berhasil menambahkan Mitra Baru!');
	}
	
	public function update($id)
	{
		$partner = Partner::find($id);

		$partner->location_id = Auth::user()->location_id;
		$partner->name = Input::get('name');
		$partner->address = Input::get('address');
		$partner->contact = Input::get('contact');
		$partner->email = Input::get('email');
		$partner->save();

		Session::flash('message','Berhasil mengupdate Info Mitra!');
	}

	public function destroy($id)
	{
		Partner::destroy($id);
		Session::flash('message','Data Mitra Berhasil dihapus!');
	}

}
