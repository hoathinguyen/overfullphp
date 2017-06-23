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
    // Headers
    protected $headers = [];
    
    // Attributes
    protected $attributes = [];
    
    // Format
    protected $format = '';
    
    // Content
    protected $content = '';
        
    /**
     * Set format
     * @param string $value
     * @return $this
     */
    public function setFormat($value)
    {
        $this->format = $value;
        return $this;
    }
    
    /**
     * Get format
     * @return type
     */
    public function getFormat()
    {
        return $this->format;
    }
    
    /**
     * isFormat
     * @param type $format
     * @return type
     */
    public function isFormat($format)
    {
        return $this->format == $format;
    }
    
    /**
     * setContent
     * @param type $value
     * @return $this
     */
    public function setContent($value)
    {
        $this->content = $value;
        
        return $this;
    }
    
    /**
     * getContent
     * @return type
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * setHeader
     * @param type $name
     * @param type $value
     * @return $this
     */
    public function setHeader($name, $value)
    {
        if(is_array($name))
        {
            foreach ($name as $key => $val){
                $this->headers[$key] = $val;
            }
        }
        else {
            $this->headers[$name] = $value;
        }
        
        return $this;
    }
    
    /**
     * getHeaders
     * @return type
     */
    public function getHeaders()
    {
        return $this->headers;
    }
    
    /**
     * getHeader
     * @param type $name
     * @return type
     */
    public function getHeader($name)
    {
        return isset($this->headers[$name]) ? $this->headers[$name] : null;
    }
    
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
        if(!$this->getHeader('Content-Type'))
        {
            $this->setHeader('Content-Type', Constant::CONTENT_TYPE_HTML);
        }

        if($this->isFormat(''))
        {
            $this->setFormat(Constant::FORMAT_TEXT);
        }

        // Set header
        foreach ($this->getHeaders() as $key => $value)
        {
            $this->applyHeader($key, $value);
        }

        switch ($this->getFormat()) {
            // Text format
            case Constant::FORMAT_TEXT:
                echo $this->getContent();
                break;
            case Constant::FORMAT_FILE:
                $this->applyHeader("Content-Length", strlen($this->getContent()));
                $this->applyHeader("Content-Disposition", "attachment; filename=$this->fileName");
                echo $this->getContent();
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
    public function applyHeader($name, $value)
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