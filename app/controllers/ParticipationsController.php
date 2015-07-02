<?php

class ParticipationsController extends \BaseController {

	public function index()
	{
		$activities = Activity::with('participations')->where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->get();
		$menu = 'academic';

		return View::make('participations.index', compact('activities','menu'));
	}

	public function store()
	{
		$fee = Input::get('fee');
		$fee = str_replace(",", ".", $fee);
		$fee = str_replace(".", "", $fee);
		$fee = substr($fee,0,-2);

		$participation = new Participation;

		$participation->activity_id = Input::get('activity');
		$participation->issue_id = Input::get('issue_id');
		$participation->employee_id = Auth::user()->employee_id;
		$participation->registration_fee = $fee;
		$participation->save();

		Session::flash('message','Sukses Menambahkan Peserta Baru!');
	}

	public function show($id)
	{
		$activity = Activity::find($id);

		$participations = Participation::with('issue','employee')
									->where('activity_id','=',$id)
									->get();
		$menu = 'academic';

		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->get();

		return View::make('participations.show', compact('activity','participations','courses','menu'));
	}

	public function destroy($id)
	{
		Participation::destroy($id);

		Session::flash('message','Sukses Membatalkan Keikutsertaan!');
	}

}
