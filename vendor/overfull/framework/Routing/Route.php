<?php
/*----------------------------------------------------
* Filename: Route.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The route object
* ----------------------------------------------------
*/
namespace Overfull\Routing;
use Overfull\Foundation\Base\BaseObject;
use Bag;
use Overfull\Exception\PageNotFoundException;

class Route extends BaseObject{
    // Attributes
    private $attributes = [];
    
    // Domain
    private $domainConfig = null;
    
    // URI
    private $uriConfig = null;
    
    public function __construct()
    {
        $this->domainConfig = new DomainConfig();
        $this->uriConfig = new URIConfig();
    }


    /**
     * Run method
     *
     * @return void
     */
    public function run()
    {                
        $base = $this->getDomainConfig()->getValid()->getBase();
        if(!$this->getURIConfig()->getValid($base))
        {
            throw new PageNotFoundException();
        }
        
        $this->attributes = array_merge($this->getURIConfig()->getValid()->getData(), $this->attributes);
    }
    
    /**
     * getDomainConfig
     * @return \Overfull\Routing
     */
    public function getDomainConfig() : DomainConfig
    {
        return $this->domainConfig;
    }
    
    /**
     * getDomainConfig
     * @return \Overfull\Routing
     */
    public function getURIConfig() : URIConfig
    {
        return $this->uriConfig;
    }
    
    /**
     * Get current route
     */
    public function getURL($name, $params = [], $skipNoParameter = true) : String
    {
        $alias = $this->getURIConfig()->getURI($name);

        if(!$alias){
            throw new \Overfull\Exception\RouteNotFoundException($name);
        }
        
        $prefix = Bag::config()->get('app.prefix');
        return Bag::request()->getBaseURL().'/'.($prefix ? $prefix . '/' : ''). $alias->getURL($params, $skipNoParameter);
    }

    /**
    * __get method
    *
    * @param string $name
    * @return value
    */
    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
    * __get method
    *
    * @param string $name
    * @return value
    */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
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
     * Clear attributes method
     * @return $this
     */
    public function clearAttributes()
    {
        $this->attributes = [];
        return $this;
    }
}
