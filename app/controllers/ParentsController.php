<?php

class ParentsController extends \BaseController {

	/**
	 * Display a listing of parents
	 *
	 * @return Response
	 */
	public function index()
	{
		$parents = Parent::all();

		return View::make('parents.index', compact('parents'));
	}

	/**
	 * Show the form for creating a new parent
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('parents.create');
	}

	/**
	 * Store a newly created parent in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Parent::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Parent::create($data);

		return Redirect::route('parents.index');
	}

	/**
	 * Display the specified parent.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$parent = Parent::findOrFail($id);

		return View::make('parents.show', compact('parent'));
	}

	/**
	 * Show the form for editing the specified parent.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$parent = Parent::find($id);

		return View::make('parents.edit', compact('parent'));
	}

	/**
	 * Update the specified parent in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$parent = Parent::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Parent::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$parent->update($data);

		return Redirect::route('parents.index');
	}

	/**
	 * Remove the specified parent from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Parent::destroy($id);

		return Redirect::route('parents.index');
	}

}
