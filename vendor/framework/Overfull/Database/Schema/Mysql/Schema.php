<?php
/*----------------------------------------------------
* Filename: Schema.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Schema abstract class
* ----------------------------------------------------
*/
namespace Overfull\Database\Schema\Mysql;

class Schema extends \Overfull\Database\Schema\Foundation\BaseSchema{
    protected  $type = 'mysql';
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
            $this->queryBuilder(new QueryBuilder());
    }
    
    /**
     * Get type of schema
     * @return type
     */
    public function getType(){
        return $this->type;
    }
} 