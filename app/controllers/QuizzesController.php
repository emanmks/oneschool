<?php

class QuizzesController extends \BaseController {

	public function index()
	{
		$quizzes = Quiz::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)->get();
		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)->get();

		$menu = 'academic';

		return View::make('quizzes.index', compact('quizzes','courses','menu'));
	}

	public function create($course_id)
	{
		$course = Course::with('placements')->find($course_id);
		$subjects = Subject::all();
		$employees = Employee::where('teach_salary','>',0.00)->get();
		$menu = 'academic';

		return View::make('quizzes.create', compact('course','subjects','employees','menu'));
	}

	public function store()
	{
		$issues = Input::get('issues');
		$points = Input::get('points');

		if($this->quizzed(Input::get('course_id'),Input::get('subject_id'),Input::get('quiz_date')))
		{
			$quiz = Quiz::where('course_id','=',Input::get('course_id'))
						->where('subject_id','=',Input::get('subject_id'))
						->where('quiz_date','=',Input::get('quiz_date'))->first();
		}
		else
		{
			$quiz = new Quiz;
			$quiz->project_id = Auth::user()->curr_project_id;
			$quiz->location_id = Auth::user()->location_id;
			$quiz->course_id = Input::get('course_id');
			$quiz->subject_id = Input::get('subject_id');
			$quiz->employee_id = Input::get('employee_id');
			$quiz->name = Input::get('name');
			$quiz->quiz_date = Input::get('quiz_date');
			$quiz->save();
		}

		for ($i=0; $i < count($issues); $i++) {

			if(!$this->existed('Quiz',$quiz->id,$issues[$i]))
			{
				$point = new Point;
				$point->project_id = Auth::user()->curr_project_id;
				$point->location_id = Auth::user()->location_id;
				$point->issue_id = $issues[$i];
				$point->pointable_type = 'Quiz';
				$point->pointable_id = $quiz->id;
				$point->point = $points[$i];
				$point->save();
			}

		}
	}

	public function quizzed($course_id,$subject_id,$quiz_date)
	{
		$countMe = Quiz::where('course_id','=',$course_id)
						->where('subject_id','=',$subject_id)
						->where('quiz_date','=',$quiz_date)->count();

		if($countMe > 0){
			return true;
		}else{
			return false;
		}
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
		$quiz = Quiz::findOrFail($id);
		$menu = 'academic';

		return View::make('quizzes.show', compact('quiz','menu'));
	}

	public function edit($id)
	{
		$quiz = Quiz::find($id);
		$subjects = Subject::all();
		$employees = Employee::where('teach_salary','>',0.00)->get();
		$menu = 'academic';

		return View::make('quizzes.edit', compact('quiz','subjects','employees','menu'));
	}

	public function update($id)
	{
		$quiz = Quiz::find($id);

		$quiz->subject_id = Input::get('subject_id');
		$quiz->employee_id = Input::get('employee_id');
		$quiz->name = Input::get('name');
		$quiz->quiz_date = Input::get('quiz_date');
		$quiz->save();

		Session::flash('message','Sukses mengupdate detail Quiz!');
	}

	public function destroy($id)
	{
		Quiz::destroy($id);

		Session::flash('message','Sukses membatalkan Quiz!');
	}

}
