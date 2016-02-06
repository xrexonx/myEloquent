<?php

require '../bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;

//Creates Table
Capsule::schema()->create('users', function($table)
{
    $table->increments('id');
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password', 60);
    $table->enum('status', ['1', '0']);
    $table->string('activationCode');
    $table->timestamps();
});