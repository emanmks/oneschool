<?php

class School extends \Eloquent {
	protected $fillable = [];

	public function City()
	{
		return $this->belongsTo('City');
	}

	public function educations()
	{
		return $this->hasMany('Education');
	}
}