<?php
/*___________________________________________________________________________
* The Model object class
* ___________________________________________________________________________
*/
namespace Overfull\Pattern\MVC;
use Overfull\Pattern\MVC\Foundation\IModel;
use Bag;
use Overfull\Exception\DatabaseConfigException;
use Overfull\Database\DbContext;
use Overfull\Database\Query;
use JsonSerializable;

abstract class Model extends DbContext implements IModel, JsonSerializable{
	protected $primaryKey = 'id';

    protected $autoIncrement = true;
	
	protected $table = null;

	public $attributes = [];

	protected $validates = [
	];

	protected $invalidErrors = [];

	protected $query = null;

    /**
     * Construct
     *
     * @param string $use: name of connection,
     * which is config in database.php
     */
	function __construct( $use = false ){
		$databases = Bag::config()->get('databases');

		if ( !$use ) {
			if(!$this->connectionName){
				$this->connectionName = $databases['use'];
			}
		}else {
			$this->connectionName = $use;
		}

		if(!isset($databases['connections'][$this->connectionName])
			|| empty($databases['connections'][$this->connectionName]["type"])
			|| empty($databases['connections'][$this->connectionName]["host"])
			|| empty($databases['connections'][$this->connectionName]["dbname"])
			|| empty($databases['connections'][$this->connectionName]["user"])
			|| !isset($databases['connections'][$this->connectionName]["password"])){
			throw new DatabaseConfigException($this->connectionName);
		}

		$this->connect( $this->connectionName,
				$databases['connections'][$this->connectionName]["user"],
				$databases['connections'][$this->connectionName]["password"],
				$databases['connections'][$this->connectionName]["type"],
				$databases['connections'][$this->connectionName]["host"],
				'',
				$databases['connections'][$this->connectionName]["dbname"]);
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
     * Get find object
     *
     * @param mixed $id
     * @return object
     */
    public function find($id){
        // Create query
        return $this->query()
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
        $rs = $this->query()
            ->where([$this->primaryKey, '=', $id])
            ->one();

        if(!$rs){
            return $this;
        }
    } 

    /**
     * Get query of this class
     *
     * @return object
     */
	public function query(){
        if(!$this->query){
            $this->query = new Query($this->connectionName, get_class($this));
            $this->query->table($this->table);
        }

		return $this->query;
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
    public function __isset($key)
    {
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
    public function __unset($key)
    {
        //unset($this->attributes[$key], $this->relations[$key]);
        unset($this->attributes[$key]);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    //public function __call($method, $parameters)
    //{
        // if (in_array($method, ['increment', 'decrement'])) {
        //     return call_user_func_array([$this, $method], $parameters);
        // }

        //$query = $this->newQuery();

        //return call_user_func_array([$query, $method], $parameters);
    //}

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    //public static function __callStatic($method, $parameters)
    //{
        //$instance = new static;

        //return call_user_func_array([$instance, $method], $parameters);
    //}

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    //public function __toString()
    //{
        //return $this->toJson();
    //}

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
     * Save object
     *
     * @return array
     */
    public function save(){
        if(!empty($this->attributes[$this->primaryKey])){
            $values = $this->attributes;
            unset($values[$this->primaryKey]);
            // Update
            return $this->query()
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
            return $this->query()
                ->columns(array_keys($values))
                ->values($values)
                ->insert();
        }
    }
}