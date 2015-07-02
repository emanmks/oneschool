<?php

class Generation extends \Eloquent {
	protected $fillable = [];

	public function issues()
	{
		return $this->hasMany('Issue');
	}

	public function handbooks()
	{
		return $this->hasMany('Handbook');
	}

	public function courses()
	{
		return $this->hasMany('Course');
	}
}