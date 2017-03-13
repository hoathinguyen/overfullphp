<?php
/*___________________________________________________________________________
* AppNotFoundException object class
* This object handle some error when app not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception\Handler;
use Overfull\Foundation\Base\BaseObject;
use Bag;

class ErrorData extends BaseObject{
    private $data = [];
    private $isHasLastError = false;
    
    public function set($data){
        $this->data = $data;
        $this->isHasLastError = true;
    }
    
    public function clear($data){
        $this->data = [];
        $this->isHasLastError = false;
    }
    
    public function isHasLastError(){
        return $this->isHasLastError;
    }
    
    /**
    * Auto call when set new connection
    *
    * @param string $name
    * @param string $value
    * @return void
    */
    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    /**
    * Auto call when get connection
    *
    * @param string $name
    * @return void
    */
    public function __get($name){
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }
}