<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Overfull\Modules\Pagination;

class Paginate extends \Overfull\Modules\Foundation\BaseModule{
    private $data = [];
    private $totalRecord;
    private $schema;
    private $number;
    private $page;

    /**
     * construct
     * @param type $schema
     * @param type $number
     * @param type $page
     */
    function __construct(&$schema = null, $number = 10, $page = 1) {
        $this->schema($schema);
        $this->number($number);
        $this->page($page);

        if($schema){
           $this->calculate();
        }
    }

    /**
     * calculate page
     * @return $this
     */
    public function calculate(){
        $columns = $this->schema->queryBuilder()->columns;
        $this->totalRecord = $this->schema->count();

        if(!$this->number){
           return $this;
        }
        
        if($this->page < 1){
            $this->page = 1;
        }

        $offset = ($this->page - 1)*$this->number;

        $this->schema->limit($this->number);

        if($offset){
            $this->schema->offset($offset);
        }

        $this->data = $this->schema->columns($columns)->all();
        //dd($this->data);
        return $this;
    }

    /**
     * Schema
     * return void
     */
    public function schema($schema){
        $this->schema = $schema;
        return $this;
    }

    public function number($number){
        $this->number = $number;
        return $this;
    }

    public function page($page){
        $this->page = $page;
        return $this;
    }

    /**
     * next page
     * @return int
     */
    public function next(){
        $current = $this->current();
        $total = $this->totalPage();

        if($current < $total){
            return $current+1;
        }

        return 0;
    }

    /**
     * previous page
     * @return int
     */
    public function previous(){
        $current = $this->current();

        if($current > 1){
            return $current - 1;
        }

        return 0;
    }

    /**
     * first page
     * @return int
     */
    public function first(){
        if($this->totalRecord()){
            return 1;
        }

        return 0;
    }

    /**
     * last page
     * @return int
     */
    public function last(){
        return $this->totalPage();
    }

    /**
     * current page
     * @return int
     */
    public function current(){
        return $this->page;
    }

    /**
     * total page
     * @return int
     */
    public function totalPage(){
        $total = $this->totalRecord();

        $totalPage = (int)($total/$this->number);
        $after = (int)($total%$this->number);

        if($after > 0){
            $totalPage++;
        }

        return $totalPage;
    }

    /**
     * totalRecord
     * @return type
     */
    public function totalRecord(){
        return $this->totalRecord;
    }

    /**
     * Count data
     * @return number
     */
    public function count(){
        return count($this->data);
    }

    /**
     * Check if is last page method
     * @return number
     */
    public function isLastPage(){
        return $this->current() == $this->totalPage();
    }

    /**
     * Check if is last page method
     * @return number
     */
    public function isFirstPage(){
        return $this->isPage(1);
    }

    public function isPage($num){
        return $this->current() == $num;
    }

    /**
     * data
     * @return type
     */
    public function getResult(){
        return $this->data;
    }
}
