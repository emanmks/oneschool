<?php

class Program extends \Eloquent {
	protected $fillable = [];

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function courses()
	{
		return $this->hasMany('Course');
	}
}