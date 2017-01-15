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

    // All of columns in this table will be save here
    protected $moreAttributes = [];

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
    public final function hasMany($activeRecord, $relative){
        $name = debug_backtrace()[1]['function'];
        $name = str_replace('relation', '', $name);
        $name = lcfirst($name);
        $this->relations[$name] = new HasMany(
                $this->connection,
                clone $this->schema,
                $activeRecord,
                $this,
                $relative);
        return $this->relations[$name]->parse()->schema();
    }

    /**
     * HasMany method
     * @param activeRecord $activeRecord object
     * @param string $relative They key of relation object
     * @param string $locale They key of relation object
     */
    public final function hasOne($activeRecord, $relative){
        $name = debug_backtrace()[1]['function'];
        $name = str_replace('relation', '', $name);
        $name = lcfirst($name);

        $this->relations[$name] = new HasOne(
                $this->connection,
                clone $this->schema,
                $activeRecord,
                $this,
                $relative);

        return $this->relations[$name]->parse()->schema();
    }

    /**
     * HasMany method
     * @param activeRecord $activeRecord object
     * @param string $relative They key of relation object
     * @param string $locale They key of relation object
     */
    public final function belongsTo($activeRecord, $relative){
        $name = debug_backtrace()[1]['function'];
        $name = str_replace('relation', '', $name);
        $name = lcfirst($name);

        $this->relations[$name] = new BelongsTo(
                $this->connection,
                clone $this->schema,
                $activeRecord,
                $this,
                $relative);

        return $this->relations[$name]->parse()->schema();
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
            $use = $databases['uses'];
        }

        if(!isset($databases['connections'][$use])
            || empty($databases['connections'][$use]["type"])
            || empty($databases['connections'][$use]["host"])
            || empty($databases['connections'][$use]["dbname"])
            || empty($databases['connections'][$use]["user"])
            || !isset($databases['connections'][$use]["password"])){
            throw new \Overfull\Exception\DatabaseConfigException($use);
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
     * Get primary key method
     *
     */
    public function isAttribute($name){
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Get primary key method
     *
     */
    public function isOldAttribute($name){
        return array_key_exists($name, $this->oldAttributes);
    }

    /**
     * Get primary key method
     *
     */
    public function isMoreAttribute($name){
        return array_key_exists($name, $this->moreAttributes);
    }

    /**
     * Get primary key method
     *
     */
    public function isRelation($name){
        return array_key_exists($name, $this->relations);
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
            ->first();
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
            $values = $this->attributes;
            if($this->autoIncrement){
                unset($values[$this->primaryKey]);
            }

            // Creates
            $rs = $this->schema()
                ->columns(array_keys($values))
                ->values($values)
                ->insert($isExecute);
        } else {
            $values = $this->attributes;
            foreach($values as $key => $value){
                if($key != $this->primaryKey
                        && $this->oldAttributes($key) == $value
                        ){
                    unset($values[$key]);
                }
            }
            // Update
            $rs = $this->schema()
                ->columns(array_keys($values))
                ->values($values)
                ->where([$this->primaryKey, '=', $this->attributes[$this->primaryKey]])
                ->update($isExecute, true);
        }

        if($isExecute){
            if($rs){
                if($this->isNew()){
                    $lastInsert = $this->instance()->find($this->schema->lastInsertPrimaryKey($this->primaryKey));
                } else {
                    $lastInsert = $this->instance()->find($this->attributes[$this->primaryKey]);
                }

                if(!$lastInsert){
                    return true;
                }

                foreach ($lastInsert->attributes() as $key => $value) {
                    $this->attributes[$key] = $value;
                }

                $this->makeOldAttributes();

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
        return array_merge($this->attributes, $this->relations, $this->moreAttributes);
    }

    /**
     * __debugInfo method, return values when use debug.
     *
     * @return array
     */
    public function __debugInfo() {
        return array_merge($this->attributes, $this->relations, $this->moreAttributes);
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
        if(!$this->isAttribute($name)){

            // Get attribute
            $__name = 'attribute'. ucfirst($name);
            if(method_exists($this, $__name) && 'attribute'.$name != $__name){

                if($this->isMoreAttribute($name)){
                    return $this->moreAttributes[$name];
                }

                $this->moreAttributes[$name] = $this->{$__name}();

                return $this->moreAttributes[$name];
            }

            // Get relation
            $__name = 'relation'. ucfirst($name);
            if(method_exists($this, $__name) && 'relation'.$name != $__name){
                if($this->isRelation($name)){
                    return $this->relations[$name]->data();
                }

                $this->{$__name}();

                return $this->relations[$name]->run()->data();
            }

            throw new \Overfull\Exception\UndefinedAttributeException($name, get_called_class());
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
    	return ($this->isAttribute($key) || $this->isRelation($key) || $this->isMoreAttribute($key));
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key){
        unset($this->attributes[$key], $this->relations[$key], $this->moreAttributes[$key]);
    }

    /**
     * Get attributes
     * @return array attributes
     */
    public function attributes($name = false){
        if(!$name){
            return $this->attributes;
        }
        if($this->isAttribute($name)){
            return $this->attributes[$name];
        }
        return null;
    }

    /**
     * Get attributes
     * @return array attributes
     */
    public function oldAttributes($name = false){
        if(!$name){
            return $this->oldAttributes;
        }
        if($this->isOldAttribute($name)){
            return $this->oldAttributes[$name];
        }
        return null;
    }

    /**
     * Get relations
     * @return array relations
     */
    public function relations($name = false){
        if(!$name){
            return $this->relations;
        }
        if($this->isRelation($name)){
            return $this->relations[$name];
        }
        return null;
    }

    /**
     * Get relations
     * @return array relations
     */
    public function moreAttributes($name = false){
        if(!$name){
            return $this->moreAttributes;
        }
        if($this->isMoreAttribute($name)){
            return $this->moreAttributes[$name];
        }
        return null;
    }

    /**
     * makeOldAttributes
     */
    public function makeOldAttributes(){
        $this->oldAttributes = $this->attributes;
        return $this;
    }
}
