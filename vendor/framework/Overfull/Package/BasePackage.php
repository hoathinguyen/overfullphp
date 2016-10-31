<?php
namespace Overfull\Package;

use Overfull\Foundation\Base\BaseObject;

class BasePackage extends BaseObject{
	private $attributes = [];
	/**
	* __get method
	*
	* @param string $name
	* @return value
	*/
	public function __get($name){
		//
		return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
	}

	/**
	* __get method
	*
	* @param string $name
	* @return value
	*/
	public function __set($name, $value){
		//Nothing
		$this->attributes[$name] = $value;
	}
}