<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent {

	protected $fillable = ['name', 'email', 'password', 'status', 'activationCode'];
	public $timestamps = false;

}