<?php
/*----------------------------------------------------
* Filename: Schema.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Schema abstract class
* ----------------------------------------------------
*/
namespace Overfull\Database\Schema\Mysql;

class Schema extends \Overfull\Database\Schema\Foundation\BaseSchema
{
    // Type of connect
    protected  $type = 'mysql';
    
    /**
     * __construct
     * @param type $connection
     * @param type $record
     * @param type $queryBuilder
     */
    function __construct($connection = null, $record = null, $queryBuilder = null)
    {
        $this->connection($connection);
        $this->activeRecord($record);
        $this->queryBuilder(new QueryBuilder());
    }
    
    /**
     * Get type of schema
     * @return type
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set lastInsertPrimaryKey
     * @param mixed $primary
     * @return string
     * @throws \Exception
     */
    public function lastInsertPrimaryKey($primary = 'id')
    {
        try{
            return $this->connection->lastInsertId($primary);
        } catch (\Exception $e){
           throw $e;
        }
    }
    
    /**
     * Count query
     * @param boolean $isExecute
     * @param boolean $clear
     * @return int
     * @throws \Exception
     */
    public function count($isExecute = true, $clear = false)
    {
       try{
           // Set limit as 1
           $this->limit(1);

           $this->columns('COUNT(*) AS count');

           $sql = $this->queryBuilder->selectSyntax();

           if($isExecute){
               $sql = $this->query($sql);
               if(!$sql || count($sql) == 0){
                       return 0;
               } else {
                       $sql = $sql[0];
               }
               
               if($clear){
                   $this->queryBuilder->clear();
               }

                return $sql->count;
           }
            
           return $sql;
       } catch (\Exception $e){
           throw $e;
       }
   }
} 