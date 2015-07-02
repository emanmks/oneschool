<?php

class GenerationsController extends \BaseController {

	/**
	 * Display a listing of generations
	 *
	 * @return Response
	 */
	public function index()
	{
		$generations = Generation::all();

		return View::make('generations.index', compact('generations'));
	}

	/**
	 * Show the form for creating a new generation
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('generations.create');
	}

	/**
	 * Store a newly created generation in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Generation::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Generation::create($data);

		return Redirect::route('generations.index');
	}

	/**
	 * Display the specified generation.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$generation = Generation::findOrFail($id);

		return View::make('generations.show', compact('generation'));
	}

	/**
	 * Show the form for editing the specified generation.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$generation = Generation::find($id);

		return View::make('generations.edit', compact('generation'));
	}

	/**
	 * Update the specified generation in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$generation = Generation::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Generation::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$generation->update($data);

		return Redirect::route('generations.index');
	}

	/**
	 * Remove the specified generation from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Generation::destroy($id);

		return Redirect::route('generations.index');
	}

}
