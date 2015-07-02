<?php

class Payroll extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function employee()
	{
		return $this->belongsTo('Employee');
	}


	public function spendables()
	{
		return $this->morphMany('Spending');
	}
}