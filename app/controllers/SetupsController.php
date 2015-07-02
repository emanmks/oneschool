<?php

class SetupsController extends \BaseController {

	public function index()
	{
		$currProject = Auth::user()->curr_project_id;
		$currLocation = Auth::user()->location_id;
		$projects = Project::all();
		$locations = Location::all();
		$menu = 'setup';

		return View::make('setups/index', compact('projects','locations','currProject','currLocation','menu'));
	}
	
	public function changeProject()
	{
		$user = User::findOrFail(Auth::user()->id);

		$user->curr_project_id = Input::get('project_id');
		$user->save();
	}

	public function changeLocation()
	{
		$user = User::findOrFail(Auth::user()->id);

		$user->location_id = Input::get('location_id');
		$user->save();
	}

	public function normalizeIssue()
	{
		$issues = Issue::all();

		foreach($issues as $issue)
		{
			
			// Normalize Educations
			$educations = Education::where('student_id','=',$issue->student_id)->get();

			foreach($educations as $education)
			{
				$education->student_id = $issue->id;
				$education->save();
			}

			// Normalize Placements
			$placements = Placement::where('student_id','=',$issue->student_id)->get();

			foreach($placements as $placement)
			{
				$placement->student_id = $issue->id;
				$placement->save();
			}

			// Normalize Receivables
			$receivables = Receivable::where('student_id','=',$issue->student_id)->get();

			foreach($receivables as $receivable)
			{
				$receivable->student_id = $issue->id;
				$receivable->save();
			}
		}
	}
}