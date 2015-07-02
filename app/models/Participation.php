<?php

class Participation extends \Eloquent {
	protected $fillable = [];

	public function activity()
	{
		return $this->belongsTo('Activity');
	}

	public function issue()
	{
		return $this->belongsTo('Issue');
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

	public function points()
	{
		return $this->morphMany('Point', 'pointable');
	}
}