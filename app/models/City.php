<?php

class City extends \Eloquent {
	protected $fillable = [];

	public function State()
	{
		return $this->belongsTo('State');
	}
}