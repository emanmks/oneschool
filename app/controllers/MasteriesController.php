<?php

class MasteriesController extends \BaseController {

	public function index()
	{
		$subjects = Subject::all();
		$menu = 'academic';
		$statistics = array();

		foreach ($subjects as $subject) {
			$total_a = Mastery::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where('subject_id','=',$subject->id)
								->where('mastery','=','A')
								->groupBy('issue_id')->count();

			$total_b = Mastery::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where('subject_id','=',$subject->id)
								->where('mastery','=','B')
								->groupBy('issue_id')->count();

			$total_c = Mastery::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where('subject_id','=',$subject->id)
								->where('mastery','=','C')
								->groupBy('issue_id')->count();

			$total_d = Mastery::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where('subject_id','=',$subject->id)
								->where('mastery','=','D')
								->groupBy('issue_id')->count();

			$total_e = Mastery::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where('subject_id','=',$subject->id)
								->where('mastery','=','E')
								->groupBy('issue_id')->count();

			$statistics[] = array(
						'id' => $subject->id,
						'name' => $subject->name,
						'a' => $total_a,
						'b' => $total_b,
						'c' => $total_c,
						'd' => $total_d,
						'e' => $total_e,
						);
		}

		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->get();

		return View::make('masteries.index', compact('statistics','courses','menu'));
	}

	public function create($course_id)
	{
		$course = Course::with('placements')->find($course_id);
		$subjects = Subject::all();
		$menu = 'academic';
		
		return View::make('masteries.create', compact('course','subjects','menu'));
	}

	public function store()
	{
		$issues = Input::get('issues');
		$masteries = Input::get('masteries');

		for ($i=0; $i < count($issues); $i++) {

			if(!$this->existed(Input::get('subject_id'),$issues[$i],Input::get('report_date')))
			{
				$mastery = new Mastery;
				$mastery->project_id = Auth::user()->curr_project_id;
				$mastery->location_id = Auth::user()->location_id;
				$mastery->subject_id = Input::get('subject_id');
				$mastery->issue_id = $issues[$i];
				$mastery->report_date = Input::get('report_date');
				$mastery->mastery = $masteries[$i];
				$mastery->save();
			}

		}

		Session::flash('message','Sukses menambahkan nilai penguasaan bidang studi');
	}

	private function existed($subject_id,$issue_id,$date)
	{
		$countMe = Mastery::where('subject_id','=',$subject_id)
						->where('issue_id','=',$issue_id)
						->where('report_date','=',$date)->count();

		if($countMe > 0){
			return true;
		}else{
			return false;
		}
	}

	public function show($id)
	{
		$mastery = Mastery::findOrFail($id);

		return View::make('masteries.show', compact('mastery'));
	}

	public function edit($id)
	{
		$mastery = Mastery::find($id);

		return View::make('masteries.edit', compact('mastery'));
	}

	public function update($id)
	{
		$mastery = Mastery::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Mastery::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$mastery->update($data);

		return Redirect::route('masteries.index');
	}

	public function destroy($id)
	{
		Mastery::destroy($id);

		return Redirect::route('masteries.index');
	}

}
