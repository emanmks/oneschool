<?php

class Returnment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function location()
	{
		return $this->belongsTo('Location');
	}

	public function resign()
	{
		return $this->belongsTo('Resign');
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