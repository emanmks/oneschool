<?php

class Registration extends \Eloquent {
	protected $fillable = [];

	public function student()
	{
		return $this->belongsTo('Student');
	}

	public function location()
	{
		return $this->belongsTo('Location');
	}

	public function base()
	{
		return $this->belongsTo('Location','base_id');
	}

	public function issue()
	{
		return $this->hasOne('Issue');
	}

	public function classification()
	{
		return $this->belongsTo('Classification');
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

	public function receivable()
	{
		return $this->hasOne('Receivable');
	}

	public function placements()
	{
		return $this->hasMany('Placement');
	}

	public function earnables()
	{
		return $this->morphMany('Earning','earnable');
	}

	public function recommender()
	{
		return $this->morphTo();
	}
}