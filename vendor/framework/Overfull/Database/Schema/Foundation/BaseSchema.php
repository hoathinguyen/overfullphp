<?php
/*----------------------------------------------------
* Filename: BaseSchema.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Schema abstract class
* ----------------------------------------------------
*/
namespace Overfull\Database\Schema\Foundation;

abstract class BaseSchema implements \JsonSerializable{
	/**
	 * Name of connetion, which saved in dbstore
	 */
	protected $connection;

	/**
	 * Class name of result object
	 */
	protected $activeRecord = '';

	/**
	 * Query builder object
	 */
	protected $queryBuilder = null;
	
	/**
	 * Construct
	 *
	 * @param string $connectionName
	 * @param mixed $object
	 * @return void
	 */
	function __construct($connection = null, $record = null, $queryBuilder = null){
            $this->connection($connection);
            $this->activeRecord($record);
            $this->queryBuilder($queryBuilder);
	}

	/**
	 * Set/get connection
	 *
	 * @param $connection
	 */
	public function connection($connection = null){
            if(!$connection){
                return $this->connection;
            }
            $this->connection = $connection;
            return $this;
	}

	/**
	 * Get or set record
	 *
	 * @param Record object $record
	 */
	public function activeRecord($record = null){
            if(!$record){
                return $this->activeRecord;
            }
            $this->activeRecord = $record;
            return $this;
	}

	/**
	 * Get or set query builder
	 *
	 * @param queryBuilder
	 */
	public function queryBuilder($queryBuilder = null){
            if(!$queryBuilder){
                return $this->queryBuilder;
            }

            $this->queryBuilder = $queryBuilder;
            return $this;
	}

	/**
	 * Execute sql
	 *
	 * @return array
	 */
	public function query($sql){
            try {
                $this->connection->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
                $result = $this->connection->query($sql);

                if(!$this->activeRecord){
                    return $result->fetchAll();
                }

                return $result->fetchAll(\PDO::FETCH_CLASS, $this->activeRecord);
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
			// Set attribute for connection
			$this->connection->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			$dpo = $this->connection->prepare($sql);

			$dpo->execute($parameters);

			return $dpo;
		}catch (\PDOException $err) {
		    throw $err;
		}
	}

	/**
	 * Set select
	 *
	 * @param array $colums
	 * @return void
	 */
	public function columns($colums){
		if(is_array($colums)){
			$this->queryBuilder->columns = $colums;
		} else {
			$this->queryBuilder->columns = [$colums];
		}

		return $this;
	}

	/**
	 * Set table value
	 *
	 * @param string $table
	 * @return void
	 */
	public function table($table, $as = ''){
		if(is_object($table)){
			// $class = get_class($this->queryBuilder);
			// $q = new $class($this->connectionName, $this->activeRecord, get_class($this->query));
			// $table($q);
			// $this->data['table'] = '('.$q->all(false).')'.($as ? " {$as}" : '');
		}else{
			$this->queryBuilder->table = $table;
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
		$wheres = $this->queryBuilder->where;

		if(is_object($conditions)){
			$class = get_class($this);
			$q = new $class();
			$conditions($q);

			$wheres[] = [
				'operation' => '',
				'type' => 'group',
				'values' => $q->queryBuilder()->where
			];
		} else {
			$wheres[] = [
				'operation' => '',
				'type' => 'simple',
				'values' => $conditions
			];
		}

		$this->queryBuilder->where = $wheres;

		return $this;
	}

	/**
	 * Set andwhere syntax value. Sample you can send.
	 * ['columns', '', 'columns'], ''
	 * @param mixed $data
	 * @return void
	 */
	public function andWhere($conditions){
		$wheres = $this->queryBuilder->where;

		if(is_object($conditions)){
			$class = get_class($this);
			$q = new $class();
			$conditions($q);

			$wheres[] = [
				'operation' => 'AND',
				'type' => 'group',
				'values' => $q->queryBuilder()->where
			];
		} else {
			$wheres[] = [
				'operation' => 'AND',
				'type' => 'simple',
				'values' => $conditions
			];
		}

		$this->queryBuilder->where = $wheres;

		return $this;
	}

	/**
	 * Set andwhere syntax value. Sample you can send.
	 * ['columns', '', 'columns'], ''
	 * @param mixed $data
	 * @return void
	 */
	public function orWhere($conditions){
		$wheres = $this->queryBuilder->where;

		if(is_object($conditions)){
			$class = get_class($this);
			$q = new $class();
			$conditions($q);

			$wheres[] = [
				'operation' => 'OR',
				'type' => 'group',
				'values' => $q->queryBuilder()->where
			];
		} else {
			$wheres[] = [
				'operation' => 'OR',
				'type' => 'simple',
				'values' => $conditions
			];
		}

		$this->queryBuilder->where = $wheres;

		return $this;
	}

	/**
	 * join
	 * @param string $table
	 * @param array join
	 * @return this
	 */
	public function join($table, $conditions){
		$joins = $this->queryBuilder->joins;

		$joins[] = ['type' => 'JOIN', 'table' => $table, 'on' => $conditions];

		$this->queryBuilder->joins = $joins;

		return $this;
	}

	/**
	 * join
	 * @param string $table
	 * @param array join
	 * @return this
	 */
	public function outerJoin($table, $conditions){
		$joins = $this->queryBuilder->joins;

		$joins[] = ['type' => 'OUTER JOIN', 'table' => $table, 'on' => $conditions];

		$this->queryBuilder->joins = $joins;

		return $this;
	}

	/**
	 * Set offset
	 * @param int $offset
	 * @return this
	 */
	public function offset($offset){
		$this->queryBuilder->offset = $offset;
		return $this;
	}

	/**
	 * Set limit
	 * @param int $limit
	 * @return this
	 */
	public function limit($limit){
		$this->queryBuilder->limit = $limit;
		return $this;
	}

	/**
	 * value
	 * @param int $limit
	 * @return this
	 */
	public function values($nameOrValues, $values = ''){
		$_values = $this->queryBuilder->values;

		if(is_string($nameOrValues)){
			$_values[] = [$nameOrValues => $values];
		} else{
			$_values[] = $nameOrValues;
		}

		$this->queryBuilder->values = $_values;

		return $this;
	}

	/**
     * jsonSerialize method,
     * which is implement from jsonSerialize, to json_encode .
     *
     * @return array
     */
    public function jsonSerialize(){
        return $this->queryBuilder->attributes();
    }

    /**
     * __debugInfo method, return values when use debug.
     *
     * @return array
     */
    public function __debugInfo() {
        return $this->queryBuilder->attributes();
    }

    /**
     * Update method.
     * This method will be call method query to get sql
     * After then exc this sql string by dbconnection
     * @return array
     */
    public function update($isExecute = true){
    	// Get sql string from query
    	$sql = $this->queryBuilder->updateSyntax();

    	// Check if is excute or get sql string
    	if($isExecute){
    		$sql = $this->execute($sql);
    	}
    	
    	// Clear all after excute
    	$this->queryBuilder->clear();

    	return $sql;
    }

    /**
     * Delete method.
     * This method will be call method query to get sql
     * After then exc this sql string by dbconnection
     * @return array
     */
    public function delete($isExecute = true){
    	// Get sql string from query
    	$sql = $this->queryBuilder->deleteSyntax();

    	// Check if is excute or get sql string
    	if($isExecute){
    		$sql = $this->execute($sql);
    	}
    	
    	// Clear all after excute
    	$this->queryBuilder->clear();

    	return $sql;
    }

    /**
     * Insert method.
     * This method will be call method query to get sql
     * After then exc this sql string by dbconnection
     * @return array
     */
    public function insert($isExecute = true){
    	// Get sql string from query
    	$sql = $this->queryBuilder->insertSyntax();
    	
    	// Check if is excute or get sql string
    	if($isExecute){
    		$sql = $this->execute($sql);
    	}
    	
    	// Clear all after excute
    	$this->queryBuilder->clear();

    	return $sql;
    }
    /**
	 * Select all
	 *
	 * @return void
	 */
	public function all($isExecute = true){
		try{
			$sql = $this->queryBuilder->selectSyntax();

			if($isExecute){
				$sql = $this->query($sql);
				if(!$sql || count($sql) == 0){
					$sql = [];
				}
			}

			$this->queryBuilder->clear();

			return $sql;
		} catch (\Exception $e){
			throw $e;
		}
	}

	/**
	 * Select one
	 * This method call select query and set limit as 1
	 * Before select, check if get query or execute
	 * @return void
	 */
	public function one($isExecute = true){
		try{
			// Set limit as 1
			$this->limit(1);

			$sql = $this->queryBuilder->selectSyntax();

			if($isExecute){
				$sql = $this->query($sql);
				if(!$sql || count($sql) == 0){
					$sql = null;
				} else {
					$sql = $sql[0];
				}
			}

			$this->queryBuilder->clear();

			return $sql;
		} catch (\Exception $e){
			throw $e;
		}
	}
} 