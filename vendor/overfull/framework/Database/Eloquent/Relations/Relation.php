<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Overfull\Database\Eloquent\Relations;

abstract class Relation extends \Overfull\Foundation\Base\BaseObject{
    protected $schema;
    protected $connection;
    protected $activeRecord;
    protected $relative;
    protected $data;
    protected $parent;
            
    function __construct($connection, $schema, $activeRecord, $parent, $relative) {
        $this->connection = $connection;
        $this->activeRecord = $activeRecord;
        $this->relative = $relative;
        $this->schema = $schema;
        $this->parent = $parent;
        $this->schema->queryBuilder()->clear();
    }
    
    public function data($data = null){
        if($data){
            $this->data = $data;
        }
        
        return $this->data;
    }
    
    public function parse(){
        $record = $this->activeRecord;
        
        $where = $this->relative;
        
        if(is_array($this->relative)){
            if($this->parent->isAttribute($this->relative[2])){
                $where[2] = $this->parent->{$this->relative[2]};
            }
        }
        
        $this->schema
            ->activeRecord($record)
            ->table((new $record)->getTableName())
            ->where($where);

        return $this;
    }
    
    public function run(){}
    
    /**
     * Get schema of this class
     *
     * @return object
     */
    public final function schema(){
        // Check if type is exists.
        return $this->schema;
    }
}