<?php

require 'vendor/autoload.php';
require 'config/database.php';

// require 'start.php';

use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$data = [
	'name' => 'sadasdsfsdf',
];

echo $blade
		->view()
		->make('hello')
		->render();
