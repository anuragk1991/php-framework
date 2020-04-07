<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Exceptions\MethodNotAllowedException;

class Router
{
	protected $path;
	protected $routes = [];
	protected $methods = [];

	public function addRoute($uri, $handler, $method = [])
	{
		$this->methods[$uri] = $method;
		$this->routes[$uri] = $handler;
	}

	public function setPath($path = '/')
	{
		$this->path = $path;
	}

	public function getResponse()
	{
		if(!isset($this->routes[$this->path])){
			throw new RouteNotFoundException;
		}

		if(!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path])){
			throw new MethodNotAllowedException;
		}

		return $this->routes[$this->path];
	}

}