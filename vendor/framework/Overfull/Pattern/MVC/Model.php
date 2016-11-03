<?php
/*___________________________________________________________________________
* The Model object class
* ___________________________________________________________________________
*/
namespace Overfull\Pattern\MVC;
use Overfull\Pattern\MVC\Foundation\IModel;
use Bag;
use Overfull\Exception\DatabaseConfigException;
use Overfull\Database\ActiveRecord;
use Overfull\Database\Query;
use JsonSerializable;

abstract class Model extends ActiveRecord implements IModel, JsonSerializable{
	

	protected $validates = [
	];

	protected $invalidErrors = [];

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

		parent::__construct( $this->connectionName,
				$databases['connections'][$this->connectionName]);
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
     * Convert the model to its string representation.
     *
     * @return string
     */
    //public function __toString()
    //{
        //return $this->toJson();
    //}

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
}