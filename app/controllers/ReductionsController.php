<?php

class ReductionsController extends \BaseController {

	public function index()
	{
		$reductions = Reduction::all();

		return View::make('reductions.index', compact('reductions'));
	}

	public function store()
	{
		$receivable = Receivable::find(Input::get('receivable_id'));

		// Reductions - Discounts
		$discounts = Input::get('discounts');
		if($discounts)
		{
			foreach ($discounts as $key => $value) {

				$discount = explode("#", $value);

				$reduction = new Reduction;
				$reduction->project_id = Auth::user()->curr_project_id;
				$reduction->location_id = Auth::user()->location_id;
				$reduction->registration_id = $receivable->registration_id;
				$reduction->receivable_id = $receivable->id;
				$reduction->reductable_type = 'Discount';
				$reduction->reductable_id = $discount[0];
				$reduction->save();
			}
		}
		

		// Reductions - Promotions
		$promotions = Input::get('promotions');
		if($promotions)
		{
			foreach ($promotions as $key => $value) {

				$promotion = explode("#", $value);

				$reduction = new Reduction;
				$reduction->project_id = Auth::user()->curr_project_id;
				$reduction->location_id = Auth::user()->location_id;
				$reduction->registration_id = $receivable->registration_id;
				$reduction->receivable_id = $receivable->id;
				$reduction->reductable_type = 'Promotion';
				$reduction->reductable_id = $promotion[0];
				$reduction->save();
			}
		}

		// Reductions - Vouchers
		$vouchers = Input::get('vouchers');
		if($vouchers)
		{
			foreach ($vouchers as $key => $value) {

				$voucher = explode("#", $value);

				$reduction = new Reduction;
				$reduction->project_id = Auth::user()->curr_project_id;
				$reduction->location_id = Auth::user()->location_id;
				$reduction->registration_id = $receivable->registration_id;
				$reduction->receivable_id = $receivable->id;
				$reduction->reductable_type = 'Voucher';
				$reduction->reductable_id = $voucher[0];
				$reduction->save();
			}
		}

		// Reductions - Charges
		$charges = Input::get('charges');
		if($charges)
		{
			foreach ($charges as $key => $value) {

				$charge = explode("#", $value);

				$reduction = new Reduction;
				$reduction->project_id = Auth::user()->curr_project_id;
				$reduction->location_id = Auth::user()->location_id;
				$reduction->registration_id = $receivable->registration_id;
				$reduction->receivable_id = $receivable->id;
				$reduction->reductable_type = 'Charge';
				$reduction->reductable_id = $charge[0];
				$reduction->save();
			}
		}

		$receivable->billable = Input::get('billable');
		$receivable->receivable = Input::get('receivable');
		$receivable->balance = Input::get('balance');
		$receivable->save();
	}

	public function show($id)
	{
		$reduction = Reduction::findOrFail($receivable->student_id);

		return View::make('reductions.show', compact('reduction'));
	}

	public function destroy($id)
	{
		$reduction = Reduction::find($id);

		$receivable = Receivable::find($reduction->receivable_id);

		switch ($reduction->reductable_type) {
			case 'Discount':
				$receivable->billable += $reduction->reductable->nominal;
				$receivable->receivable += $reduction->reductable->nominal;
				$receivable->balance += $reduction->reductable->nominal;
				$receivable->save();
				break;

			case 'Charge':
				$receivable->receivable += $reduction->reductable->nominal;
				$receivable->save();
				break;

			case 'Promotion':
				if($reductable->discount > 0.00)
				{
					$receivable->billable += ($reduction->reductable->discount/100)*$reduction->receivable->total;
					$receivable->receivable += ($reduction->reductable->discount/100)*$reduction->receivable->total;
					$receivable->balance += ($reduction->reductable->discount/100)*$reduction->receivable->total;
					$receivable->save();
				}
				else
				{
					$receivable->billable += $reduction->reductable->nominal;
					$receivable->receivable += $reduction->reductable->nominal;
					$receivable->balance += $reduction->reductable->nominal;
					$receivable->save();
				}
				break;

			case 'Voucher':
				if($reductable->discount > 0.00)
				{
					$receivable->billable += ($reduction->reductable->discount/100)*$reduction->receivable->total;
					$receivable->receivable += ($reduction->reductable->discount/100)*$reduction->receivable->total;
					$receivable->balance += ($reduction->reductable->discount/100)*$reduction->receivable->total;
					$receivable->save();
				}
				else
				{
					$receivable->billable += $reduction->reductable->nominal;
					$receivable->receivable += $reduction->reductable->nominal;
					$receivable->balance += $reduction->reductable->nominal;
					$receivable->save();
				}
				break;
		}	

		Reduction::destroy($id);

		Session::flash('message','Sukses Menghapus Potongan Biaya Bimbingan');
	}

}
