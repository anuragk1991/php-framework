<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require('vendor/autoload.php');

$app = new App\App;

$container = $app->getContainer();
$container['config'] = function(){
	return [
		'db_driver' => 'mysql',
		'db_host' => '127.0.0.1',
		'db_user' => 'anurag',
		'db_pass' => 'password',
		'dbname' => 'db1'
	]; 
};

$container['db'] = function($c){
	return new PDO(
		$c->config['db_driver'].':host='.$c->config['db_host'].';dbname='.$c->config['dbname'],
		$c->config['db_user'], 
		$c->config['db_pass']
	);
};

$app->get('/home', function(){
	echo 'Home';
});

$app->get('/users', function(){
	echo 'Users';
});

$app->run();

