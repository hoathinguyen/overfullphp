<?php
/**
 * Request data object class
 * This class contain data of request
 */
namespace Overfull\Http\Request;

class RequestFile
{
    // Data
    private $data;

    /**
     * Construct method
     * @param array $data
     */
    function __construct($data){
        $this->data = $data;
    }

    /**
     * Get file name method
     * return string
     */
    public function fileName(){
        return $this->data['name'];
    }

    /**
     * Get file name method
     * return string
     */
    public function realPath(){
        return $this->data['tmp_name'];
    }

    /**
     * __get method
     * @param string $name
     */
    function __get($name){
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * __isset method
     * @param string $name
     */
    function __isset($name){
        return isset($this->data[$name]);
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
