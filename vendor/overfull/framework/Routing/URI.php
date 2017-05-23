<?php
/*----------------------------------------------------
* Filename: RouteAlias.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The detail of route object
* ----------------------------------------------------
*/
namespace Overfull\Routing;

use Bag;

class Uri extends \Overfull\Foundation\Base\BaseObject
{
    private $attributes = [];
    
    private $temp = null;
    
    // Regex keys
    // This array contains all of key config on routes to parse to regex
    private $regexKeys = [
    	'/\<(|([a-zA-Z0-9]+)):all\>/' => '(.*)',
    	'/\//' => '\/',
    	'/\?/' => '\?',
    	'/\<:empty\>/' => '',
    	'/\<(|([a-zA-Z0-9]+)):integer\>/' => '(0|[1-9][0-9]*)',
    	'/\<(|([a-zA-Z0-9]+)):alphanumeric\>/' => '([a-zA-Z0-9]*)'
    ];
    
    /**
     * __construct
     * @param string $format
     * @param string $name
     * @param mixed $value
     */
    public function __construct($method, $format, $alias, $value, $group = null)
    {
        $this->temp = $value;
        $this->setGroup($group);
        $this->setMethod($method);
        $this->setFormat($format);
        $this->setAlias($alias);
    }
    
    /**
     * set name value
     * @param type $name
     * @param type $value
     */
    public function set($name, $value = null)
    {
        if(is_array($name))
        {
            $this->attributes = $name;
        }
        else
        {
            $this->attributes[$name] = $value;
        }

        return $this;
    }
    
    /**
     * Get
     * @param type $name
     * @return type
     */
    public function get($name = false)
    {
        if(!$name)
        {
            return $this->attributes;
        }

        return $this->attributes[$name];
    }
    
    /**
     * add
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function add($name, $value)
    {
        $this->attributes[$name][] = $value;

        return $this;
    }
    
    /**
     * Set method
     * @param type $value
     * @return type
     */
    public function setMethod($value)
    {
        return $this->set('method', $value);
    }
    
    /**
     * Set method
     * @param type $value
     * @return type
     */
    public function setFormat($value)
    {
        return $this->set('format', $value);
    }
    
    /**
     * Set method
     * @param type $value
     * @return type
     */
    public function setAlias($value)
    {
        return $this->set('alias', $value);
    }
    
    /**
     * setMatches
     * @return array matches
     */
    public function setMatches($value)
    {
        return $this->set('matches', $value);
    }
    
    /**
     * setData
     * @return data
     */
    public function setData($value)
    {
        return $this->set('data', $value);
    }
    
    /**
     * setData
     * @return data
     */
    public function setGroup($value)
    {
        return $this->set('group', $value);
    }
    
    /**
     * Set method
     * @param type $value
     * @return type
     */
    public function getMethod()
    {
        return $this->get('method');
    }
    
    /**
     * Set method
     * @param type $value
     * @return type
     */
    public function getFormat($parse = false)
    {
        $format = $this->get('format');
        $gr = implode('/', $this->getGroup());
        
        $format = ($gr ? $gr.'/' : null ) . $format;
        
        $format = str_replace('//', '/', $format);

        if($parse)
        {
            foreach ($this->regexKeys as $key => $value) {
                $format = preg_replace($key, $value, $format);
            }
        }
        
        return rtrim($format, '\/');
    }
    
    /**
     * Set method
     * @param type $value
     * @return type
     */
    public function getAlias()
    {
        return $this->get('alias');
    }
    
    /**
     * Get group
     * @param type $value
     * @return type
     */
    public function getGroup()
    {
        return $this->get('group');
    }
    
    /**
     * getMatches
     * @return array matches
     */
    public function getMatches()
    {
        return $this->get('matches');
    }
    
    /**
     * getData
     * @return array matches
     */
    public function getData()
    {
        return $this->get('data');
    }

        /**
     * isValid
     * @param string $path
     * @return boolean
     */
    public function isValid($method, $path)
    {
        
        // Check if is request
        if ($this->getMethod() != $method && $this->getMethod() != 'ANY') {
            return false;
        }

        // Check if correct domain
        $matches = null;
        if(preg_match("/^".$this->getFormat(true)."$/", $path, $matches)){
            $this->setMatches($matches);
            return true;
        }

        return false;
    }
    
    /**
     * setUrlParameters
     * @return $this
     */
    public function getUrl($data = [], $skipNoParameter = true)
    {
        $url = $this->getFormat();
        
        if(is_array($data) && $url){
            foreach ($data as $key => $value) {
                $old = $url;
                if(is_numeric($key)){
                    $url = preg_replace('/\<:(.*?)\>/', $value, $url, 1);
                } else {
                    $url = preg_replace('/\<'.$key.':(.*?)\>/', $value, $url);
                    
                    if($old == $url){
                        $query = parse_url($url, PHP_URL_QUERY);

                        // Returns a string if the URL has parameters or NULL if not
                        if ($query) {
                            $url .= '&'.$key.'='.urlencode($value);
                        } else {
                            $url .= '?'.$key.'='.urlencode($value);
                        }
                    }
                }
            }
        }

        if($skipNoParameter){
            // Replace all
            $url = preg_replace('/\<:(.*?)\>/', '', $url);
            $url = preg_replace('/\<(.*?):(.*?)\>/', '', $url);
            $url = preg_replace('/\/\//', '/', $url);
        }

        return $url;
    }
    
    /**
     * Run method
     * @return $this
     */
    public function run()
    {
        $data = $this->temp;
        
        if ( is_object($data) ) {
            // Call merge by object
            $result = $this->mergeByObject($data, $this->getFormat(), $this->getMatches());
        }else if( is_array($data) ){
            // Call merge by array
            $result = $this->mergeByArray($data, $this->getMatches());
        }else{
            // Call merge by array
            $result = $this->mergeByString($data, $this->getMatches());
        }
        
        //Get data in url and set as variable in route
        preg_match_all('/\<(.*?):(.*?)\>/', $this->getFormat(), $matches);

        $temp = $this->getMatches();
        array_shift($temp);
        
        foreach($matches[1] as $k => $t){
            if($t === ""){
                unset($matches[1][$k]);
            }
        }
        
        $temp = array_combine($matches[1], $temp);

        $result = array_merge($result, $temp);
        
        $this->setData($result);
        
        return $this;
    }
    
    /**
     * Merge by object method
     *
     * @param string $str
     * @param string $urlRegex
     * @param array $matches
     * @return array $attributes
     */
    private function mergeByObject($object, $urlRegex, $matches)
    {
        $result = $object($urlRegex, $matches);

        if( is_array($result) ){
            // Call merge by array
            return $this->mergeByArray($result, $matches);
        }else{
            // Call merge by array
            return $this->mergeByString($result, $matches);
        }
    }

    /**
     * Merge by string method
     *
     * @param string $str
     * @param array $matches
     * @return array $attributes
     */
    private function mergeByString($str, $matches)
    {
        $couples = explode(';', $str);
        $attributes = [];

        foreach ($couples as $key => $value) {
            $values = explode('=', $value);

            $attributes[$values[0]] = isset($values[1]) ? $values[1] : '';
        }
        
        return $attributes;
    }

    /**
     * merge by array method
     *
     * @param array $array
     * @param array $matches
     * @return array $attributes
     */
    private function mergeByArray($array, $matches)
    {
        $attributes = [];

        foreach ($array as $key => $value) {
            if(is_string($key)){
                $attributes[$key] = $value;
            }
        }

        return $attributes;
    }
}
