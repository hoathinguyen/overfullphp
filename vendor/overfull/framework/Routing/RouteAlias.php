<?php
/*----------------------------------------------------
* Filename: RouteAlias.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The detail of route object
* ----------------------------------------------------
*/
namespace Overfull\Routing;
use Overfull\Foundation\Base\BaseObject;
use Bag;

class RouteAlias extends BaseObject{
    private $data = [];
    private $matches = null;
    private $attributes = [];
    
    /**
     * __construct
     * @param array $data
     * @return void
     */
    public function __construct($data){
        $this->data = $data;
    }

    /**
     * Check is valid method
     * @param
     */
    public function isValid($uri){
        if ( !Bag::request()->is($this->getMethod()))
            return false;

        if(preg_match('/^'.$this->getRegex().'$/', $uri, $this->matches)){
            return true;
        }

        return false;
    }
    
    /**
     * Get regex
     */
    public function getRegex(){
        return $this->data['regex'];
    }
    
    /**
     * Get method
     */
    public function getMethod(){
        return isset($this->data['method']) ? $this->data['method'] : $this->data[1];
    }

    /**
     * getMatches
     * @return array matches
     */
    public function getMatches(){
        return $this->matches;
    }

    /**
     * setUrlParameters
     * @return $this
     */
    public function getFormat(){
        return isset($this->data['format']) ? $this->data['format'] : $this->data[0];
    }
    
    /**
     * Get prefix
     * @return string
     */
    public function getPrefix(){
        return isset($this->data['prefix']) ? $this->data['prefix'] : null;
    }

    /**
     * setParameterToUrl
     * @param type $url
     * @param type $parameters
     */
    private function setParameterForUrl($url, $parameters = [], $skipNoParameter = true){
        if(is_array($parameters) && $url){
            foreach ($parameters as $key => $value) {
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
     * setUrlParameters
     * @return $this
     */
    public function getUrl($data = [], $skipNoParameter = true){
        return $this->setParameterForUrl($this->getPrefix().$this->getFormat(), $data, $skipNoParameter);
    }

    /**
    * Run method
    *
    * @return void
    */
    public function get(){
        if(!empty($this->attributes)){
            return $this->attributes;
        }
        
        $parameters = isset($this->data['data']) ? $this->data['data'] : $this->data[2];

        if ( is_object($parameters) ) {
            // Call merge by object
            $result = $this->mergeByObject($parameters, isset($this->data['format']) ? $this->data['format'] : $this->data[0], $this->matches);
        }else if( is_array($parameters) ){
            // Call merge by array
            $result = $this->mergeByArray($parameters, $this->matches);
        }else{
            // Call merge by array
            $result = $this->mergeByString($parameters, $this->matches);
        }

        //$result
        preg_match_all('/\<(.*?):(.*?)\>/', isset($this->data['format']) ? $this->data['format'] : $this->data[0], $matches);

        $temp = $this->matches;
        array_shift($temp);
        
        foreach($matches[1] as $k => $t){
            if($t === ""){
                unset($matches[1][$k]);
            }
        }
        
        $temp = array_combine($matches[1], $temp);
        
        $this->attributes = $this->setVariables($result, $temp);

        return $this->attributes;
    }

    /**
     * Merge by object method
     *
     * @param string $str
     * @param string $urlRegex
     * @param array $matches
     * @return array $attributes
     */
    private function mergeByObject($object, $urlRegex, $matches){
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
    private function mergeByString($str, $matches){
        $couples = explode(';', $str);
        $attributes = [];

        foreach ($couples as $key => $value) {
                $values = explode('=', $value);

                $attributes[$values[0]] = isset($values[1]) ? $values[1] : '';
        }

        // Set parameters
        if (!isset($attributes['data'])){
            $attributes['data'] = $matches;
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
    private function mergeByArray($array, $matches){
        $attributes = [];

        foreach ($array as $key => $value) {
                if(is_string($key)){
                        $attributes[$key] = $value;
                }
        }

        // Set parameters
        if (!isset($attributes['data'])){
                $attributes['data'] = $matches;
        }

        return $attributes;
    }

    /**
     * Set variables method
     *
     * @param array $attributes
     * @return array $attributes
     */
    private function setVariables($attributes, $onUrl){
        $__attributes = [];

        foreach ($attributes as $key => $value) {
            $_v = $value;

            if(is_array($_v)){
                $_v = $this->setVariables($_v, $this->matches);

                if(!is_numeric($key)){
                    foreach ($this->matches as $k => $v) {
                        $key = str_replace('{'.$k.'}', $v, $key);
                    }
                }

            } else {
                if(is_numeric($key)){
                    foreach ($this->matches as $k => $v) {
                        $_v = str_replace('{'.$k.'}', $v, $_v);
                    }
                } else {
                    foreach ($this->matches as $k => $v) {
                        $_v = str_replace('{'.$k.'}', $v, $_v);
                        $key = str_replace('{'.$k.'}', $v, $key);
                    }
                }

                $_v = preg_replace('/\{(.*?)\}/', '', $_v);
            }

            $__attributes[$key] = $_v;
            
            unset($onUrl[$key]);
        }
        
        return $__attributes ? array_merge($__attributes, $onUrl) : $attributes;
    }
}
