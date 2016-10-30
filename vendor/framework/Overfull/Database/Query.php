<?php
/*----------------------------------------------------
* Query object class
* This object will handle sql string and perform that
* ----------------------------------------------------
*/
namespace Overfull\Database;
use Bag;
use Overfull\Database\Console\SQLCommand;

class Query implements \JsonSerializable{
	protected $connectionName;

	protected $object = '';

	protected $data = [
		// common
		'table' => '', // all
		'values' => [], // Update and insert
		'where' => [
			//['operation' => '', 'type' => 'simple', 'values' => ['user_uid', '=', 'user_40']],

			// ['operation' => 'AND', 'type' => 'group', 'values' => [
			// 		['operation' => '', 'type' => 'simple', 'values' => ['user_uid', '=', 'user_40']],
			// 	]
			// ]
		], // Update and select
		// select
		'columns' => ['*'],
		'joins' => [
			//['type' => 'inner', 'table' => '', 'on' => '']
		],
		'offset' => false,
		'limit' => false
		// update
		
		
		// Insert
	];

	/**
	 * Construct
	 *
	 * @param string $connectionName
	 * @param mixed $object
	 * @return void
	 */
	function __construct($connectionName = null, $object = null){
		$this->connectionName = $connectionName;
		$this->object = $object;
	}

	/**
	 * Clear sql
	 *
	 * @return void
	 */
	public function clear(){
		$this->data['values'] = [];
		$this->data['where'] = [];
		$this->data['columns'] = ['*'];
		$this->data['joins'] = [];
		$this->data['offset'] = false;
		$this->data['limit'] = false;
		return $this;
	}

	/**
	 * Set connection name
	 *
	 * @param string $connectionName
	 * @return void
	 */
	public function setConnectionName($connectionName = null){
		$this->connectionName = $connectionName;
		return $this;
	}

	/**
	 * set object
	 *
	 * @param mixed $object
	 * @return void
	 */
	public function setObject($object = null){
		$this->object = $object;
		return $this;
	}
	/**
	 * Set select
	 *
	 * @param array $colums
	 * @return void
	 */
	public function columns($colums){
		if(is_array($colums)){
			$this->data['columns'] = $colums;
		} else {
			$this->data['columns'] = [$colums];
		}

		return $this;
	}
	/**
	 * Set from syntax value
	 *
	 * @param string $table
	 * @return void
	 */
	public function table($table, $as = ''){
		if(is_object($table)){
			$class = get_class($this);
			$q = new $class();
			$table($q);
			$this->data['table'] = '('.$q->all(false).')'.($as ? " {$as}" : '');
		}else{
			$this->data['table'] = $table;
		}
		return $this;
	}

	/**
	 * Set where syntax value. Sample you can send.
	 * ['columns', '', 'columns'], ''
	 * @param mixed $data
	 * @return void
	 */
	public function where($conditions){
		if(is_object($conditions)){
			$class = get_class($this);
			$q = new $class();
			$conditions($q);

			$this->data['where'][] = [
				'operation' => '',
				'type' => 'group',
				'values' => $q->getWhere()
			];
		} else {
			$this->data['where'][] = [
				'operation' => '',
				'type' => 'simple',
				'values' => $conditions
			];
		}
		return $this;
	}

	/**
	 * Set andwhere syntax value. Sample you can send.
	 * ['columns', '', 'columns'], ''
	 * @param mixed $data
	 * @return void
	 */
	public function andWhere($conditions){
		if(is_object($conditions)){
			$class = get_class($this);
			$q = new $class();
			$conditions($q);

			$this->data['where'][] = [
				'operation' => 'AND',
				'type' => 'group',
				'values' => $q->getWhere()
			];
		} else {
			$this->data['where'][] = [
				'operation' => 'AND',
				'type' => 'simple',
				'values' => $conditions
			];
		}
		return $this;
	}

	/**
	 * Set andwhere syntax value. Sample you can send.
	 * ['columns', '', 'columns'], ''
	 * @param mixed $data
	 * @return void
	 */
	public function orWhere($conditions){
		if(is_object($conditions)){
			$class = get_class($this);
			$q = new $class();
			$conditions($q);

			$this->data['where'][] = [
				'operation' => 'OR',
				'type' => 'group',
				'values' => $q->getWhere()
			];
		} else {
			$this->data['where'][] = [
				'operation' => 'OR',
				'type' => 'simple',
				'values' => $conditions
			];
		}
		return $this;
	}

	/**
	 * join
	 * @param string $table
	 * @param array join
	 * @return this
	 */
	public function join($table, $conditions){
		$this->data['joins'][] = ['type' => 'JOIN',
			'table' => $table,
			'on' => $conditions];
		return $this;
	}

	/**
	 * Set offset
	 * @param int $offset
	 * @return this
	 */
	public function offset($offset){
		$this->data['offset'] = $offset;
		return $this;
	}

	/**
	 * Set limit
	 * @param int $limit
	 * @return this
	 */
	public function limit($limit){
		$this->data['limit'] = $limit;
		return $this;
	}

	/**
	 * value
	 * @param int $limit
	 * @return this
	 */
	public function values($nameOrValues, $values = ''){
		if(is_string($nameOrValues)){
			$this->data['values'][] = [$nameOrValues => $values];
		} else{
			$this->data['values'][] = $nameOrValues;
		}
		return $this;
	}

	/**
	 * Select all
	 *
	 * @return void
	 */
	public function all($isExecute = true){
		try{
			$sql = SQLCommand::select($this->data);

			if($isExecute){
				$sql = $this->query($sql);
				if(!$sql || count($sql) == 0){
					$sql = [];
				}
			}

			$this->clear();

			return $sql;
		} catch (\Exception $e){
			throw $e;
		}
	}

	/**
	 * Select one
	 *
	 * @return void
	 */
	public function one($isExecute = true){
		try{
			$this->data['limit'] = 1;

			$sql = SQLCommand::select($this->data);

			if($isExecute){
				$sql = $this->query($sql);
				if(!$sql || count($sql) == 0){
					$sql = null;
				} else {
					$sql = $sql[0];
				}
			}

			$this->clear();

			return $sql;
		} catch (\Exception $e){
			throw $e;
		}
	}

	/**
	 * Execute sql
	 *
	 * @return array
	 */
	public function query($sql){
		try {
			Bag::$dbstore->{$this->connectionName}->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			$result = Bag::$dbstore->{$this->connectionName}->query($sql);

			if(!$this->object){
				return $result->fetchAll();
			}

			return $result->fetchAll(\PDO::FETCH_CLASS, $this->object);
		}catch (\PDOException $err) {
		    throw $err;
		}
	}

	/**
	 * Execute sql
	 *
	 * @return array
	 */
	public function execute($sql, $parameters = []){
		try {
			Bag::$dbstore->{$this->connectionName}->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			$dpo = Bag::$dbstore->{$this->connectionName}->prepare($sql);

			$result = $dpo->execute($parameters);

			return $result;
		}catch (\PDOException $err) {
		    throw $err;
		}
	}

	/**
	 * Get where conditions
	 *
	 * @return array
	 */
	public function getWhere(){
		return $this->data['where'];
	}

	/**
	 * Get data
	 *
	 * @return array
	 */
	public function getData(){
		return $this->data;
	}

	/**
     * jsonSerialize method, which is implement from jsonSerialize, to json_encode .
     *
     * @return array
     */
    public function jsonSerialize(){
        return $this->data;
    }

    /**
     * __debugInfo method, return values when use debug.
     *
     * @return array
     */
    public function __debugInfo() {
        return $this->data;
    }

    /**
     * update.
     *
     * @return array
     */
    public function update($isExecute = true){
    	$sql = SQLCommand::update($this->data);

    	if($isExecute){
    		$sql = $this->execute($sql);
    	}
    	
    	$this->clear();

    	return $sql;
    }

    /**
     * update.
     *
     * @return array
     */
    public function insert($isExecute = true){
    	$sql = SQLCommand::insert($this->data);
    	
    	if($isExecute){
    		$sql = $this->execute($sql);
    	}
    	
    	$this->clear();

    	return $sql;
    }
}