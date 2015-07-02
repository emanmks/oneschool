<?php

class Installment extends \Eloquent {
	protected $fillable = [];

	public function receivable()
	{
		return $this->belongsTo('Receivable');
	}

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function location()
	{
		return $this->belongsTo('Location');
	}

	public function earnables()
	{
		return $this->morphMany('Earning','earnable');
	}
}