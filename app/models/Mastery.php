<?php

class Mastery extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function subject()
	{
		return $this->belongsTo('Subject');
	}

	public function issue()
	{
		return $this->belongsTo('Issue');
	}

}