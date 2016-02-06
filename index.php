<?php

require 'bootstrap.php';

// Using the Laravel's Blade Templating...
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

echo $blade
		->view()
		->make('hello')
		->render();
