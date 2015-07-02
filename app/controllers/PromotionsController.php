<?php

class PromotionsController extends \BaseController {

	public function index()
	{
		$promotions = Promotion::all();
		$menu = 'project';

		return View::make('promotions.index', compact('promotions','menu'));
	}

	public function create()
	{
		$menu = 'project';
		return View::make('promotions.create', compact('menu'));
	}

	public function store()
	{
		$promotion = new promotion;

		$promotion->project_id = Auth::user()->curr_project_id;
		$promotion->name = Input::get('name');
		$promotion->description = Input::get('description');
		$promotion->discount = Input::get('discount');
		$promotion->nominal = Input::get('nominal');
		$promotion->last_valid = Input::get('last_valid');
		$promotion->save();

		Session::flash('message','Sukses menambahkan promo baru');
	}

	public function show($id)
	{
		$promotion = Promotion::findOrFail($id);
		$menu = 'project';

		return View::make('promotions.show', compact('promotion'));
	}

	public function edit($id)
	{
		$promotion = Promotion::find($id);
		$menu = 'project';

		return View::make('promotions.edit', compact('promotion','menu'));
	}

	public function update($id)
	{
		$promotion = Promotion::find($id);

		$promotion->project_id = Auth::user()->curr_project_id;
		$promotion->name = Input::get('name');
		$promotion->description = Input::get('description');
		$promotion->discount = Input::get('discount');
		$promotion->nominal = Input::get('nominal');
		$promotion->last_valid = Input::get('last_valid');
		$promotion->save();

		Session::flash('message','Sukses mengupdate promo');
	}

	public function destroy($id)
	{
		$promotion = Promotion::with('reductions')->find($id);

		if($promotion->reductions->count() > 0)
		{
			Session::flash('message','Tidak dapat menghapus promo! Promo ini pernah digunakan!');
		}
		else
		{
			Promotion::destroy($id);
			Session::flash('message','Sukses menghapus promo');
		}
	}

}
