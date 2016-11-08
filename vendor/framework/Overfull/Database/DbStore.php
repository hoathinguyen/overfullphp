<?php
/*----------------------------------------------------
* Filename: DbStore.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The DbStore, this object will save all of connection
* ----------------------------------------------------
*/
namespace Overfull\Database;
use Overfull\Foundation\Base\BaseObject;

class DbStore extends BaseObject{
	protected $connections = [];

	/**
	 * Auto call when set new connection
	 *
	 * @param string $name
	 * @param string $value
	 * @return void
	 */
	public function __set($name, $value){
		$this->connections[$name] = $value;
	}

	/**
	 * Auto call when get connection
	 *
	 * @param string $name
	 * @return void
	 */
	public function __get($name){
		if(!isset($this->connections[$name])){
			return null;
		}
		return $this->connections[$name];
	}

	/**
     * Determine if an attribute exists on the dbstore.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key){
    	return isset($this->connections[$key]);
    }

    /**
     * Unset an attribute on the dbstore.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key){
        unset($this->connections[$key]);
    }
}