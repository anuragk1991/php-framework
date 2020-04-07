<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Exceptions\MethodNotAllowedException;

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
		$this->container->router->addRoute($uri, $handler, ['GET']);
	}

	public function post($uri, $handler)
	{
		$this->container->router->addRoute($uri, $handler, ['POST']);
	}

	public function map($uri, $handler, $method = ['GET'])
	{
		$this->container->router->addRoute($uri, $handler, $method);
	}



	public function run()
	{
		$path = $_SERVER['PATH_INFO'] ?? '/';
		$router = $this->container->router;
		$router->setPath($path);

		try{
			$response = $router->getResponse();	
		}catch(RouteNotFoundException $e){
			if(isset($this->container->errorHandler)){
				$this->container->errorHandler();
			}else{
				return;
			}
		}catch(MethodNotAllowedException $e){
			if(isset($this->container->errorHandler)){
				$this->container->errorHandler();
			}else{
				return;
			}
		}

		

		$this->process($response);
	}

	public function process(callable $callable)
	{
		return $callable();
	}

}
