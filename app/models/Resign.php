<?php

class Resign extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function location()
	{
		return $this->belongsTo('Location');
	}

	public function classification()
	{
		return $this->belongsTo('Classification');
	}

	public function employee()
	{
		return $this->belongsTo('Employees');
	}

	public function issue()
	{
		return $this->belongsTo('Issue');
	}

	public function earnables()
	{
		return $this->morphMany('Earning','earnable');
	}

}