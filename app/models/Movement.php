<?php

class Movement extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function earnables()
	{
		return $this->morphMany('Earning','earnable');
	}

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function location()
	{
		return $this->belongsTo('Location');
	}

	public function issue()
	{
		return $this->belongsTo('Issue');
	}

	public function base()
	{
		return $this->belongsTo('Course','base_id');
	}

	public function destination()
	{
		return $this->belongsTo('Course','destination_id');
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}
}