<?php

class TimelinesController extends \BaseController {

	/**
	 * Display a listing of timelines
	 *
	 * @return Response
	 */
	public function index()
	{
		$timelines = Timeline::all();

		return View::make('timelines.index', compact('timelines'));
	}

	/**
	 * Show the form for creating a new timeline
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('timelines.create');
	}

	/**
	 * Store a newly created timeline in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Timeline::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Timeline::create($data);

		return Redirect::route('timelines.index');
	}

	/**
	 * Display the specified timeline.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$timeline = Timeline::findOrFail($id);

		return View::make('timelines.show', compact('timeline'));
	}

	/**
	 * Show the form for editing the specified timeline.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$timeline = Timeline::find($id);

		return View::make('timelines.edit', compact('timeline'));
	}

	/**
	 * Update the specified timeline in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$timeline = Timeline::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Timeline::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$timeline->update($data);

		return Redirect::route('timelines.index');
	}

	/**
	 * Remove the specified timeline from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Timeline::destroy($id);

		return Redirect::route('timelines.index');
	}

}
