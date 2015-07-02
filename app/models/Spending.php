<?php

class Spending extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function spendable()
	{
		return $this->morphTo();
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}
}