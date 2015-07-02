<?php

class Course extends \Eloquent {
	protected $fillable = [];

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function classification()
	{
		return $this->belongsTo('Classification');
	}

	public function program()
	{
		return $this->belongsTo('Program');
	}

	public function generation()
	{
		return $this->belongsTo('Generation');
	}

	public function major()
	{
		return $this->belongsTo('Major');
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

	public function location()
	{
		return $this->belongsTo('Location');
	}

	public function placements()
	{
		return $this->hasMany('Placement')->where('active','=',1);
	}
}