<?php

class StudentsController extends \BaseController {


	public function index()
	{
		$issues = Issue::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->orderBy('generation_id','asc')
						->get();

		$menu = 'student';

		return View::make('students.index', compact('issues','menu'));
	}

	public function show($id)
	{
		$student = Issue::with(
						'placements','placement','receivable.installments','educations','education','earnings','punishments',
						'returnments','presences','points','retrievals','timelines','masteries'
						)
						->find($id);

		$periods = Teach::with(array('presences' => function($q)use($id){
									$q->where('issue_id','=',$id);
								}))
						->select(DB::raw('month(course_date) as months'),DB::raw('year(course_date) as years'))
						->groupBy(DB::raw('month(course_date)'))
						->get();

		$presences = array();

		foreach ($periods as $period) {
			$presences[] = array(
								'month' => $period->months,
								'year' => $period->years,
								'presences' => $this->countPresences($id, $period->months, $period->years),
								'presents' => $this->countPresents($id, $period->months, $period->years),
								'absents' => $this->countAbsents($id, $period->months, $period->years),
								'sicks' => $this->countSicks($id, $period->months, $period->years),
								'permits' => $this->countPermits($id, $period->months, $period->years),
								);
		}

		$points = array();

		foreach($student->points as $point){
			if($point->pointable_type == 'Activity')
			{
				$points[] = array(
							'date' => $point->pointable->agenda,
							'event' => $point->pointable->name,
							'point' => $point->point,
							'lowest' => $this->getLowest($point->pointable_id),
							'highest' => $this->getHighest($point->pointable_id)
							);
			}
		}

		$handbooks = Handbook::where('project_id','=',Auth::user()->curr_project_id)
								->where('generation_id','=',$student->generation_id)->get();

		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=', Auth::user()->location_id)
								->get();

		$discounts = Discount::all();
		$promotions = Promotion::where('project_id','=',Auth::user()->curr_project_id)->get();
		$vouchers = Voucher::where('project_id','=',Auth::user()->curr_project_id)->get();
		$charges = Charge::where('project_id','=',Auth::user()->curr_project_id)->get();

		$menu = 'student';

		return View::make('students.show', compact('student','handbooks','courses','discounts',
											'promotions','vouchers','charges','presences','points','menu'));
	}

	public function report($id)
	{
		$student = Issue::with(
						'placement','receivable.installments','education','earnings','punishments',
						'returnments','presences','points','retrievals','masteries'
						)
						->find($id);

		$periods = Teach::with(array('presences' => function($q)use($id){
									$q->where('issue_id','=',$id);
								}))
						->select(DB::raw('month(course_date) as months'),DB::raw('year(course_date) as years'))
						->groupBy(DB::raw('month(course_date)'))
						->get();

		$presences = array();

		foreach ($periods as $period) {
			$presences[] = array(
								'month' => $period->months,
								'year' => $period->years,
								'presences' => $this->countPresences($id, $period->months, $period->years),
								'presents' => $this->countPresents($id, $period->months, $period->years),
								'absents' => $this->countAbsents($id, $period->months, $period->years),
								'sicks' => $this->countSicks($id, $period->months, $period->years),
								'permits' => $this->countPermits($id, $period->months, $period->years)
								);
		}

		$points = array();

		foreach($student->points as $point){
			if($point->pointable_type == 'Activity')
			{
				$points[] = array(
							'date' => $point->pointable->agenda,
							'event' => $point->pointable->name,
							'point' => $point->point,
							'lowest' => $this->getLowest($point->pointable_id),
							'highest' => $this->getHighest($point->pointable_id)
							);
			}
		}

		$menu = 'student';

		return View::make('students.report', compact('student','presences','points','menu'));
	}

	private function countPresences($id, $month, $year)
	{
		$presences = Presence::whereHas('teach', function($q)use($month, $year){
									$q->where(DB::raw('month(course_date)'),'=',$month);
									$q->where(DB::raw('year(course_date)'),'=',$year);
								})
							->where('issue_id','=',$id)
							->count();

		return $presences;
	}

	private function countPresents($id, $month, $year)
	{
		$presents = Presence::whereHas('teach', function($q)use($month, $year){
									$q->where(DB::raw('month(course_date)'),'=',$month);
									$q->where(DB::raw('year(course_date)'),'=',$year);
								})
							->where('issue_id','=',$id)->where('presence','=',1)
							->count();

		return $presents;
	}

	private function countAbsents($id, $month, $year)
	{
		$absents = $presents = Presence::whereHas('teach', function($q)use($month, $year){
									$q->where(DB::raw('month(course_date)'),'=',$month);
									$q->where(DB::raw('year(course_date)'),'=',$year);
								})
							->where('issue_id','=',$id)->where('presence','=',0)->where('description','=','Alpa')
							->count();

		return $absents;
	}

	private function countSicks($id, $month, $year)
	{
		$sicks = $absents = $presents = Presence::whereHas('teach', function($q)use($month, $year){
									$q->where(DB::raw('month(course_date)'),'=',$month);
									$q->where(DB::raw('year(course_date)'),'=',$year);
								})
							->where('issue_id','=',$id)->where('presence','=',0)->where('description','=','Sakit')
							->count();

		return $sicks;
	}	

	private function countPermits($id, $month, $year)
	{
		$permits = $absents = $presents = Presence::whereHas('teach', function($q)use($month, $year){
									$q->where(DB::raw('month(course_date)'),'=',$month);
									$q->where(DB::raw('year(course_date)'),'=',$year);
								})
							->where('issue_id','=',$id)->where('presence','=',0)->where('description','=','Izin')
							->count();

		return $permits;
	}

	private function getLowest($event)
	{
		$lowest = Point::where('pointable_type','=','Activity')->where('pointable_id','=',$event)->min('point');

		return $lowest;
	}

	private function getHighest($event)
	{
		$highest = Point::where('pointable_type','=','Activity')->where('pointable_id','=',$event)->max('point');

		return $highest;
	}

	public function edit($id)
	{
		$student = Issue::find($id);
		$menu = 'student';

		return View::make('students.edit', compact('student','menu'));
	}

	public function update($id)
	{
		$student = Student::find($id);

		$student->name = Input::get('name');
		$student->sex = Input::get('sex');
		$student->birthplace = Input::get('birthplace');
		$student->birthdate = Input::get('birthdate');
		$student->religion = Input::get('religion');
		$student->address = Input::get('address');
		$student->contact = Input::get('contact');
		$student->email = Input::get('email');
		$student->father_name = Input::get('father_name');
		$student->father_occupation = Input::get('father_occupation');
		$student->father_address = Input::get('father_address');
		$student->father_contact = Input::get('father_contact');
		$student->father_email = Input::get('father_email');
		$student->mother_name = Input::get('mother_name');
		$student->mother_occupation = Input::get('mother_occupation');
		$student->mother_address = Input::get('mother_address');
		$student->mother_contact = Input::get('mother_contact');
		$student->mother_email = Input::get('mother_email');
		$student->save();

		Session::flash('message','Sukses mengupdate Biodata Siswa');
	}

	public function destroy($id)
	{
		Student::destroy($id);

		return Redirect::route('students.index');
	}

}
