<?php

class Retrieval extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function handbook()
	{
		return $this->belongsTo('Handbook');
	}

	public function issue()
	{
		return $this->belongsTo('Issue');
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}
}