<?php

class DiscountsController extends \BaseController {

	public function index()
	{
		$discounts = Discount::all();
		$menu = 'project';

		return View::make('discounts.index', compact('discounts','menu'));
	}

	public function store()
	{
		$nominal = Input::get('nominal');
		$nominal = str_replace(",", ".", $nominal);
		$nominal = str_replace(".", "", $nominal);
		$nominal = substr($nominal,0,-2);

		$discount = new Discount;
		$discount->name = Input::get('name');
		$discount->given_by = Input::get('given_by');
		$discount->nominal = $nominal;
		$discount->save();

		Session::flash('message','Sukses menambahkan data baru!');
	}

	public function update($id)
	{
		$discount = Discount::findOrFail($id);

		$nominal = Input::get('nominal');
		$nominal = str_replace(",", ".", $nominal);
		$nominal = str_replace(".", "", $nominal);
		$nominal = substr($nominal,0,-2);

		$discount->name = Input::get('name');
		$discount->given_by = Input::get('given_by');
		$discount->nominal = $nominal;
		$discount->save();

		Session::flash('message','Sukses mengupdate data!');
	}

	public function destroy($id)
	{
		$discount = Discount::with('reductions')->find($id);

		if($discount->reductions->count() > 0)
		{
			Session::flash('message','Tidak dapat menghapus data Diskon! Diskon ini pernah digunakan');
		}
		else
		{
			Discount::destroy($id);
			Session::flash('message','Sukses menghapus Diskon!');
		}
		
	}

}
