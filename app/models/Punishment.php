<?php

class Punishment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function earnables()
	{
		return $this->morphMany('Earning','earnable');
	}

	public function issue()
	{
		return $this->belongsTo('Issue');
	}
}