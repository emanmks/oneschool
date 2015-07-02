<?php

class Voucher extends \Eloquent {
	protected $fillable = [];

	public function reductions()
	{
		return $this->morphMany('Reduction','reductable');
	}
}