<?php

require 'bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Create Users Table
// =================================
// Capsule::schema()->create('users', function($table)
// {
//     $table->increments('id');
//     $table->string('name');
//     $table->string('email')->unique();
//     $table->string('password', 60);
//     $table->enum('status', ['1', '0']);
//     $table->string('activationCode');
//     $table->timestamps();
// });


// Create new records
// =================================
// User::create([
// 	'name' => 'John Doe',
// 	'email' => 'johndoe@gmail.com',
// 	'password' => md5('secret'),
// 	'status' => '1',
// 	'activationCode' => md5('johndoe@gmail.com')
// ]);


// Get 
// =================================
// dd(User::first()->toArray());


// Updates
// =================================
// $user = User::first();
// $user->email = 'jd@gmail.com';
// $user->save();


// Delete
// =================================
// $user = User::find(1);
// $user->delete();