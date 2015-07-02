<?php

class AjaxesController extends \BaseController {

	public function loadCities($state_id)
	{
		$cities = City::where('state_id','=',$state_id)->get();

		return $cities->toJson;
	}

	public function loadSchools($name)
	{
		$schools = School::where('name','like',"%$name%")->take(5)->get();

		return $schools->toJson();
	}

	public function loadProjects()
	{
		$projects = Project::all();

		return $projects->toJson();
	}

	public function loadLocations()
	{
		$locations = Location::all();

		return $locations->toJson();
	}

	public function loadCourses($generation)
	{
		$courses = Course::where('generation_id','=',$generation)
							->where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->where('availability','=',1)
							->get();

		return $courses->toJson();
	}

	public function loadStudents($course)
	{
		$students = Placement::with('issue.student')->where('course_id','=',$course)->get();

		return $students;
	}

	public function hardFilterStudents($name)
	{
		$students = Student::where('name','like',"%$name%")->take(5)->get();

		return $students->toJson();
	}

	public function softFilterStudents($name)
	{
		$students = Issue::with('student')->where('issue','like',"%$name%")->take(5)->get();

		return $students;
	}

	public function filterFatherOccupation($occupation)
	{
		$occupations = Student::select('father_occupation')
							->where('father_occupation','like',"%$occupation%")
							->distinct()
							->take(5)
							->get();

		return $occupations->toJson();
	}

	public function filterMotherOccupation($occupation)
	{
		$occupations = Student::select('mother_occupation')
							->where('mother_occupation','like',"%$occupation%")
							->distinct()
							->take(5)
							->get();

		return $occupations->toJson();
	}

	public function suggestIssue($course_id)
	{
		$course = Course::find($course_id);
		$program = Program::find($course->program->id);
		$year = date('y');
		$month = date('m');

		$counter = Issue::where('project_id','=',Auth::user()->curr_project_id)->count();
		$counter += 1;

		$issue = substr($program->name, 0, 1).$year.$month.str_pad($counter, 5, "0", STR_PAD_LEFT);
		
		return Response::json(array('issue' => $issue));
	}

	public function filterHandbookByIssue($issue_id)
	{
		$issue = Issue::find($issue_id);

		$handbooks = Handbook::where('project_id','=',Auth::user()->curr_project_id)
								->where('generation_id','=',$issue->generation_id)
								->get();

		return $handbooks;
	}

	public function loadEarnables($issue_id)
	{
		$issue = Issue::find($issue_id);

		$receivable = Receivable::with('installments_not_paid')->where('issue_id','=',$issue_id)->first();
		$registrations = Registration::where('student_id','=',$issue->student_id)->where('cost_is_paid','=',0)->get();
		$movements = Movement::where('issue_id','=',$issue_id)->get();
		$punishments = Punishment::where('issue_id','=',$issue_id)->where('paid','=',0)->get();
		$resigns = Resign::where('issue_id','=',$issue_id)->where('is_earned','=',0)->get();

		$responses = array('receivable' => $receivable, 'registrations' => $registrations,
				 		'movements' => $movements, 'punishments' => $punishments, 'resigns' => $resigns);

		return $responses;
	}

	public function loadReductions($what)
	{
		switch ($what) {
			case 'Promotion':
				$responses = Promotion::where('project_id','=',Auth::user()->curr_project_id)->get();
				break;

			case 'Voucher':
				$responses = Voucher::where('project_id','=',Auth::user()->curr_project_id)->get();
				break;

			case 'Discount':
				$responses = Discount::all();
				break;

			case 'Charge':
				$responses = Charge::where('project_id','=',Auth::user()->curr_project_id)->get();
				break;
			
			default:
				$responses = Promotion::where('project_id','=',Auth::user()->curr_project_id)->get();
				break;
		}

		return $responses;
	}


	public function suggestEmployees($name)
	{
		$employees = Employee::where('name','like',"%$name%")->take(5)->get();

		return $employees->toJson();
	}
}