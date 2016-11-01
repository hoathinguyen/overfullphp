<?php
/*----------------------------------------------------
* Filename: Auth.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Authentication package
* ----------------------------------------------------
*/
namespace Packages\Authentication;
use Bag;

class LoggedData{
	private $attributes = [];
	/**
	* __get method
	*
	* @param string $name
	* @return value
	*/
	public function __get($name){
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