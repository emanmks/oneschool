<?php

class VouchersController extends \BaseController {

	public function index()
	{
		$vouchers = Voucher::all();
		$menu = 'project';

		return View::make('vouchers.index', compact('vouchers','menu'));
	}

	public function create()
	{
		$menu = 'project';
		return View::make('vouchers.create', compact('menu'));
	}

	public function store()
	{
		$voucher = new Voucher;

		$voucher->project_id = Auth::user()->curr_project_id;
		$voucher->name = Input::get('name');
		$voucher->description = Input::get('description');
		$voucher->discount = Input::get('discount');
		$voucher->nominal = Input::get('nominal');
		$voucher->last_valid = Input::get('last_valid');
		$voucher->save();

		Session::flash('message','Sukses menambahkan voucher baru');
	}

	public function show($id)
	{
		$voucher = Voucher::findOrFail($id);
		$menu = 'project';

		return View::make('vouchers.show', compact('voucher'));
	}

	public function edit($id)
	{
		$voucher = Voucher::find($id);
		$menu = 'project';

		return View::make('vouchers.edit', compact('voucher','menu'));
	}

	public function update($id)
	{
		$voucher = Voucher::find($id);

		$voucher->project_id = Auth::user()->curr_project_id;
		$voucher->name = Input::get('name');
		$voucher->description = Input::get('description');
		$voucher->discount = Input::get('discount');
		$voucher->nominal = Input::get('nominal');
		$voucher->last_valid = Input::get('last_valid');
		$voucher->save();

		Session::flash('message','Sukses mengupdate voucher');
	}

	public function destroy($id)
	{
		$voucher = Voucher::with('reductions')->find($id);

		if($voucher->reductions->count() > 0)
		{
			Session::flash('message','Tidak bisa menghapus Voucher. Voucher ini telah digunakan!');
		}
		else
		{
			Voucher::destroy($id);
			Session::flash('message','Sukses menghapus voucher');
		}
	}

}
