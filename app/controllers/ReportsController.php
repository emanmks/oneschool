<?php

class ReportsController extends \BaseController {

	public function index()
	{
		$menu = 'report';

		return View::make('reports.index', compact('menu'));
	}

	public function studentPerGeneration()
	{
		$generation_id = 1;
		$generation = Generation::find($generation_id);
		$generations = Generation::all();
		$issues = Issue::where('project_id','=',Auth::user()->curr_project_id)
						->where('generation_id','=',$generation_id)
						->get();
		$menu = 'report';

		return View::make('reports.studentpergeneration',compact('generations','generation','issues','menu'));
	}

	public function studentPerGenerationFilter($id)
	{
		$generation_id = $id;
		$generation = Generation::find($generation_id);
		$generations = Generation::all();
		$issues = Issue::where('project_id','=',Auth::user()->curr_project_id)
						->where('generation_id','=',$generation_id)
						->get();
		$menu = 'report';

		return View::make('reports.studentpergeneration',compact('generations','generation','issues','menu'));
	}

	public function studentPerCourse()
	{
		$course_id = 1;
		$course = Course::with('placements')->find($course_id);
		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'report';

		return View::make('reports.studentpercourse',compact('courses','course','menu'));
	}

	public function studentPerCourseFilter($id)
	{
		$course_id = $id;
		$course = Course::with('placements')->find($course_id);
		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'report';

		return View::make('reports.studentpercourse',compact('courses','course','menu'));
	}

	public function studentPerSchool()
	{
		$education = Education::where('project_id','=',Auth::user()->curr_project_id)->groupBy('school_id')->first();
		$school = School::find($education->school_id);
		$educations = Education::where('project_id','=',Auth::user()->curr_project_id)->where('school_id','=',$school->id)->get();
		$menu = 'report';

		return View::make('reports.studentperschool',compact('educations','school','menu'));
	}

	public function studentPerSchoolFilter($id)
	{
		$school = School::find($id);
		$educations = Education::where('project_id','=',Auth::user()->curr_project_id)->where('school_id','=',$id)->get();
		$menu = 'report';

		return View::make('reports.studentperschool',compact('educations','school','menu'));
	}

	public function studentPerProgram()
	{
		$curr_program = Program::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)->first();

		$program = Program::with('courses')->find($curr_program->id);
		$programs = Program::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'report';

		return View::make('reports.studentperprogram',compact('programs','program','menu'));
	}

	public function studentPerprogramFilter($id)
	{
		$program_id = $id;
		$program = Program::with('courses')->find($program_id);
		$programs = Program::where('project_id','=',Auth::user()->curr_project_id)->where('location_id','=',Auth::user()->location_id)->get();
		$menu = 'report';

		return View::make('reports.studentperprogram',compact('programs','program','menu'));
	}


	public function registrations()
	{
		$classification_id = 8;
		$classification = Classification::find($classification_id);
		$classifications = Classification::where('category','=','Registration')->get();
		$registrations = Registration::has('issue')->where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where('classification_id','=',$classification_id)->get();
		$menu = 'report';

		return View::make('reports.registrations',compact('classifications','classification','registrations','menu'));
	}

	public function registrationsFilter($id)
	{
		$classification_id = $id;
		$classification = Classification::find($classification_id);
		$classifications = Classification::where('category','=','Registration')->get();
		$registrations = Registration::has('issue')->where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where('classification_id','=',$classification_id)->get();
		$menu = 'report';

		return View::make('reports.registrations',compact('classifications','classification','registrations','menu'));
	}


	public function resigns()
	{
		$classification_id = 13;
		$classification = Classification::find($classification_id);
		$classifications = Classification::where('category','=','resign')->get();
		$resigns = Resign::has('issue')->where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where('classification_id','=',$classification_id)->get();
		$menu = 'report';

		return View::make('reports.resigns',compact('classifications','classification','resigns','menu'));
	}

	public function resignsFilter($id)
	{
		$classification_id = $id;
		$classification = Classification::find($classification_id);
		$classifications = Classification::where('category','=','resign')->get();
		$resigns = Resign::has('issue')->where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where('classification_id','=',$classification_id)->get();
		$menu = 'report';

		return View::make('reports.resigns',compact('classifications','classification','resigns','menu'));
	}

	public function estimations()
	{
		$curr_month = date('m');
		$curr_year = date('Y');
		$installments = Installment::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(schedule)'),'=',$curr_year)
								->where(DB::raw('month(schedule)'),'=',$curr_month)
								->get();
		$menu = 'report';

		return View::make('reports.estimations', compact('installments','curr_year','curr_month','menu'));
	}

	public function estimationsFilter($month,$year)
	{
		$curr_month = $month;
		$curr_year = $year;
		$installments = Installment::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(schedule)'),'=',$curr_year)
								->where(DB::raw('month(schedule)'),'=',$curr_month)
								->get();
		$menu = 'report';

		return View::make('reports.estimations', compact('installments','curr_year','curr_month','menu'));
	}

	public function earnings()
	{
		$curr_month = date('m');
		$curr_year = date('Y');
		$earnings = Earning::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(earning_date)'),'=',$curr_year)
								->where(DB::raw('month(earning_date)'),'=',$curr_month)
								->get();
		$menu = 'report';

		return View::make('reports.earnings', compact('earnings','curr_year','curr_month','menu'));
	}

	public function earningsFilter($month,$year)
	{
		$curr_month = $month;
		$curr_year = $year;
		$earnings = Earning::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(earning_date)'),'=',$curr_year)
								->where(DB::raw('month(earning_date)'),'=',$curr_month)
								->get();
		$menu = 'report';

		return View::make('reports.earnings', compact('earnings','curr_year','curr_month','menu'));
	}

	public function lates()
	{
		$curr_month = date('m');
		$curr_year = date('Y');
		$installments = Installment::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(schedule)'),'=',$curr_year)
								->where(DB::raw('month(schedule)'),'=',$curr_month)
								->where('paid','=',0)
								->get();
		$menu = 'report';

		return View::make('reports.lates', compact('installments','curr_year','curr_month','menu'));
	}

	public function latesFilter($month,$year)
	{
		$curr_month = $month;
		$curr_year = $year;
		$installments = Installment::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(schedule)'),'=',$curr_year)
								->where(DB::raw('month(schedule)'),'=',$curr_month)
								->where('paid','=',0)
								->get();
		$menu = 'report';

		return View::make('reports.lates', compact('installments','curr_year','curr_month','menu'));
	}

	public function reductions()
	{
		$reductable_type = 'Promotion';

		$reduction = Reduction::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)	
								->where('reductable_type','=','Promotion')->first();

		$reduction_id = $reduction->reductable_id;

		$reductions = Reduction::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)	
								->where('reductable_type','=',$reductable_type)
								->where('reductable_id','=',$reduction_id)->get();

		$discounts = Promotion::where('project_id','=',Auth::user()->curr_project_id)->get();

		$discount = Promotion::find($reduction_id);

		$menu = 'report';

		return View::make('reports.reductions', compact('reductable_type','reduction_id','reductions','discounts','discount','menu'));
	}

	public function reductionsFilter($types, $id)
	{
		$reductable_type = $types;
		$reduction_id = $id;

		$reductions = Reduction::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)	
								->where('reductable_type','=',$reductable_type)
								->where('reductable_id','=',$reduction_id)->get();

		switch ($reductable_type) {
			case 'Promotion':
				$discounts = Promotion::where('project_id','=',Auth::user()->curr_project_id)->get();
				$discount = Promotion::find($reduction_id);
				break;

			case 'Voucher':
				$discounts = Voucher::where('project_id','=',Auth::user()->curr_project_id)->get();
				$discount = Voucher::find($reduction_id);
				break;

			case 'Discount':
				$discounts = Discount::all();
				$discount = Discount::find($reduction_id);
				break;

			case 'Charge':
				$discounts = Charge::where('project_id','=',Auth::user()->curr_project_id)->get();
				$discount = Charge::find($reduction_id);
				break;
			
			default:
				$discounts = Promotion::where('project_id','=',Auth::user()->curr_project_id)->get();
				$discount = Promtion::find($reduction_id);
				break;
		}

		$menu = 'report';

		return View::make('reports.reductions', compact('reductable_type','reduction_id','reductions','discounts','discount','menu'));
	}

	

	// Block Recapitulation Reports

	public function recapGeneration()
	{
		$generations = Generation::all();
		$periods = DB::table('registrations')
						->select(DB::raw('month(registration_date) as months'),DB::raw('year(registration_date) as years'))
						->groupBy(DB::raw('month(registration_date)'))
						->get();

		$periodizations = array();

		foreach($periods as $period){

			$statistics = array();

			foreach($generations as $generation){
				
				/*$count = Registration::with(array('issues' => function($q)use($generation){
											$q->where('generation_id','=',$generation->id);
										}))
									->where(DB::raw('month(registration_date)'),'=',$period->months)
									->where(DB::raw('year(registration_date)'),'=',$period->years)
									->count();*/

				$count = Issue::whereHas('registration', function($q)use($period){
										$q->where(DB::raw('month(registration_date)'),'=',$period->months);
										$q->where(DB::raw('year(registration_date)'),'=',$period->years);
									})
								->where('generation_id','=',$generation->id)->count();

				$statistics[] = array(
									'count' => $count
								);

				

			}

			$periodizations[] = array(
					'month' => $period->months,
					'year' => $period->years,
					'statistics' => $statistics
				);
		}
		
		$menu = 'report';

		return View::make('reports.recapgeneration', compact('generations','periods','periodizations','menu'));
	}

	public function recapCourse()
	{
		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)->get();
		$periods = DB::table('registrations')
						->select(DB::raw('month(registration_date) as months'),DB::raw('year(registration_date) as years'))
						->groupBy(DB::raw('month(registration_date)'))
						->get();

		$courselists = array();

		foreach($courses as $course){

			$statistics = array();

			foreach($periods as $period){

				$count = Course::with(array('placements', 'placements.issues.registration',))
							->join('placements', 'placements.course_id', '=', 'courses.id')
							->join('issues', 'issues.id', '=', 'placements.issue_id')
							->join('registrations', 'registrations.id', '=', 'issues.registration_id')
							->where(DB::raw('month(registrations.registration_date)'),'=',$period->months)
							->where(DB::raw('year(registrations.registration_date)'),'=',$period->years)
							->where('courses.id','=',$course->id)->count();

				$statistics[] = array(
					'count' => $count
					);

			}

			$courselists[] = array(
					'id' => $course->id,
					'name' => $course->name,
					'statistics' => $statistics
				);

		}

		$menu = 'report';

		return View::make('reports.recapcourse', compact('periods','courselists','menu'));
	}

	public function recapSchoolPeriodic()
	{
		$educations = Education::with('school')->where('project_id','=',Auth::user()->curr_project_id)->groupBy('school_id')->get();
		$periods = DB::table('registrations')
						->select(DB::raw('month(registration_date) as months'),DB::raw('year(registration_date) as years'))
						->groupBy(DB::raw('month(registration_date)'))
						->get();
		$menu = 'report';

		$schools = array();

		foreach($educations as $education){

			$statistics = array();

			foreach($periods as $period){

				$count = School::with(array('educations', 'educations.issues.registration',))
							->join('educations', 'educations.school_id', '=', 'schools.id')
							->join('issues', 'issues.id', '=', 'educations.issue_id')
							->join('registrations', 'registrations.id', '=', 'issues.registration_id')
							->where(DB::raw('month(registrations.registration_date)'),'=',$period->months)
							->where(DB::raw('year(registrations.registration_date)'),'=',$period->years)
							->where('schools.id','=',$education->school_id)->count();

				$statistics[] = array(
					'count' => $count
					);

			}

			$schools[] = array(
					'id' => $education->school_id,
					'name' => $education->school->name,
					'statistics' => $statistics
				);

		}

		return View::make('reports.recapschoolperiodic', compact('schools','periods','menu'));
	}

	public function recapSchoolGeneration()
	{
		$educations = Education::with('school')->where('project_id','=',Auth::user()->curr_project_id)->groupBy('school_id')->get();
		$generations = Generation::all();
		$menu = 'report';

		$schools = array();

		foreach($educations as $education){

			$statistics = array();

			foreach($generations as $generation){

				$count = School::with(array('educations', 'educations.issues',))
							->join('educations', 'educations.school_id', '=', 'schools.id')
							->join('issues', 'issues.id', '=', 'educations.issue_id')
							->where('issues.generation_id','=',$generation->id)
							->where('schools.id','=',$education->school_id)->count();

				$statistics[] = array(
					'count' => $count
					);

			}

			$schools[] = array(
					'id' => $education->school_id,
					'name' => $education->school->name,
					'statistics' => $statistics
				);

		}

		return View::make('reports.recapschoolgeneration', compact('schools','generations','menu'));
	}

	public function recapCirculationPeriodic()
	{
		$registrations = Classification::where('category','=','Registration')->get();
		$resigns = Classification::where('category','=','Resign')->get();
		$periods = DB::table('registrations')
						->select(DB::raw('month(registration_date) as months'),DB::raw('year(registration_date) as years'))
						->groupBy(DB::raw('month(registration_date)'))
						->get();

		$comes = array();
		$leaves = array();

		foreach($registrations as $registration){

			$statistics = array();

			foreach($periods as $period){

				$count = Registration::where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where(DB::raw('month(registration_date)'),'=',$period->months)
									->where(DB::raw('year(registration_date)'),'=',$period->years)
									->where('classification_id','=',$registration->id)->count();

				$statistics[] = array('count' => $count);
			}

			$comes[] = array(
					'name' => $registration->name,
					'statistics' => $statistics 
				);

		}

		foreach($resigns as $resign){

			$statistics = array();

			foreach($periods as $period){

				$count = Resign::where('project_id','=',Auth::user()->curr_project_id)
									->where('location_id','=',Auth::user()->location_id)
									->where(DB::raw('month(resign_date)'),'=',$period->months)
									->where(DB::raw('year(resign_date)'),'=',$period->years)
									->where('classification_id','=',$resign->id)->count();

				$statistics[] = array('count' => $count);
			}

			$leaves[] = array(
					'name' => $resign->name,
					'statistics' => $statistics 
				);

		}

		$menu = 'report';

		return View::make('reports.recapcirculationperiodic', compact('comes','leaves','periods','menu'));
	}

	public function recapCirculationGeneration()
	{
		$registrations = Classification::where('category','=','Registration')->get();
		$resigns = Classification::where('category','=','Resign')->get();
		$generations = Generation::all();

		$comes = array();
		$leaves = array();

		foreach($registrations as $registration){

			$statistics = array();

			foreach($generations as $generation){

				$count = Registration::with(array('issue'))
									->join('issues','issues.registration_id','=','registrations.id')
									->where('registrations.project_id','=',Auth::user()->curr_project_id)
									->where('registrations.location_id','=',Auth::user()->location_id)
									->where('registrations.classification_id','=',$registration->id)
									->where('issues.generation_id','=',$generation->id)->count();

				$statistics[] = array('count' => $count);
			}

			$comes[] = array(
					'name' => $registration->name,
					'statistics' => $statistics 
				);

		}

		foreach($resigns as $resign){

			$statistics = array();

			foreach($generations as $generation){

				$count = Resign::with(array('issue'))
								->join('issues','issues.id','=','resigns.issue_id')
								->where('resigns.project_id','=',Auth::user()->curr_project_id)
								->where('resigns.location_id','=',Auth::user()->location_id)
								->where('resigns.classification_id','=',$resign->id)
								->where('issues.generation_id','=',$generation->id)->count();

				$statistics[] = array('count' => $count);
			}

			$leaves[] = array(
					'name' => $resign->name,
					'statistics' => $statistics 
				);

		}

		$menu = 'report';

		return View::make('reports.recapcirculationgeneration', compact('comes','leaves','generations','menu'));
	}

	public function recapReductionPeriodic()
	{

	}

	public function recapReductionGeneration()
	{

	}	
}
