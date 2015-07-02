<?php

class Receivable extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function issue()
	{
		return $this->belongsTo('Issue');
	}

	public function registration()
	{
		return $this->belongsTo('Registration');
	}

	public function reductions()
	{
		return $this->hasMany('Reduction');
	}

	public function installments()
	{
		return $this->hasMany('Installment');
	}

	public function unpaid_installments()
	{
		return $this->hasMany('Installment')->where('paid','=',0);
	}

	public function earnables()
	{
		return $this->morphMany('Earning','earnable');
	}
}