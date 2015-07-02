<?php

class Point extends \Eloquent {
	protected $fillable = [];

	public function issue()
	{
		return $this->belongsTo('Issue');
	}

	public function pointable()
	{
		return $this->morphTo();
	}
}