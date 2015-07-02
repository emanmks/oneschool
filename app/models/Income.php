<?php

class Income extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function classification()
	{
		return $this->belongsTo('Classification');
	}

	public function employee()
	{
		return $this->belongsTo('Employee');
	}

}