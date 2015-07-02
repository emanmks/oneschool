<?php

class Project extends \Eloquent {
	protected $fillable = [];

	public function registrations()
	{
		return $this->hasMany('Registration');
	}

	public function issues()
	{
		return $this->hasMany('Issue');
	}

	public function courses()
	{
		return $this->hasMany('Course');
	}

	public function earnings()
	{
		return $this->hasMany('Earnings');
	}
}