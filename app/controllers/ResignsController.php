<?php

class ResignsController extends \BaseController {

	public function index()
	{
		$resigns = Resign::all();
		$menu = 'student';

		return View::make('resigns.index', compact('resigns','menu'));
	}

	public function create()
	{
		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->get();
		$employees = Employee::where('location_id','=',Auth::user()->location_id)->get();
		$classifications = Classification::where('category','=','Resign')->get();
		$menu = 'student';

		return View::make('resigns.create', compact('courses','classifications','employees','menu'));
	}

	public function store()
	{
		$fine = Input::get('fine');
		$returnment = Input::get('returnment');

		$returnment = str_replace(",", ".", $returnment);
		$returnment = str_replace(".", "", $returnment);
		$returnment = substr($returnment, 0,-2); 

		$fine = str_replace(",", ".", $fine);
		$fine = str_replace(".", "", $fine);
		$fine = substr($fine, 0,-2);

		try
		{
			$resign = new Resign;
			$resign->project_id = Auth::user()->curr_project_id;
			$resign->location_id = Auth::user()->location_id;
			$resign->issue_id = Input::get('issue_id');
			$resign->employee_id = Input::get('employee_id');
			$resign->classification_id = Input::get('classification_id');
			$resign->resign_date = Input::get('date');
			$resign->fines = $fine;
			$resign->returnment = $returnment;
			$resign->comments = Input::get('comments');
			$resign->save();

			$issue = Issue::with('placements')->find(Input::get('issue_id'));

			foreach ($issue->placements as $placement) {
				$placement->resign_id = $resign->id;
				$placement->active = 0;
				$placement->save();
			}

			$issue = Issue::find(Input::get('issue_id'));

			$issue->is_active = 0;
			$issue->save();

			return Response::json(array('status' => 'succeed'));
		}
		catch(Exception $e)
		{
			return Response::json(array('status' => 'failed', 'pesan' => $e));
		}
	}

	public function show($id)
	{
		$resign = Resign::findOrFail($id);
		$earning = Earning::where('earnable_type','=','Resign')->where('earnable_id','=',$id)->first();
		$returnment = Returnment::where('resign_id','=',$id)->first();
		$menu = 'student';

		return View::make('resigns.show', compact('resign','earning','returnment','menu'));
	}

	public function edit($id)
	{
		$resign = Resign::find($id);
		$classifications = Classification::where('category','=','Resign')->get();
		$menu = 'student';

		return View::make('resigns.edit', compact('resign','classifications','menu'));
	}

	public function update($id)
	{
		try
		{
			$resign = Resign::findOrFail($id);

			$fine = Input::get('fine');
			$returnment = Input::get('returnment');

			$returnment = str_replace(",", ".", $returnment);
			$returnment = str_replace(".", "", $returnment);
			$returnment = substr($returnment, 0,-2); 

			$fine = str_replace(",", ".", $fine);
			$fine = str_replace(".", "", $fine);
			$fine = substr($fine, 0,-2);

			$resign->resign_date = Input::get('date');
			$resign->classification_id = Input::get('classification_id');
			$resign->fine = $fine;
			$resign->returnment = $returnment;
			$resign->comments = Input::get('comments');
			$resign->save();

			$return_count = Returnment::find($resign->id)->count();

			if($return_count > 0)
			{
				$retur = Returnment::find($resign->id);

				$retur->total = $returnment;
				$retur->save();
			}
		}
		catch(Exception $e)
		{
			Session::flash('message','Gagal mengupdate data penon-aktifan siswa');
		}

		Session::flash('message','Sukses mengupdate data penon-aktifan siswa');
	}

	public function earnFines($id)
	{
		$resign = Resign::find($id);

		$earning = new Earning;
		$earning->project_id = Auth::user()->curr_project_id;
		$earning->location_id = Auth::user()->location_id;
		$earning->issue_id = $resign->issue_id;
		$earning->employee_id = $resign->employee_id;
		$earning->earning_date = $resign->resign_date;
		$earning->earnable_type = 'Resign';
		$earning->earnable_id = $resign->id;
		$earning->code = $this->generateCode();
		$earning->signature = $this->generateSignature();
		$earning->payment = $resign->fines;
		$earning->save();

		$resign->is_earned = 1;
		$resign->save();

		return Response::json(array('earning' => $earning->code));
	}

	public function giveReturnment($id)
	{
		$resign = Resign::find($id);

		$returnment = new Returnment;
		$returnment->project_id = Auth::user()->curr_project_id;
		$returnment->location_id = Auth::user()->location_id;
		$returnment->issue_id = $resign->issue_id;
		$returnment->employee_id = Auth::user()->employee_id;
		$returnment->resign_id = $resign->id;
		$returnment->retur_date = date('Y-m-d');
		$returnment->total = $resign->returnment;
		$returnment->code = $this->generateReturCode();
		$returnment->signature = $this->generateSignature();
		$returnment->save();

		$resign->is_returned = 1;
		$resign->save();

		return Response::json(array('returnment' => $returnment->id));
	}

	private function generateCode()
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

	private function generateReturCode()
	{
		$returnments = Returnment::where('project_id','=',Auth::user()->curr_project_id)
							->where('location_id','=',Auth::user()->location_id)->count();

		$returnments += 1;

		$code = Auth::user()->curr_project->code.Auth::user()->location->code.'99'.$returnments;
		return $code;
	}

	private function generateSignature()
	{
		return Hash::make(date('Y-m-d H:i:s'));
	}


	public function destroy($id)
	{
		$resign = Resign::find($id);

		$placements = Placement::where('resign_id','=',$id)->get();

		foreach ($placements as $placement) {
			$placement->resign_id = 0;
			$placement->active = 1;
			$placement->save();
		}

		Returnment::where('resign_id','=',$id)->delete();

		Earning::where('earnable_type','=','Resign')->where('earnable_id','=',$id)->delete();

		Resign::destroy($id);

		Session::flash('message','Sukses membatalkan penon-aktifan siswa');
	}

}
