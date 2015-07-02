<?php

class Reduction extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function receivable()
	{
		return $this->belongsTo('Receivable');
	}

	public function reductable()
	{
		return $this->morphTo();
	}
}