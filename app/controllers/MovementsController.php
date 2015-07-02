<?php

class MovementsController extends \BaseController {

	public function index()
	{
		$movements = Movement::all();
		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->get();
		
		$menu = 'student';

		return View::make('movements.index', compact('movements','menu'));
	}

	public function create()
	{
		$locations = Location::all();
		$courses = Course::where('location_id','=',Auth::user()->location_id)->get();
		$employees = Employee::all();
		$menu = 'student';

		return View::make('movements.create', compact('locations','courses','employees','menu'));
	}

	public function store()
	{
		$movement_costs = Input::get('movement_costs');
		$movement_costs = str_replace(",", ".", $movement_costs);
		$movement_costs = str_replace(".", "", $movement_costs);
		$movement_costs = substr($movement_costs,0,-2);

		$upgrade_costs = Input::get('upgrade_costs');
		$upgrade_costs = str_replace(",", ".", $upgrade_costs);
		$upgrade_costs = str_replace(".", "", $upgrade_costs);
		$upgrade_costs = substr($upgrade_costs,0,-2);

		$movement = new Movement;
		$movement->project_id = Auth::user()->curr_project_id;
		$movement->location_id = Auth::user()->location_id;
		$movement->issue_id = Input::get('issue_id');
		$movement->base_id = Input::get('base_id');
		$movement->destination_id = Input::get('destination_id');
		$movement->employee_id = Input::get('employee_id');
		$movement->movement_date = Input::get('date');
		$movement->movement_costs = $movement_costs;
		$movement->upgrade_costs = $upgrade_costs;
		$movement->comments = Input::get('comments');
		$movement->save();

		$placement = Placement::where('issue_id','=',Input::get('issue_id'))
								->where('course_id','=',Input::get('base_id'))
								->first();

		if((float)$upgrade_costs > 0)
		{
			$receivable = Receivable::where('registration_id','=',$placement->registration_id)->first();

			$receivable->total = $receivable->total + $upgrade_costs;
			$receivable->receivable = $receivable->receivable + $upgrade_costs;
			$receivable->balance = $receivable->balance + $upgrade_costs;
			$receivable->save();
		}

		$placement->course_id = Input::get('destination_id');
		$placement->save();

		// Store to timelines

		return Response::json(array('id' => $movement->id));
	}

	public function show($id)
	{
		$movement = Movement::findOrFail($id);
		$earning = Earning::where('earnable_type','=','Movement')->where('earnable_id','=',$id)->first();
		$menu = 'student';

		return View::make('movements.show', compact('movement','earning','menu'));
	}

	public function edit($id)
	{
		$movement = Movement::findOrFail($id);
		$courses = Course::where('location_id','=',Auth::user()->location_id)->get();
		$employees = Employee::all(); 
		$menu = 'student';

		return View::make('movements.edit', compact('movement','courses','employees','menu'));
	}

	public function update($id)
	{
		$movement_costs = Input::get('movement_costs');
		$movement_costs = str_replace(",", ".", $movement_costs);
		$movement_costs = str_replace(".", "", $movement_costs);
		$movement_costs = substr($movement_costs,0,-2);

		$upgrade_costs = Input::get('upgrade_costs');
		$upgrade_costs = str_replace(",", ".", $upgrade_costs);
		$upgrade_costs = str_replace(".", "", $upgrade_costs);
		$upgrade_costs = substr($upgrade_costs,0,-2);

		$movement = Movement::findOrFail($id);

		$last_course_id = $movement->destination_id;
		$student_id = $movement->student_id;

		$movement->destination_id = Input::get('destination_id');
		$movement->employee_id = Input::get('employee_id');
		$movement->movement_date = Input::get('date');
		$movement->movement_costs = $movement_costs;
		$movement->upgrade_costs = $upgrade_costs;
		$movement->comments = Input::get('comments');
		$movement->save();					
		
		if((float)$upgrade_costs > 0)
		{
			$receivable = Receivable::where('registration_id','=',$placement->registration_id)->first();

			$receivable->total = $receivable->total + $upgrade_costs;
			$receivable->receivable = $receivable->receivable + $upgrade_costs;
			$receivable->balance = $receivable->balance + $upgrade_costs;
			$receivable->save();
		}

		$earning_count = Earning::where('earnable_type','=','Movement')->where('earnable_id','=',$id)->count();

		if($earning_count > 0)
		{
			$earning = Earning::where('earnable_type','=','Movement')->where('earnable_id','=',$id)->first();

			$earning->payment = $movement_costs + $upgrade_costs;
			$earning->save();
		}
	}

	public function destroy($id)
	{
		$movement = Movement::find($id);

		$issue_id = $movement->issue_id;
		$base_id = $movement->base_id;
		$destination_id = $movement->destination_id;

		// restore the placement
		$placement = Placement::where('issue_id','=',$issue_id)->where('course_id','=',$destination_id)->first();
		if($placement){
			$placement->course_id = $base_id;
			$placement->save();
		}

		// deleting earning
		$earning = Earning::where('earnable_type','=','Movement')->where('earnable_id','=',$id)->first();
		if($earning){
			$earning->delete();
		}
		
		Movement::destroy($id);

		// Store to Timelines
	}

	public function payment($id)
	{
		$movement = Movement::find($id);

		$movement->paid = 1;
		$movement->save();

		$earning = new Earning;
		$earning->project_id = Auth::user()->curr_project_id;
		$earning->location_id = Auth::user()->location_id;
		$earning->issue_id = $movement->issue_id;
		$earning->employee_id = $movement->employee_id;
		$earning->earning_date = date('Y-m-d');
		$earning->earnable_type = 'Movement';
		$earning->earnable_id = $movement->id;
		$earning->code = $this->generateEarningCode();
		$earning->signature = $this->generateSignature();
		$earning->payment = $movement->movement_costs + $movement->upgrade_costs;
		$earning->save();

	}

	public function generateEarningCode()
	{
		$earning = Earning::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)
							->orderBy('id','desc')->first();

		if($earning){

			$last_code = (int) substr($earning->code, 4);
			$earning_counter = $last_code + 1;

		}else{

			$earning_counter = 1;
			
		}
		
		$code = Auth::user()->curr_project->code.Auth::user()->location->code.$earning_counter;
		return $code;
	}

	public function generateSignature()
	{
		return Hash::make(date('Y-m-d H:i:s'));
	}

}
