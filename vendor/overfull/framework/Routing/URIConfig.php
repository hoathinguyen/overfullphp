<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Overfull\Routing;

class UriConfig
{
    // List of uri
    private $uris = [];
    
    // valid uri
    private $validUri = null;
    
    // Group name
    private $group = [];
    
    /**
    * Get webroot method
    *
    * @param string $name
    * @return RouteAlias
    */
    public function getUri($name = false)
    {
        if(!$name){
            return $this->uris;
        }

        return isset($this->uris[$name]) ? $this->uris[$name] : null;
    }
    
    /**
     * Add uri to list
     * @param string $method
     * @param string $path
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function addUri($method, $path, $alias, $value)
    {
        $uri = new \Overfull\Routing\Uri($method, $path, $alias, $value, $this->group);
        
        $this->uris[$alias] = $uri;
        
        return $this;
    }
    
    /**
     * addGET
     * @param string $path
     * @param string $name
     * @param mixed $value
     * @return type
     */
    public function get($path, $alias, $value)
    {
        return $this->addUri('GET', $path, $alias, $value);
    }
    
    /**
     * addPOST
     * @param string $path
     * @param string $name
     * @param mixed $value
     * @return type
     */
    public function post($path, $alias, $value)
    {
        return $this->addUri('POST', $path, $alias, $value);
    }
    
    /**
     * addANY
     * @param string $path
     * @param string $name
     * @param mixed $value
     * @return type
     */
    public function any($path, $alias, $value)
    {
        return $this->addUri('ANY', $path, $alias, $value);
    }
    
    /**
     * 
     * @param string $name
     * @param \Closure $value
     * @return $this
     */
    public function group($name, $value)
    {
        $this->group[] = $name;
        $value($this);
        array_pop($this->group);
        return $this;
    }
    
    /**
     * Add uri to list
     * @return $this
     */
    public function getValid($base = 0)
    {
        if($this->validUri)
        {
            return $this->validUri;
        }
        
        // Get current domain
        $_uriPath = \Bag::request()->getUriArray(false);
        
        for($index = 0; $index < $base; $index++)
        {
            array_shift($_uriPath);
        }
        
        $uriPath = implode('/', $_uriPath);
        
        // Check use relative or absolute
        if(\Bag::config()->get('core.route-compare') == 'relative')
        {
            $uriPath = strtolower($uriPath);
        }
        
        // Loop with list of domain that defined
        foreach ($this->uris as $value) {
            if($value->isValid(\Bag::request()->getMethod(), $uriPath))
            {
                // Get and run valid data
                $this->validUri = $value;
                return $this->validUri->run();
            }
        }
        
        return null;
    }
}