<?php

class Employee extends \Eloquent {
	protected $fillable = [];

	public function timelines()
	{
		return $this->morphMany('Timeline','informable');
	}

	public function location()
	{
		return $this->belongsTo('Location');
	}

	public function payrolls()
	{
		return $this->hasMany('Payroll');
	}
}