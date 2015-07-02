<?php

class UsersController extends \BaseController {

	public function index()
	{
		$users = User::all();
		$employees = Employee::all();
		$locations = Location::all();
		$menu = 'data';

		return View::make('users.index', compact('users','employees','locations','menu'));
	}

	public function store()
	{
		$user = new User;

		$user->location_id = Input::get('location');
		$user->employee_id = Input::get('employee');
		$user->curr_project_id = Auth::user()->curr_project_id;
		$user->username = Input::get('username');
		$user->password = Hash::make(Input::get('password'));
		$user->role = Input::get('role');
		$user->save();

		Session::flash('message','Sukses menambahkan user baru!');
	}

	public function show($id)
	{
		$user = User::findOrFail($id);

		return View::make('users.show', compact('user'));
	}

	public function update($id)
	{
		$user = User::findOrFail($id);
		
		$user->location_id = Input::get('location');
		$user->employee_id = Input::get('employee');
		$user->username = Input::get('username');
		$user->role = Input::get('role');
		$user->save();

		Session::flash('message','Sukses mengupdate data user!');
	}

	public function destroy($id)
	{
		User::destroy($id);

		Session::flash('message','Sukses menghapus data user!');
	}

}
