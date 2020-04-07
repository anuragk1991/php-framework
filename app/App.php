<?php

namespace App;

class App
{
	protected $container;

	public function __construct()
	{
		$this->container = new Container([
			'router' => function(){
				return new Router;
			}
		]);
	}

	public function getContainer()
	{
		return $this->container;
	}

	public function get($uri, $handler)
	{
		$this->container->router->addRoute($uri, $handler);
	}

	public function run()
	{
		$path = $_SERVER['PATH_INFO'] ?? '/';
		$router = $this->container->router;
		$router->setPath($path);

		$response = $router->getResponse();
		$this->process($response);
	}

	public function process(callable $callable)
	{
		return $callable();
	}

}
