<?php

namespace App;

use ArrayAccess;

class Container implements ArrayAccess
{
	protected $items = [];
	protected $cache = [];

	public function __get($property)
	{
		return $this->offsetGet($property);
	}

	public function offsetSet($property, $value)
	{

		$this->items[$property] = $value;
		
	}

	public function offsetGet($property)
	{
		if(!$this->offsetExists($property)){
			return null;
		}

		if(isset($this->cache[$property])){
			return $this->cache[$property];
		}

		$item = $this->items[$property]($this);
		$this->cache[$property] = $item;

		return $item;
	}

	public function offsetExists($property)
	{
		return isset($this->items[$property]);
	}

	public function has($property)
	{
		return $this->offsetGet($property);
	}

	public function offsetUnset($property)
	{
		if($this->offsetExists($property)){
			unset($this->items[$property]);
		}
		
	}

}