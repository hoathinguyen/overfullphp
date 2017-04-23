<?php
/*----------------------------------------------------
* Filename: Store.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Store
* ----------------------------------------------------
*/
namespace Overfull\Support;
use Overfull\Foundation\Base\BaseObject;

class Store extends BaseObject{
	protected $attributes = [];
	
	/**
	 * Get module
	 * 
	 * @param string $name
	 * @return module object
	 */
	function __get($name){
		return $this->get($name);
	}

	/**
	 * Set module
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return module object
	 */
	function __set($name, $value){
		return $this->add($name, $value);
	}

	/**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($name){
    	return $this->isExists($name);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($name){
        $this->remove($name);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function add($name, $value, $group = null){
        if($group){
            $name = $group.'-'.$name;
        }

    	$this->attributes[$name] = $value;
    	return $this;
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function get($name, $group = null){
        if($group){
            $name = $group.'-'.$name;
        }

    	return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function remove($name, $group = null){
        if($group){
            $name = $group.'-'.$name;
        }

    	unset($this->attributes[$name]);
    	return $this;
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function isExists($name, $group = null){
        if($group){
            $name = $group.'-'.$name;
        }
        
    	return isset($this->attributes[$name]);
    }
}