<?php

class Quiz extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function points()
	{
		return $this->morphMany('Point','pointable');
	}

	public function course()
	{
		return $this->belongsTo('Course');
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

	
}