<?php
/*----------------------------------------------------
* Filename: ActiveRecord.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The ActiveRecord will be use as a row
* in table of database.
* ----------------------------------------------------
*/
namespace Overfull\Database\Eloquent;
use Bag;
use Overfull\Database\Schema;
use Overfull\Database\Eloquent\Foundation\IActiveRecord;
use Overfull\Exception\ConnectionException;
use Overfull\Exception\SchemaNotFoundException;
use Overfull\Foundation\Base\BaseObject;
use Overfull\Database\Eloquent\Relations\BelongsTo;
use Overfull\Database\Eloquent\Relations\HasMany;
use Overfull\Database\Eloquent\Relations\HasOne;

abstract class ActiveRecord extends BaseObject implements IActiveRecord{
    // The primary key of table
    protected $primaryKey = 'id';

    // The flag as auto increment in database
    protected $autoIncrement = true;
	
    // The table name in database
    protected $tableName = null;

    // All of columns in this table will be save here
    protected $attributes = [];

    // The last value of table
    protected $oldAttributes = [];

    // The schema which will access database
    protected $schema = null;
    
    protected $relations = [];

    // The connection, which connect between db and php
    protected $connection = null;
	function __construct( $use = false ){
        $this->connect($use);
    }

    protected function beforeSave(){}
    
    /**
     * HasMany method
     * @param activeRecord $activeRecord object
     * @param string $relative They key of relation object
     * @param string $locale They key of relation object
     */
    public final function hasMany($activeRecord, $relative, $locale){
        $name = debug_backtrace()[1]['function'];
        $this->relations[$name] = new HasMany($this->connection, $activeRecord, $relative, $locale);
        return $this->relations[$name]->schema();
    }

    /**
     * HasMany method
     * @param activeRecord $activeRecord object
     * @param string $relative They key of relation object
     * @param string $locale They key of relation object
     */
    public final function hasOne($activeRecord, $relative, $locale){
        $name = debug_backtrace()[1]['function'];
        $this->relations[$name] = new HasOne($this->connection, $activeRecord, $relative, $locale);
        return $this->relations[$name]->schema();
    }

    /**
     * HasMany method
     * @param activeRecord $activeRecord object
     * @param string $relative They key of relation object
     * @param string $locale They key of relation object
     */
    public final function belongsTo($activeRecord, $relative, $locale){
        $name = debug_backtrace()[1]['function'];
        $this->relations[$name] = new BelongsTo($this->connection, $activeRecord, $relative, $locale);
        return $this->relations[$name]->schema();
    }

/**
     * Get instance of this class
     *
     * @param string $use: name of connection,
     * which is config in database.php
     * @return current object
     */
    public static function instance($use = false){
        $class = static::className();
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

        if ( !isset(Bag::db()->{$use}) ) {
            // Create new connect
            Bag::db()->{$use} = new \PDO("{$databases['connections'][$use]['type']}:dbname={$databases['connections'][$use]['dbname']};host={$databases['connections'][$use]['host']};charset={$databases['connections'][$use]['encoding']}", $databases['connections'][$use]['user'], $databases['connections'][$use]['password']);

            if(!Bag::db()->{$use}){
                    throw new ConnectionException($use);
            }
        }

        $this->connection = Bag::db()->{$use};

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
        // Check if type is exists.
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
     * @return instance
     */
    public function beginTransaction(){
        $this->connection->beginTransaction();
        return $this;
    }

    /**
     * Rollback transaction
     *
     * @return instance
     */
    public function rollBack(){
        $this->connection->rollBack();
        return $this;
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
        $rs = $this->find($id);

        if(!$rs){
            return $this;
        }
    }

    /**
     * Save object
     *
     * @return array
     */
    public function save($isExecute = true){
        $this->beforeSave();
        
        if($this->isNew()){
            if($this->autoIncrement){
                $values = $this->attributes;
                unset($values[$this->primaryKey]);
            } else {
                $values = $this->attributes;
            }

            // Creates
            $rs = $this->schema()
                ->columns(array_keys($values))
                ->values($values)
                ->insert($isExecute);
        } else {
            $values = $this->attributes;
            unset($values[$this->primaryKey]);
            // Update
            $rs = $this->schema()
                ->columns(array_keys($values))
                ->values($values)
                ->where([$this->primaryKey, '=', $this->attributes[$this->primaryKey]])
                ->update($isExecute);
        }

        if($isExecute){
            if($rs){
                if($this->isNew()){
                    $lastInsert = $this->find($this->connection->lastInsertId());
                } else {
                    $lastInsert = $this->find($this->attributes[$this->primaryKey]);
                }
                
                foreach ($lastInsert->attributes() as $key => $value) {
                    $this->attributes[$key] = $value;
                }

                return true;
            }

            return false;
        }

        return $rs;
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
        $__name = 'get'. ucfirst($name);
        
        if(method_exists($this, $__name) && 'get'.$name != $__name){
            if(!empty($this->relations[$__name])){
                return $this->relations[$__name]->data();
            }
            
            $this->{$__name}();
            
            $this->relations[$__name]->execute();
            
            return $this->relations[$__name]->data();
        }
        
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
    	return (isset($this->attributes[$key]) || isset($this->relations[$key]));
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

    /**
     * Get attributes
     * @return array attributes
     */
    public function attributes(){
        return $this->attributes;
    }
}