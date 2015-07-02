<?php

class Classification extends \Eloquent {
	protected $fillable = [];

	public function spendables()
	{
		return $this->morphMany('Spending');
	}

	public function registrations()
	{
		return $this->hasMany('Registration');
	}

	public function resigns()
	{
		return $this->hasMany('Resign');
	}
}