# Don't read me!

This pretty usefull for a smaller vanilla PHP project that doesn't require the full-stack laravel framework.


## Installation

Clone this repo
```sh
$ git clone https://github.com/xrexonx/myEloquent.git
```
or you can manually download the zip file [here] on github. 
[here]: <https://github.com/xrexonx/myEloquent>

## Config
Configure your database connections on yourProject/config/database.php file.

```php
<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'databasename',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

```
## Creating Migrations

On your projectPath/migrations/ Create a file create_table_users.php

```php
<?php

require 'bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Create Users Table
// =================================
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

```
And then run this on your terminal
```sh
$ cd $yourProjectPath/migrations/
$ php create_table_users.php
```

or simply run this on your browser
```sh
localhost/yourProjectName/migrations/create_table_users.php
```
It will create your users table on your database.

## Basic Usage

```php
<?php

require 'bootstrap.php';

// Create new records
// =================================
User::create([
	'name' => 'John Doe',
	'email' => 'johndoe@gmail.com',
	'password' => md5('secret'),
	'status' => '1',
	'activationCode' => md5('johndoe@gmail.com')
]);

// Get 
// =================================
dd(User::first()->toArray());

// Updates
// =================================
$user = User::first();
$user->email = 'jd@gmail.com';
$user->save();

// Delete
// =================================
$user = User::find(1);
$user->delete();

```

More documentations on
```sh
https://github.com/illuminate/database
https://laravel.com/docs/5.1/eloquent
```
## License
MIT © [Rexon A. De los Reyes](http://xrexonx.github.io)

Thanks and enjoy!