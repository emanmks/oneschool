<?php

class PointsController extends \BaseController {

	public function index()
	{
		$points = Point::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->where('pointable_type','=','Activity')
						->groupBy('pointable_type')->groupBy('pointable_id')->get();

		$activities = Activity::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
							->get();
		$menu = 'academic';

		return View::make('points.index', compact('points','activities','menu'));
	}

	public function create($activity_id)
	{
		$menu = 'academic';
		$activity = Activity::with('participations')->find($activity_id);

		return View::make('points.create', compact('activity','menu'));
	}

	public function store()
	{
		$issues = Input::get('issues');
		$points = Input::get('points');
		$activity_id = Input::get('activity_id');

		for ($i=0; $i < count($issues); $i++) { 

			if(!$this->existed('Activity',$activity_id,$issues[$i]))
			{
				$point = new Point;
				$point->project_id = Auth::user()->curr_project_id;
				$point->location_id = Auth::user()->location_id;
				$point->issue_id = $issues[$i];
				$point->pointable_type = 'Activity';
				$point->pointable_id = $activity_id;
				$point->point = $points[$i];
				$point->save();
			}

		}

		Session::flash('message','Suskes menyetorkan Nilai Baru!');
	}

	public function existed($pointable_type, $pointable_id, $issue_id)
	{
		$countMe = Point::where('pointable_type','=',$pointable_type)
						->where('pointable_id','=',$pointable_id)
						->where('issue_id','=',$issue_id)->count();

		if($countMe > 0){
			return true;
		}else{
			return false;
		}
	}

	public function show($id)
	{
		$activity = Activity::with('points')->find($id);
		$menu = 'academic';

		return View::make('points.show', compact('activity','menu'));
		
	}

	public function edit($id)
	{
		$activity = Activity::with('points')->find($id);
		$menu = 'academic';
		
		return View::make('points.edit', compact('activity','menu'));
	}

	public function update($id)
	{
		$point = Point::find($id);

		$point->point = Input::get('point');
		$point->save();

		Session::flash('message','Sukses mengupdate Nilai');

	}

	public function destroy($id)
	{
		Point::destroy($id);

		Session::flash('message','Sukses menghapus Nilai');
	}

}
