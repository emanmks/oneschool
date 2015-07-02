<?php

class EntitiesController extends \BaseController {

	public function index()
	{
		$entities = Entity::all();
		$employees = Employee::all();
		$menu = 'data';

		return View::make('entities.index', compact('employees','entities','menu'));
	}

	public function store()
	{
		$price = Input::get('price');
		$price = str_replace(",", ".", $price);
		$price = str_replace(".", "", $price);
		$price = substr($price,0,-2);

		$entity = new Entity;
		$entity->location_id = Auth::user()->location_id;
		$entity->code = Input::get('code');
		$entity->name = Input::get('name');
		$entity->price = $price;
		$entity->feasible = Input::get('feasible');
		$entity->infeasible = Input::get('infeasible');
		$entity->last_opname = date('Y-m-d H:i:s');
		$entity->employee_id = Auth::user()->employee_id;
		$entity->save();

		Session::flash('message','Sukses menambahkan aset baru!');
	}

	public function update($id)
	{
		$price = Input::get('price');
		$price = str_replace(",", ".", $price);
		$price = str_replace(".", "", $price);
		$price = substr($price,0,-2);

		$entity = Entity::find($id);
		$entity->code = Input::get('code');
		$entity->name = Input::get('name');
		$entity->price = $price;
		$entity->save();

		Session::flash('message','Info Aset telah diupdate');
	}

	public function opname($id)
	{
		$entity = Entity::find($id);
		$entity->feasible = Input::get('feasible');
		$entity->infeasible = Input::get('infeasible');
		$entity->last_opname = date('Y-m-d H:i:s');
		$entity->employee_id = Input::get('employee');
		$entity->save();

		Session::flash('message','Info Opname telah diupdate');
	}

	public function destroy($id)
	{
		Entity::destroy($id);

		Session::flash('message','Data Aset telah dihapus');
	}

}
