<?php

class Issue extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function student()
	{
		return $this->belongsTo('Student');
	}

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function location()
	{
		return $this->belongsTo('Location');
	}

	public function generation()
	{
		return $this->belongsTo('Generation');
	}

	public function registration()
	{
		return $this->belongsTo('Registration');
	}

	public function placements()
	{
		return $this->hasMany('Placement');
	}

	public function placement()
	{
		return $this->hasOne('Placement')->where('project_id','=',Auth::user()->curr_project_id)
								->where('location_id','=',Auth::user()->location_id);
	}

	public function receivable()
	{
		return $this->hasOne('Receivable');
	}

	public function educations()
	{
		return $this->hasMany('Education');
	}

	public function schools()
	{
		return $this->hasManyThrough('School','Education');
	}	

	public function education()
	{
		return $this->hasOne('Education')->where('project_id','=',Auth::user()->curr_project_id);
	}

	public function earnings()
	{
		return $this->hasMany('Earning');
	}

	public function punishments()
	{
		return $this->hasMany('Punishment');
	}

	public function returnments()
	{
		return $this->hasMany('Returnment');
	}

	public function presences()
	{
		return $this->hasMany('Presence');
	}

	public function points()
	{
		return $this->hasMany('Point');
	}

	public function retrievals()
	{
		return $this->hasMany('Retrieval');
	}

	public function timelines()
	{
		return $this->morphMany('Timeline','informable');
	}

	public function recommenders()
	{
		return $this->morphMany('Registration','recommender');
	}

	public function masteries()
	{
		return $this->hasMany('Mastery');
	}
}