<?php
/*----------------------------------------------------
* Filename: BaseSchema.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Schema abstract class
* ----------------------------------------------------
*/
namespace Overfull\Database\Schema\Foundation;

abstract class BaseSchema implements \JsonSerializable
{
    //Name of connetion, which saved in dbstore
    protected $connection;

    //Class name of result object
    protected $activeRecord = '';

    //Query builder object
    protected $queryBuilder = null;

    /**
     * __construct
     * @param Connection $connection
     * @param mixed $record
     * @param \Overfull\Database\Schema\Mysql\QueryBuilder $queryBuilder
     */
    function __construct($connection = null, $record = null, $queryBuilder = null)
    {
        $this->connection($connection);
        $this->activeRecord($record);
        $this->queryBuilder($queryBuilder);
    }

    /**
     * Get or set connection
     * @param type $connection
     * @return $this
     */
    public function connection($connection = null)
    {
        if(!$connection){
            return $this->connection;
        }
        
        $this->connection = $connection;
        
        return $this;
    }

    /**
     * Get or set record
     * @param type $record
     * @return $this
     */
    public function activeRecord($record = null)
    {
        if(!$record){
            return $this->activeRecord;
        }
        
        $this->activeRecord = $record;
        return $this;
    }

    /**
     * Get or set query builder
     * @param \Overfull\Database\Schema\Mysql\QueryBuilder $queryBuilder
     * @return $this
     */
    public function queryBuilder($queryBuilder = null)
    {
        if(!$queryBuilder){
            return $this->queryBuilder;
        }

        $this->queryBuilder = $queryBuilder;
        return $this;
    }

    /**
     * Query method
     * @param string $sql
     * @return mixed
     * @throws \PDOException
     */
    public function query($sql)
    {
        try {
            $this->connection->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            $result = $this->connection->query($sql);

            if(!$this->activeRecord){
                return $result->fetchAll();
            }

            $objects = $result->fetchAll(\PDO::FETCH_CLASS, $this->activeRecord);

            if($objects != null && count($objects) > 0){
                foreach ($objects as $value){
                    $value->makeOldAttributes();
                }
            }

            return $objects;
        }catch (\PDOException $err) {
            throw $err;
        }
    }

    /**
     * Execute method
     * @param string $sql
     * @param array $parameters
     * @return mixed
     * @throws \PDOException
     */
    public function execute($sql, $parameters = [])
    {
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
     * Set columns method
     * @param array $colums
     * @return $this
     */
    public function columns($colums)
    {
        if(is_array($colums)){
            $this->queryBuilder->columns = $colums;
        } else {
            $this->queryBuilder->columns = [$colums];
        }

        return $this;
    }

    /**
     * Set table name
     * @param string $table
     * @param string $as
     * @return $this
     */
    public function table($table, $as = '')
    {
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
    public function where($conditions)
    {
        $wheres = $this->queryBuilder->where;
        
        $label = count($wheres) > 0 ? 'AND' : '';
        
        if(is_object($conditions)){
            $class = get_class($this);
            $q = new $class();
            $conditions($q);

            $wheres[] = [
                'operation' => $label,
                'type' => 'group',
                'values' => $q->queryBuilder()->where
            ];
        } else {
            $wheres[] = [
                'operation' => $label,
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
    public function andWhere($conditions)
    {
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
    public function orWhere($conditions)
    {
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
     * orderBy
     * @param type $type
     * @param type $columns
     */
    public function orderBy($columns, $type)
    {
        $orders = $this->queryBuilder->orders;

        if(is_string($columns)){
            $columns = explode(',', $columns);
        }

        $orders[] = ['type' => $type, 'columns' => $columns];

        $this->queryBuilder->orders = $orders;

        return $this;
    }

    /**
     * join
     * @param string $table
     * @param array join
     * @return this
     */
    public function join($table, $conditions)
    {
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
    public function outerJoin($table, $conditions)
    {
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
    public function offset($offset)
    {
        $this->queryBuilder->offset = $offset;
        return $this;
    }

    /**
     * Set limit
     * @param int $limit
     * @return this
     */
    public function limit($limit)
    {
        $this->queryBuilder->limit = $limit;
        return $this;
    }

    /**
     * value
     * @param int $limit
     * @return this
     */
    public function values($nameOrValues, $values = '')
    {
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
    public function jsonSerialize()
    {
        return $this->queryBuilder->getAttributes();
    }

    /**
     * __debugInfo method, return values when use debug.
     *
     * @return array
     */
    public function __debugInfo() 
    {
        return $this->queryBuilder->getAttributes();
    }

    /**
     * Update method.
     * This method will be call method query to get sql
     * After then exc this sql string by dbconnection
     * @return array
     */
    public function update($isExecute = true, $clear = false)
    {
    	// Get sql string from query
    	$sql = $this->queryBuilder->updateSyntax();

    	// Check if is excute or get sql string
    	if($isExecute){
            $sql = $this->execute($sql);
    	}

    	// Clear all after excute
    	if($clear){
            $this->queryBuilder->clear();
        }

    	return $sql;
    }

    /**
     * Delete method.
     * This method will be call method query to get sql
     * After then exc this sql string by dbconnection
     * @return array
     */
    public function delete($isExecute = true, $clear = false)
    {
    	// Get sql string from query
    	$sql = $this->queryBuilder->deleteSyntax();

    	// Check if is excute or get sql string
    	if($isExecute){
            $sql = $this->execute($sql);
    	}

    	// Clear all after excute
    	if($clear){
            $this->queryBuilder->clear();
        }

    	return $sql;
    }

    /**
     * Insert method.
     * This method will be call method query to get sql
     * After then exc this sql string by dbconnection
     * @return array
     */
    public function insert($isExecute = true, $clear = false)
    {
    	// Get sql string from query
    	$sql = $this->queryBuilder->insertSyntax();

    	// Check if is excute or get sql string
    	if($isExecute){
            $sql = $this->execute($sql);
    	}

    	// Clear all after excute
    	if($clear){
            $this->queryBuilder->clear();
        }

    	return $sql;
    }
    
    /**
     * Select all method
     * @param type $isExecute
     * @param type $clear
     * @return array
     * @throws \Exception
     */
    public function all($isExecute = true, $clear = false)
    {
        try{
            $sql = $this->queryBuilder->selectSyntax();

            if($isExecute){
                $sql = $this->query($sql);
                if(!$sql || count($sql) == 0){
                    $sql = [];
                }
            }

            if($clear){
                $this->queryBuilder->clear();
            }

            return $sql;
        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Select first
     * This method call select query and set limit as 1
     * Before select, check if get query or execute
     * @return void
     */
    public function first($isExecute = true, $clear = false)
    {
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

            if($clear){
                $this->queryBuilder->clear();
            }

            return $sql;
        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * count
     * @return type
     * @throws \Exception
     */
    abstract function count($isExecute = true);

    /**
     * lastInsertPrimaryKey($primary)
     */
    abstract function lastInsertPrimaryKey($primary);
}
