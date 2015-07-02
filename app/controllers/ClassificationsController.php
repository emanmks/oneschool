<?php

class ClassificationsController extends \BaseController {

	public function index()
	{
		$classifications = Classification::orderBy('category','asc')->get();
		$menu = 'data';

		return View::make('classifications.index', compact('classifications','menu'));
	}

	public function store()
	{
		$classification = new Classification;

		$classification->category = Input::get('category');
		$classification->name = Input::get('name');
		$classification->description = Input::get('description');
		$classification->save();

		Session::flash('message','Sukses Menambahkan Klasifikasi Baru');
	}

	public function update($id)
	{
		$classification = Classification::find($id);

		$classification->category = Input::get('category');
		$classification->name = Input::get('name');
		$classification->description = Input::get('description');
		$classification->save();

		Session::flash('message','Sukses Mengupdate Klasifikasi');
	}

	public function destroy($id)
	{
		$classification = Classification::with('spendables','registrations','resigns')->find($id);

		if($classification->spendables->count() > 0 || $classification->registrations->count() > 0 || $classification->resigns->count() > 0)
		{
			Session::flash('message', 'Tidak Dapat menghapus Klasifikasi! Klasifikasi ini Pernah Digunakan!');
		}
		else
		{
			Classification::destroy($id);
			Session::flash('message','Sukses Menghapus Klasifikasi');
		}
		
	}

}
