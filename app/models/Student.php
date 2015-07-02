<?php

class Student extends \Eloquent {
	protected $fillable = [];

	public function issues()
	{
		return $this->hasMany('Issue');
	}
}