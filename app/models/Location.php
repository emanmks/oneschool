<?php

class Location extends \Eloquent {
	protected $fillable = [];

	public function issues()
	{
		return $this->hasMany('Issue')->where('project_id','=',Auth::user()->curr_project_id);
	}

	public function courses()
	{
		return $this->hasMany('Course')->where('project_id','=',Auth::user()->curr_project_id);
	}
}