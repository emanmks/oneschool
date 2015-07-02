<?php

class RetrievalsController extends \BaseController {

	public function index()
	{
		$retrievals = Retrieval::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->get();
		$employees = Employee::where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'student';

		return View::make('retrievals.index', compact('retrievals','employees','menu'));
	}

	public function store()
	{
		$retrieval = new Retrieval;
			
		$retrieval->project_id = Auth::user()->curr_project_id;
		$retrieval->location_id = Auth::user()->location_id;
		$retrieval->issue_id = Input::get('issue_id');
		$retrieval->handbook_id = Input::get('handbook_id');
		$retrieval->employee_id = Input::get('employee_id');
		$retrieval->retrieval_date = Input::get('date');
		$retrieval->save();

		$handbook = Handbook::find(Input::get('handbook_id'));
		$handbook->feasible = $handbook->feasible - 1;
		$handbook->save();

		Session::flash('message','Sukses memproses penyerahan Handbook');
	}

	public function show($id)
	{
		$issue = Issue::find($id);
		$retrievals = Retrieval::where('issue_id','=',$id)->get();
		$handbooks = Handbook::where('project_id','=',Auth::user()->curr_project_id)
						->where('generation_id','=',$issue->generation_id)
						->get();
		$menu = 'student';

		return View::make('retrievals.show', compact('issue','retrievals','handbooks','menu'));
	}

	public function update($id)
	{
		$retrieval = Retrieval::find($id);

		if($retrieval->handbook_id != Input::get('handbook_id'))
		{
			$handbook = Handbook::find(Input::get('handbook_id'));
			$handbook->feasible = $handbook->feasible - 1;
			$handbook->save();
		}

		$retrieval->issue_id = Input::get('issue_id');
		$retrieval->handbook_id = Input::get('handbook_id');
		$retrieval->employee_id = Input::get('employee_id');
		$retrieval->retrieval_date = Input::get('date');
		$retrieval->save();
	}

	public function destroy($id)
	{
		$retrieval = Retrieval::find($id);

		$handbook = Handbook::find($retrieval->handbook_id);
		$handbook->feasible = $handbook->feasible + 1;
		$handbook->save();

		Retrieval::destroy($id);

		Session::flash('message','Pengambilan Handbook telah dibatalkan');
	}

}
