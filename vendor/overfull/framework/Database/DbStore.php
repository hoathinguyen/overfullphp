<?php
/*
* Filename: DbStore.php
* @author: Overfull.net
* @date: 2016/10/25
* @description: The DbStore, this object will save all of connection
*/
namespace Overfull\Database;

class DbStore extends \Overfull\Foundation\Base\BaseObject
{
    protected $connections = [];

    /**
     * Auto call when set new connection
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->connections[$name] = $value;
    }

    /**
     * Auto call when get connection
     *
     * @param string $name
     * @return Connection
     */
    public function __get($name)
    {
        return $this->get($name);
    }
    
    /**
     * Determine if an attribute exists on the dbstore.
     *
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
    	return isset($this->connections[$key]);
    }

    /**
     * Unset an attribute on the dbstore.
     *
     * @param string $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->connections[$key]);
    }

    /**
     * GEt an attribute on the db.
     *
     * @param string $name
     * @return void
     */
    public function get($name)
    {
    	if(!isset($this->connections[$name]))
        {
            return null;
        }
        
        return $this->connections[$name];
    }

    /**
     * Set connection
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function set($name, $value)
    {
    	$this->connections[$name] = $value;
    	return $this;
    }

    /**
     * beginTransaction all
     *
     * @return void
     */
    public function beginTransaction()
    {
        foreach($this->connections as $value){
            $value->beginTransaction();
        }
    }

    /**
    * beginTransaction all
    *
    * @return void
    */
    public function rollBack()
    {
        foreach($this->connections as $value){
            $value->rollBack();
        }
    }

    /**
    * beginTransaction all
    *
    * @return void
    */
    public function commit()
    {
        foreach($this->connections as $value){
            $value->commit();
        }
    }
}