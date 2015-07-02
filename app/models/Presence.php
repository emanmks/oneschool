<?php

class Presence extends \Eloquent {
	protected $fillable = [];

	public function issue()
	{
		return $this->belongsTo('Issue');
	}

	public function teach()
	{
		return $this->belongsTo('Teach');
	}
}