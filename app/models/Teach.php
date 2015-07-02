<?php

class Teach extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function course()
	{
		return $this->belongsTo('Course');
	}

	public function subject()
	{
		return $this->belongsTo('Subject');
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

	public function hour()
	{
		return $this->belongsTo('Hour');
	}

	public function presences()
	{
		return $this->hasMany('Presence');
	}

}