<?php

class EducationsController extends \BaseController {

	/**
	 * Display a listing of educations
	 *
	 * @return Response
	 */
	public function index()
	{
		$educations = Education::all();

		return View::make('educations.index', compact('educations'));
	}

	/**
	 * Show the form for creating a new education
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('educations.create');
	}

	/**
	 * Store a newly created education in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Education::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Education::create($data);

		return Redirect::route('educations.index');
	}

	/**
	 * Display the specified education.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$education = Education::findOrFail($id);

		return View::make('educations.show', compact('education'));
	}

	/**
	 * Show the form for editing the specified education.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$education = Education::find($id);

		return View::make('educations.edit', compact('education'));
	}

	/**
	 * Update the specified education in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$education = Education::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Education::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$education->update($data);

		return Redirect::route('educations.index');
	}

	/**
	 * Remove the specified education from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Education::destroy($id);

		return Redirect::route('educations.index');
	}

}
