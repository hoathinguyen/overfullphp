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
	protected $attributes = [];
	
	/**
	 * Get package
	 * 
	 * @param string $name
	 * @return Package object
	 */
	function __get($name){
		return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
	}

	/**
	 * Set package
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return Package object
	 */
	function __set($name, $value){
		return $this->attributes[$name] = $value;
	}

	/**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key){
    	return isset($this->attributes[$key]);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key){
        unset($this->attributes[$key]);
    }
}