<?php
/*----------------------------------------------------
* Filename: Response.php
* Author: Overfull.net
* Date: 2016/05/20
* Description:
* ----------------------------------------------------
*/
namespace Overfull\Http\Response;

class HttpResponse extends \Overfull\Http\Foundation\BaseResponse
{
    protected $attributes = [
        'format' => '',
        'contentType' => '',
        'content' => ''
    ];

    /**
    * Set method
    * This method will handle when set data for this response object
    * @date 2016/05/21
    */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
    * Get method. Return exist value of attributes
    * @date 2016/05/21
    */
    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
    	return isset($this->attributes[$key]);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }

    /**
     * Send data to client method
     * @return $this
     */
    public function send()
    {
        // Set header
        $this->header('Content-Type', $this->contentType);

        switch ($this->format) {
            // Text format
            case Constant::FORMAT_TEXT:
                echo $this->content;
                break;
            case Constant::FORMAT_FILE:
                $this->header("Content-Length", strlen($this->content));
                $this->header("Content-Disposition", "attachment; filename=$this->fileName");
                echo $this->content;
                break;
            default:
                break;
        }

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