<?php

use Illuminate\Database\Capsule\Manager as Capsule;

//Creates Table
// Capsule::schema()->create('users', function($table)
// {
//     $table->increments('id');
//     $table->string('email')->unique();
//     $table->timestamps();
// });

//Insert
// User::create(['email' => 'johndoe@gmail.com']);

// Get Where
// dd(User::where('id', 1)->get()->toArray());

//Updates
// $user = User::first();
// $user->email = 'jd@gmail.com';
// $user->save();
// dd(User::first()->toArray());