<?php

class ChargesController extends \BaseController {

	public function index()
	{
		$charges = Charge::all();
		$menu = 'project';

		return View::make('charges.index', compact('charges','menu'));
	}

	public function create()
	{
		$menu = 'project';
		return View::make('charges.create', compact('menu'));
	}

	public function store()
	{
		$nominal = Input::get('nominal');
		$nominal = str_replace(",", ".", $nominal);
		$nominal = str_replace(".", "", $nominal);
		$nominal = substr($nominal,0,-2);

		$charge = new Charge;

		$charge->project_id = Auth::user()->curr_project_id;
		$charge->name = Input::get('name');
		$charge->nominal = $nominal;
		$charge->description = Input::get('description');
		$charge->save();

		Session::flash('message', 'Sukses menambahkan Charge baru!');
	}

	public function edit($id)
	{
		$charge = Charge::find($id);
		$menu = 'project';

		return View::make('charges.edit', compact('charge','menu'));
	}

	public function update($id)
	{
		$nominal = Input::get('nominal');
		$nominal = str_replace(",", ".", $nominal);
		$nominal = str_replace(".", "", $nominal);
		$nominal = substr($nominal,0,-2);

		$charge = Charge::find($id);

		$charge->name = Input::get('name');
		$charge->nominal = $nominal;
		$charge->description = Input::get('description');
		$charge->save();

		Session::flash('message', 'Sukses mengupdate Charge!');
	}

	public function destroy($id)
	{
		$charge = Charge::with('reductions')->find($id);

		if($charge->reductions->count() > 0)
		{
			Session::flash('message', 'Tidak Dapat menghapus Charge! Charge ini Pernah Digunakan!');
		}
		else
		{
			Charge::destroy($id);
			Session::flash('message', 'Sukses menghapus Charge!');
		}	
	}

}
