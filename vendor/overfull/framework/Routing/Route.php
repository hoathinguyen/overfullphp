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
    private $alias = [];

    private $validRouting = null;

    private $url = '';

    private $uri = '';

    private $attributes = [];
    
    /**
    * Regex keys
    * This array contains all of key config on routes to parse to regex
    */
    private $regexKeys = [
    	'/\<(|([a-zA-Z0-9]+)):all\>/' => '(.*)',
    	'/\//' => '\/',
    	'/\?/' => '\?',
    	'/\<:empty\>/' => '',
    	'/\<(|([a-zA-Z0-9]+)):integer\>/' => '(0|[1-9][0-9]*)',
    	'/\<(|([a-zA-Z0-9]+)):alphanumeric\>/' => '([a-zA-Z0-9]*)'
    ];

    /**
     * Run method
     *
     * @return void
     */
    public function run(){
        $configs = Bag::config()->get('routes');

        // Check if have no data in pages
        if(empty($configs)){
            throw new PageNotFoundException();
        }

        $uriArray = Bag::request()->uriArray();
        
        // Get root
        if(Bag::config()->get('route-compare') == 'relative'){
            $this->uri = strtolower($this->setWebroot($uriArray));
        } else {
            $this->uri = $this->setWebroot($uriArray);
        }

        $this->url = explode('?', $this->uri)[0];

        $this->setAlias($configs);

        if($this->validRouting == null){
            throw new PageNotFoundException();
        }

        $data = $this->validRouting->get();

        $this->attributes = array_merge($data, $this->attributes);

        Bag::config()->remove('routes');
    }

    /**
    * Get webroot method
    *
    * @param array $pages
    * @param string $prefix
    * @return void
    */
    private function setAlias($pages, $prefix = '', $aliasName = ''){
        foreach ($pages as $key => $value) {
            if(is_numeric($key)){
                $format = isset($value['format']) ? $value['format'] : $value[0];
                $regex = $this->convertRegex($prefix.$format);

                if(substr( $regex, -1 ) == '/'){
                        $regex = substr($regex, 0, -2);
                }

                $value['regex'] = $regex;

                $value['prefix'] = $prefix;

                $alias = new RouteAlias($value);

                if(!empty($value['as'])){
                    //$_aliasName = ($aliasName ? $aliasName.'.' : '').$value['as'];
                    //$this->alias[$_aliasName] = $alias;
                    $this->alias[$value['as']] = $alias;
                }

                if($this->validRouting == null
                    && ($alias->isValid($this->uri)
                    || $alias->isValid($this->url)) ){
                    $this->validRouting = $alias;
                }
            } else {
                $this->setAlias($value, (!empty($prefix) ? $prefix : '').$key.'/', (!empty($prefix) ? str_replace('/', '', $prefix).'.' : '').$key);
            }
        }
    }

    /**
    * Get webroot method
    *
    * @param string $name
    * @return RouteAlias
    */
    public function getAlias($name = false){
        if(!$name){
            return $this->alias;
        }

        return isset($this->alias[$name]) ? $this->alias[$name] : null;
    }

    /**
    * Get webroot method
    *
    * @param array $config
    * @param string $url
    * @return string $url
    */
    private function setWebroot($url){
        $routeBase = (int) Bag::config()->get('app.base');

        //Get root with private setting
        if ( !empty($routeBase) && is_numeric($routeBase)) {
                for($i = 0; $i < $routeBase; $i++){
                        array_shift($url);
                }
        }

        $this->attributes['root'] = Bag::config()->get('app.root');

        return implode('/', $url);
    }
    
    /**
     * Clear attributes method
     * @return $this
     */
    public function clearAttributes(){
        $this->attributes = [];
        return $this;
    }

    /**
     * Get current route
     */
    public function getCurrentRoute(){
    	return $this->validRouting;
    }
    
    /**
     * Get current route
     */
    public function getUrl($name, $params = [], $skipNoParameter = true){
        $alias = $this->getAlias($name);

        if(!$alias){
            throw new \Overfull\Exception\RouteAliasNotFoundException($name);
        }
        
        $prefix = Bag::config()->get('app.prefix');
        return Bag::request()->baseUrl().'/'.($prefix ? $prefix . '/' : ''). $alias->getUrl($params, $skipNoParameter);
    }

    /**
    * __get method
    *
    * @param string $name
    * @return value
    */
    public function __get($name){
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
    * __get method
    *
    * @param string $name
    * @return value
    */
    public function __set($name, $value){
        $this->attributes[$name] = $value;
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
    * convertRegex method
    *
    * @param string $str
    * @return value
    */
    private function convertRegex($str){

        foreach ($this->regexKeys as $key => $value) {
                $str = preg_replace($key, $value, $str);
        }

        return $str;
    }
}
