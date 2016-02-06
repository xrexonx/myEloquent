<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Blog extends Eloquent {

	protected $fillable = ['userId', 'title', 'descriptions', 'contents', 'status'];
	public $timestamps = false;

}