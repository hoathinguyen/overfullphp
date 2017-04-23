<?php
namespace Overfull\Modules\Foundation;

use Overfull\Foundation\Base\BaseObject;

abstract class BaseModule extends BaseObject{
	protected $attributes = [];
	
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
		$this->attributes[$name] = $value;
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