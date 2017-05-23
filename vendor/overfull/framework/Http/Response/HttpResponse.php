<?php
/*----------------------------------------------------
* Filename: Response.php
* Author: Overfull.net
* Date: 2016/05/20
* Description:
* ----------------------------------------------------
*/
namespace Overfull\Http\Response;
use Overfull\Http\Response\ResponseFormat;

class HttpResponse extends \Overfull\Http\Foundation\BaseResponse
{
    protected $attributes = [
        'format' => ResponseFormat::HTML,
        'content' => ''
    ];

    /**
    * Set method
    * This method will handle when set data for this response object
    * @date 2016/05/21
    */
    public function __set($name, $value){
        $this->attributes[$name] = $value;
    }

    /**
    * Get method. Return exist value of attributes
    * @date 2016/05/21
    */
    public function __get($name){
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key){
    	return isset($this->attributes[$key]);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key){
        unset($this->attributes[$key]);
    }

    /**
    * Get method
    * @date 2016/05/21
    */
    public function send(){
            $this->header('Content-Type', $this->attributes['format']);
            echo $this->attributes['content'];
            return $this;
    }

    /**
     * Set header value
     * @param type $name
     * @param type $value
     * @return $this
     */
    public function header($name, $value)
    {
            header("$name: $value");
            return $this;
    }
    
    /**
     * setStatusCode
     * @param type $code
     * @return $this
     */
    public function setStatusCode($code)
    {
        if(is_numeric($code) && $code < 599){
            http_response_code($code);
        }
        else{
            http_response_code(500);
        }

        return $this;
    }
}