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
}