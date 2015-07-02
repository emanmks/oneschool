<?php

class Handbook extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function generation()
	{
		return $this->belongsTo('Generation');
	}

	public function major()
	{
		return $this->belongsTo('Major');
	}

	public function retrievals()
	{
		return $this->hasMany('Retrieval')->where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id);
	}
}
