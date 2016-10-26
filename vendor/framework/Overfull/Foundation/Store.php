<?php
/*----------------------------------------------------
* Filename: Store.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Store
* ----------------------------------------------------
*/
namespace Overfull\Foundation;
use Overfull\Foundation\Base\BaseObject;

abstract class Store extends BaseObject{
	protected $__store = [];
	
	/**
	 * Get package
	 * 
	 * @param string $name
	 * @return Package object
	 */
	function __get($name){
		return isset($this->__store[$name]) ? $this->__store[$name] : null;
	}

	/**
	 * Set package
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return Package object
	 */
	function __set($name, $value){
		return $this->__store[$name] = $value;
	}
}