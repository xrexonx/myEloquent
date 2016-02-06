<?php

require '../bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;

//Creates Table
Capsule::schema()->create('blog', function($table)
{
    $table->increments('id');
    $table->integer('userId');
    $table->string('title');
    $table->string('descriptions');
    $table->string('contents');
    $table->enum('status', ['1', '0']);
    $table->timestamps();
});