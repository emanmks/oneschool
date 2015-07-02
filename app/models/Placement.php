<?php

class Placement extends \Eloquent {
	protected $fillable = [];

	public function issue()
	{
		return $this->belongsTo('Issue');
	}

	public function course()
	{
		return $this->belongsTo('Course');
	}
}