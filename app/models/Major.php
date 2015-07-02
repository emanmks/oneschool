<?php

class Major extends \Eloquent {
	protected $fillable = [];

	public function handbooks()
	{
		return $this->hasMany('Handbook');
	}

	public function courses()
	{
		return $this->hasMany('Course');
	}
}