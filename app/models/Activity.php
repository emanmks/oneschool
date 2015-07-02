<?php

class Activity extends \Eloquent {
	protected $fillable = [];

	public function participations()
	{
		return $this->hasMany('Participation');
	}

	public function points()
	{
		return $this->morphMany('Point','pointable');
	}
}