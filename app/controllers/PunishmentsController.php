<?php

class PunishmentsController extends \BaseController {

	public function index()
	{
		$curr_month = date('m');
		$curr_year = date('Y');
		$punishments = Punishment::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(release_date)'),'=',$curr_year)
								->where(DB::raw('month(release_date)'),'=',$curr_month)
								->get();
		$menu = 'finance';

		return View::make('punishments.index', compact('punishments','curr_month','curr_year','menu'));
	}

	public function filter($month,$year)
	{
		$curr_month = $month;
		$curr_year = $year;
		$punishments = Punishment::where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id)
								->where(DB::raw('year(release_date)'),'=',$curr_year)
								->where(DB::raw('month(release_date)'),'=',$curr_month)
								->get();
		$menu = 'finance';

		return View::make('punishments.index', compact('punishments','curr_month','curr_year','menu'));
	}

	public function create()
	{
		$menu = 'finance';

		return View::make('punishments.create', compact('menu'));
	}

	public function store()
	{
		$fines = Input::get('fines');
		$fines = str_replace(",", ".", $fines);
		$fines = str_replace(".", "", $fines);
		$fines = substr($fines,0,-2);

		$punishment = new Punishment;
		$punishment->project_id = Auth::user()->curr_project_id;
		$punishment->location_id = Auth::user()->location_id;
		$punishment->issue_id = Input::get('issue_id');
		$punishment->installment_id = 0;
		$punishment->release_date = Input::get('release_date');
		$punishment->fines = $fines;
		$punishment->comments = Input::get('comments');
		$punishment->save();

		Session::flash('message','Sukses menambahkan Info Denda baru!');
	}

	public function show($id)
	{
		$punishment = Punishment::findOrFail($id);
		$menu = 'finance';

		return View::make('punishments.show', compact('punishment','menu'));
	}

	public function edit($id)
	{
		$punishment = Punishment::find($id);

		return View::make('punishments.edit', compact('punishment'));
	}

	public function update($id)
	{
		$fines = Input::get('fines');
		$fines = str_replace(",", ".", $fines);
		$fines = str_replace(".", "", $fines);
		$fines = substr($fines,0,-2);

		$punishment = new Punishment;
		$punishment->release_date = Input::get('release_date');
		$punishment->fines = $fines;
		$punishment->comments = Input::get('comments');
		$punishment->save();

		Session::flash('message','Sukses mengupdate Info Denda!');
	}

	public function destroy($id)
	{
		Punishment::destroy($id);

		Session::flash('message','Sukses membatalkan Denda!');
	}

	public function purchase($id)
	{
		$punishment = Punishment::find($id);

		$earning = new Earning;
		$earning->project_id = Auth::user()->curr_project_id;
		$earning->location_id = Auth::user()->location_id;
		$earning->issue_id = $punishment->issue_id;
		$earning->employee_id = Auth::user()->employee_id;
		$earning->earning_date = date('Y-m-d');
		$earning->earnable_type = 'Punishment';
		$earning->earnable_id = $punishment->id;
		$earning->code = $this->generateCode();
		$earning->signature = $this->generateSignature();
		$earning->payment = $punishment->fines;
		$earning->save();

		$punishment->paid = 1;
		$punishment->save();

		return array('code' => $earning->code);
	}

	public function unPurchase($id)
	{
		$punishment = Punishment::find($id);

		$earning = Earning::where('earnable_type','=','Punishment')->where('earnable_id','=',$punishment->id)->delete();

		$punishment->paid = 0;
		$punishment->save();

		Session::flash('message','Sukses membatalkan pembayaran denda!');
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

	private function generateSignature()
	{
		return Hash::make(date('Y-m-d H:i:s'));
	}

}
