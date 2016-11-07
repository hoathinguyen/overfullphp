<?php
/*----------------------------------------------------
* DBStore object class
* The object contains all of connections
* ----------------------------------------------------
*/
namespace Overfull\Database;
use Overfull\Foundation\Base\BaseObject;

/**
* 
*/
class DbStore extends BaseObject{
	protected $__connections = [];

	/**
	 * Auto call when set new connection
	 *
	 * @param string $name
	 * @param string $value
	 * @return void
	 */
	public function __set($name, $value){
		$this->__connections[$name] = $value;
	}

	/**
	 * Auto call when get connection
	 *
	 * @param string $name
	 * @return void
	 */
	public function __get($name){
		if(!isset($this->__connections[$name])){
			return null;
		}
		return $this->__connections[$name];
	}

	/**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key){
        //return (isset($this->attributes[$key]) || isset($this->relations[$key])) ||
          //      ($this->hasGetMutator($key) && ! is_null($this->getAttributeValue($key)));
    	return isset($this->__connections[$key]);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key){
        //unset($this->attributes[$key], $this->relations[$key]);
        unset($this->__connections[$key]);
    }
}