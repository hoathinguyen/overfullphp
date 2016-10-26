<?php
/*___________________________________________________________________________
* The route object class
* This object handle some business about routing. You can rewrite url mapping
* with your controller or filter ...
* ___________________________________________________________________________
*/
namespace Overfull\Routing;
use Overfull\Foundation\Base\BaseObject;
use Overfull\Configure\Config;
use Overfull\Http\Request;
use Bag;
use Overfull\Exception\PageNotFoundException;

class Route extends BaseObject{
	/**
	* Regex keys
	* This array contains all of key config on routes to parse to regex
	*/
    private $__regexKeys = [
    	'<:all>' => '(.*)',
    	'/' => '\/',
    	'?' => '\?',
    	'<:empty>' => '',
    	'<:integer>' => '(0|[1-9][0-9]*)',
    	'<:alphanumeric>' => '([a-zA-Z0-9]*)'
    ];

    /**
    * Attributes array
    * This contains all of property after merge
    */
    private $__attributes = [];

    /**
    * Config array
    */
    private $configs = [];

    private $uri = '';

    private $url = '';

    public function __construct($merge = false){
    	$this->configs = Config::get('routes');
    	if($merge){
    		$this->merge();
    	}
    }

	/**
	* Merge route with url method
	*/
	public function merge($prefix = ''){
		// Get root
		$this->uri = $this->setWebroot($this->configs, Bag::request()->uriArray());
		$this->url = explode('?', $this->uri)[0];

		$matches = $this->setAttributes($prefix);

		$__attributes = $this->__attributes;
		
		unset($__attributes['webroot']);
		if(!$__attributes){
			throw new PageNotFoundException();
		}

		$this->__attributes = $this->setValueForVariable($this->__attributes, $matches);
	}

	/**
	* Set attributes method
	*
	* @param string $prefix
	*/
	private function setAttributes($prefix){
		// Check if isset pages
		if ( !array_key_exists('pages', $this->configs) ) return;

		$__prefix = $prefix ? $prefix.'\/' : '';

		foreach ($this->configs['pages'] as $key => $value) {

			if(is_numeric($key)){
				if ( !Bag::request()->isMethod($value[1]) ) continue;

				$regex = $this->convertRegex($value[0]);

				if($regex){
					$regex = $__prefix.$regex;
				} else {
					$regex = $prefix;
				}

				//Get match
	        	if(preg_match('/^'.$regex.'$/', $this->uri, $matches) 
	        		|| preg_match('/^'.$regex.'$/', $this->url, $matches)){
	        		if ( is_object($value[2]) ) {
	        			// Call merge by object
						$this->mergeByObject($value[2], $value[0], $matches);
					}else if( is_array($value[2]) ){
						// Call merge by array
						$this->mergeByArray($value[2], $matches);
					}else{
						// Call merge by array
						$this->mergeByString($value[2], $matches);
					}
					return $matches;
	        	}
			} else {
				$this->configs['pages'] = $value;
        		if($matches = $this->setAttributes($__prefix.$key)){
        			return $matches;
        		}
        	}
		}

		return [];
	}

	/**
	* mergeByObject
	*/
	private function mergeByObject($object, $urlRegex, $matches){
		$result = $object($urlRegex, $matches);
		
		if( is_array($result) ){
			// Call merge by array
			$this->mergeByArray($result, $matches);
		}else{
			// Call merge by array
			$this->mergeByString($result, $matches);
		}
	}

	/**
	* mergeByString
	*/
	private function mergeByString($str, $matches){
		$couples = explode(';', $str);

		foreach ($couples as $key => $value) {
			$values = explode('=', $value);

			$this->__attributes[$values[0]] = isset($values[1]) ? $values[1] : '';
		}

		// Set parameters
		if (!isset($this->__attributes['parameters'])){
			$this->__attributes['parameters'] = $matches;
		}
	}

	/**
	* mergeByArray
	*/
	private function mergeByArray($array, $matches){

		foreach ($array as $key => $value) {
			if(is_string($key)){
				$this->__attributes[$key] = $value;
			}
		}

		// Set parameters
		if (!isset($this->__attributes['parameters'])){
			$this->__attributes['parameters'] = $matches;
		}
	}

	/**
	* Get webroot method
	*
	* @param array $config
	* @param string $url
	* @return string $url
	*/
	private function setWebroot($configs, $url){
		$this->__attributes['webroot'] = '';

		$subs = Config::get('app');

		if($folderRoute = Config::get('app-config.route-root')){
			array_shift($url);
		}

		if ( !empty($configs['base']) && is_numeric($configs['base'])) {
			for($i = 0; $i < $configs['base']; $i++){
				$this->__attributes['webroot'] .= $url[0];
				array_shift($url);
			}
		}

		return implode('/', $url);
	}

	/**
	*
	*
	*/
	private function setValueForVariable($attributes, $matches){
		//echo json_encode($attributes);
		$__attributes = [];

		foreach ($attributes as $key => $value) {
			$_v = $value;

			if(is_array($_v)){
				$_v = $this->setValueForVariable($_v, $matches);

				if(!is_numeric($key)){
					foreach ($matches as $k => $v) {
						$key = str_replace('{'.$k.'}', $v, $key);
					}
				}

			} else {
				if(is_numeric($key)){
					foreach ($matches as $k => $v) {
						$_v = str_replace('{'.$k.'}', $v, $_v);
					}
				} else {
					foreach ($matches as $k => $v) {
						$_v = str_replace('{'.$k.'}', $v, $_v);
						$key = str_replace('{'.$k.'}', $v, $key);
					}
				}
			}

			$__attributes[$key] = $_v;
		}

		return $__attributes ? $__attributes : $attributes;
	}

	/**
	* __get method
	*
	* @param string $name
	* @return value
	*/
	public function __get($name){
		//
		return isset($this->__attributes[$name]) ? $this->__attributes[$name] : null;
	}

	/**
	* __get method
	*
	* @param string $name
	* @return value
	*/
	public function __set($name, $value){
		//Nothing
		$this->__attributes[$name] = $value;
	}

	/**
	* convertRegex method
	*
	* @param string $str
	* @return value
	*/
	private function convertRegex($str){
		foreach ($this->__regexKeys as $key => $value) {
			$str = str_replace($key, $value, $str);
		}

		return $str;
	}
}