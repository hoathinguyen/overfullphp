<?php
/*----------------------------------------------------
* DbContext object class
* object for all context, which connect to database
* ----------------------------------------------------
*/
namespace Overfull\Database;
use Overfull\Database\Foundation\IActiveRecord;
use Overfull\Exception\ConnectionException;
use Overfull\Database\Schema;
use Bag;
use Overfull\Exception\SchemaNotFoundException;

/**
* 
*/
abstract class ActiveRecord implements IActiveRecord{
	protected $primaryKey = 'id';

    protected $autoIncrement = true;
	
	protected $tableName = null;

	protected $attributes = [];

	protected $schema = null;

	protected $connectionName = null;

	protected $connectionInfo = [];

	function __construct($connectionName, $connectionInfo){
		$this->connect($connectionName, $connectionInfo);
	}

	/**
     * Get instance of this class
     *
     * @param string $use: name of connection,
     * which is config in database.php
     * @return object
     */
	public static function instance($use = false){
		$class = get_called_class();
		$model = new $class($use);
		return $model;
	}

	/**
	 * Connect to database
	 *
	 * @param string $connectionName
	 * @param string $user
	 * @param string $password
	 * @param string $type
	 * @param string $host
	 * @param string $port
	 * @param string $dnname
	 * @return void
	 */
	public final function connect( $connectionName, $connectionInfo){
		$this->connectionName = $connectionName;
		$this->connectionInfo = $connectionInfo;

		if ( !isset(Bag::$dbStore->{$connectionName}) ) {
			// Create new connect
			Bag::$dbStore->{$connectionName} = new \PDO("{$connectionInfo['type']}:dbname={$connectionInfo['dbname']};host={$connectionInfo['host']}", $connectionInfo['user'], $connectionInfo['password']);

			if(!Bag::$dbStore->{$connectionName}){
				throw new ConnectionException($connectionName);
			}

			Bag::$dbStore->{$connectionName}->setAttribute( \PDO::ATTR_EMULATE_PREPARES, false );
			
			$this->schema(true);
		}
	}

	/**
     * Get schema of this class
     *
     * @return object
     */
	public final function schema($reset = false){
        if(!$this->schema || $reset){
			$chemaClass = "\Overfull\Database\Schema\\".ucfirst($this->connectionInfo['type'])."\Schema";

			if(!class_exists($chemaClass)){
				throw new SchemaNotFoundException($query);
	        }

	        $this->schema = new $chemaClass(Bag::$dbStore->{$this->connectionName}, get_class($this));
	        $this->schema->table($this->getTableName());
		}

		return $this->schema;
	}

	/**
	 * Begin transaction method
	 *
	 * @return void
	 */
	public function beginTransaction(){
		try {
			Bag::$dbStore->{$this->connectionName}->beginTransaction();
		} catch(Exception $e) {
			throw new Exception($e->getMessage(), 112);
		}
	}

	/**
	 * Rollback transaction
	 *
	 * @return void
	 */
	public function rollBack(){
		try {
			Bag::$dbStore->{$this->connectionName}->rollBack();
		} catch(Exception $e) {
			throw new Exception($e->getMessage(), 112);
		}
	}
	
	/**
	 * Commit transaction
	 *
	 * @return void
	 */
	public function commit(){
		try {
			Bag::$dbStore->{$this->connectionName}->commit();
		} catch(Exception $e) {
			throw new Exception($e->getMessage(), 112);
		}
	}

	/**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    // public static function __callStatic($method, $parameters){
    //     $instance = new static;

    //     return call_user_func_array([$instance, $method], $parameters);
    // }

    /**
     * Get primary key method
     *
     */
    public function getPrimaryKey(){
        return $this->primaryKey;
    }

    /**
     * Get primary key method
     *
     */
    public function getTableName(){
        return $this->tableName;
    }

    /**
     * Get find object
     *
     * @param mixed $id
     * @return object
     */
    public function find($id){
        // Create query
        return $this->schema()
            ->where([$this->primaryKey, '=', $id])
            ->one();
    } 

    /**
     * Get find object or new empty object
     *
     * @param mixed $id
     * @return object
     */
    public function findOrDefault($id){
        // Create query
        $rs = $this->schema()
            ->where([$this->primaryKey, '=', $id])
            ->one();

        if(!$rs){
            return $this;
        }
    }

    /**
     * Save object
     *
     * @return array
     */
    public function save(){
        if(!empty($this->attributes[$this->primaryKey])){
            $values = $this->attributes;
            unset($values[$this->primaryKey]);
            // Update
            return $this->schema()
                ->columns(array_keys($values))
                ->values($values)
                ->where([$this->primaryKey, '=', $this->attributes[$this->primaryKey]])
                ->update();
        } else {
            if($this->autoIncrement){
                $values = $this->attributes;
                unset($values[$this->primaryKey]);
            } else {
                $values = $this->attributes;
            }

            // Creates
            return $this->schema()
                ->columns(array_keys($values))
                ->values($values)
                ->insert();
        }
    }

    /**
     * Save object
     *
     * @return array
     */
    public function delete(){
        if(!empty($this->attributes[$this->primaryKey])){
            return $this->schema()
                ->where([$this->primaryKey, '=', $this->attributes[$this->primaryKey]])
                ->delete();
        }
    }

    /**
     * jsonSerialize method, which is implement from jsonSerialize, to json_encode .
     *
     * @return array
     */
    public function jsonSerialize(){
        return $this->attributes;
    }

    /**
     * __debugInfo method, return values when use debug.
     *
     * @return array
     */
    public function __debugInfo() {
        return $this->attributes;
    }

    /**
     * Auto call when set value for object properties
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
	public function __set($name, $value){
		$this->attributes[$name] = $value;
	}

    /**
     * Auto call when get value for object properties
     *
     * @param string $name
     * @return mixed
     */
	public function __get($name){
		if(!isset($this->attributes[$name])){
			return null;
		}
		return $this->attributes[$name];
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
    	return isset($this->attributes[$key]);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key){
        //unset($this->attributes[$key], $this->relations[$key]);
        unset($this->attributes[$key]);
    }
}