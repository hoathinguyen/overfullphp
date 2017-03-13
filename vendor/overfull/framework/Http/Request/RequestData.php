<?php
/**
 * Request data object class
 * This class contain data of request
 */
 namespace Overfull\Http\Request;

 class RequestData{
     private $data;

     /**
      * Construct method
      * @param array $data
      */
     function __construct($data){
         $this->data = $data;
     }

     /**
      * __get method
      * @param string $name
      */
     function __get($name){
         return isset($this->data[$name]) ? $this->data[$name] : null;
     }

     /**
      * __get method
      * @param string $name
      */
     function __set($name, $value){
         $this->data[$name] = $value;
     }

     /**
      * __isset method
      * @param string $name
      */
     function __isset($name){
         return $this->isExists($name);
     }

     /**
      * __isset method
      * @param string $name
      */
     function isExists($name){
         return array_key_exists($name, $this->data);
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
 }
 ?>
