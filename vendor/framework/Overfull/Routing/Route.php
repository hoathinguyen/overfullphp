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

	private $validAlias = null;

	private $url = '';

	private $uri = '';

	private $attributes = [];
	/**
	* Regex keys
	* This array contains all of key config on routes to parse to regex
	*/
    private $regexKeys = [
    	'<:all>' => '(.*)',
    	'/' => '\/',
    	'?' => '\?',
    	'<:empty>' => '',
    	'<:integer>' => '(0|[1-9][0-9]*)',
    	'<:alphanumeric>' => '([a-zA-Z0-9]*)'
    ];

	/**
	 * Run method
	 *
	 * @return void
	 */
	public function run(){
		$configs = Bag::config()->get('routes');

		// Check if have no data in pages
		if(empty($configs['pages'])){
			throw new PageNotFoundException();
		}
		// Get root
		if(Bag::config()->get('routes.compare') == 'relative'){
			$this->uri = strtolower($this->setWebroot($configs, Bag::request()->uriArray()));
		} else {
			$this->uri = $this->setWebroot($configs, Bag::request()->uriArray());
		}
		
		$this->url = explode('?', $this->uri)[0];

		$this->setAlias($configs['pages']);

		if($this->validAlias == null){
			throw new PageNotFoundException();
		}

		$data = $this->validAlias->get();

		$this->attributes = array_merge($data, $this->attributes);

		Bag::config()->delete('routes');
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
				$regex = $this->convertRegex($prefix.$value[0]);

				if(substr( $regex, -1 ) == '/'){
					$regex = substr($regex, 0, -2);
				}

				$value['regex'] = $regex;

				$alias = new RouteAlias($value);

				if(!empty($value['as'])){
					$aliasName = $aliasName.'.'.$value['as'];
					$this->alias[$aliasName] = $alias;
				}

				if($this->validAlias == null 
					&& ($alias->isValid($this->uri)
					|| $alias->isValid($this->url)) ){
					$this->validAlias = $alias;
				}
			} else {
				$this->setAlias($value, (!empty($prefix) ? $prefix : '').$key.'/', (!empty($prefix) ? $prefix.'.' : '').$key);
			}
		}
	}

	/**
	* Get webroot method
	*
	* @param string $name
	* @return RouteAlias
	*/
	public function getAlias($name){
		return isset($this->alias[$name]) ? $this->alias[$name] : null;
	}

	/**
	* Get webroot method
	*
	* @param array $config
	* @param string $url
	* @return string $url
	*/
	private function setWebroot($configs, $url){
		// Get baseFolder
		$base = (int) Bag::config()->get('app.base');

		//$root = ROOT;
		for ($i = 1; $i <= $base; $i++) {
			array_shift($url);
		}

		$this->attributes['webroot'] = '';

		//Get root with private setting
		if ( !empty($configs['base']) && is_numeric($configs['base'])) {
			for($i = 0; $i < $configs['base']; $i++){
				$this->attributes['webroot'] .= !empty($url[0]) ? '/'.$url[0] : '';
				array_shift($url);
			}
		}

		if(!$this->attributes['webroot']){
			$this->attributes['webroot'] = '/';
		}

		return implode('/', $url);
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
			$str = str_replace($key, $value, $str);
		}

		return $str;
	}
}