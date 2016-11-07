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

abstract class ActiveRecord implements IActiveRecord{
	protected $primaryKey = 'id';

    protected $autoIncrement = true;
	
	protected $tableName = null;

	protected $attributes = [];

    protected $oldAttributes = [];

	protected $schema = null;

	protected $connection = null;

	function __construct( $use = false ){
        $this->connect($use);
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
	 * @param array $connectionInfo
	 * @return void
	 */
	public final function connect($use = false){

        $databases = Bag::config()->get('databases');

        if ( !$use ) {
            $use = $databases['use'];
        }

        if(!isset($databases['connections'][$use])
            || empty($databases['connections'][$use]["type"])
            || empty($databases['connections'][$use]["host"])
            || empty($databases['connections'][$use]["dbname"])
            || empty($databases['connections'][$use]["user"])
            || !isset($databases['connections'][$use]["password"])){
            throw new DatabaseConfigException($use);
        }

		if ( !isset(Bag::dbStore()->{$use}) ) {
			// Create new connect
			Bag::dbStore()->{$use} = new \PDO("{$databases['connections'][$use]['type']}:dbname={$databases['connections'][$use]['dbname']};host={$databases['connections'][$use]['host']};charset={$databases['connections'][$use]['encoding']}", $databases['connections'][$use]['user'], $databases['connections'][$use]['password']);

			if(!Bag::dbStore()->{$use}){
				throw new ConnectionException($use);
			}
		}

        $this->connection = Bag::dbStore()->{$use};

        $this->connection->setAttribute( \PDO::ATTR_EMULATE_PREPARES, false );

        $this->schema($databases['connections'][$use]['type']);

        return $this;
	}

	/**
     * Get schema of this class
     *
     * @return object
     */
	public final function schema($type = false){
        if(!empty($type)){
			$chemaClass = "\Overfull\Database\Schema\\".ucfirst($type)."\Schema";

			if(!class_exists($chemaClass)){
				throw new SchemaNotFoundException($chemaClass);
	        }

	        $this->schema = new $chemaClass($this->connection, get_class($this));
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
			$this->connection->beginTransaction();
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
			$this->connection->rollBack();
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
			$this->connection->commit();
		} catch(Exception $e) {
			throw new Exception($e->getMessage(), 112);
		}
	}

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
        if($this->isNew()){
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
        } else {
            $values = $this->attributes;
            unset($values[$this->primaryKey]);
            // Update
            return $this->schema()
                ->columns(array_keys($values))
                ->values($values)
                ->where([$this->primaryKey, '=', $this->attributes[$this->primaryKey]])
                ->update();
        }
    }

    /**
     * Save object
     *
     * @return array
     */
    public function delete(){
        if(!$this->isNew()){
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
    public function isNew(){
        return empty($this->attributes[$this->getPrimaryKey()]);
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