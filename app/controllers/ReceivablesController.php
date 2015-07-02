<?php

class ReceivablesController extends \BaseController {

	public function update($id)
	{
		$billable = Input::get('billable');
		$billable = str_replace(",", ".", $billable);
		$billable = str_replace(".", "", $billable);
		$billable = substr($billable,0,-2);

		$receivables = Input::get('receivable');
		$receivables = str_replace(",", ".", $receivables);
		$receivables = str_replace(".", "", $receivables);
		$receivables = substr($receivables,0,-2);

		$balance = Input::get('balance');
		$balance = str_replace(",", ".", $balance);
		$balance = str_replace(".", "", $balance);
		$balance = substr($balance,0,-2);


		$receivable = Receivable::find($id);
		$receivable->billable = $billable;
		$receivable->receivable = $receivables;
		$receivable->balance = $balance;
		$receivable->save();

		Session::flash('message','Sukses mengupdate info Tagihan');

	}

	public function makeCash($id)
	{
		$receivable = Receivable::find($id);

		$receivable->payment = 'Cash';
		$receivable->save();

		$installments = Installment::where('receivable_id','=',$receivable->id)->get();

		foreach ($installments as $installment) {
			$installment->delete();
		}

		Session::flash('message','Pembayaran Tagihan menjadi Tunai (Tanpa Angsuran)!');
	}

}
