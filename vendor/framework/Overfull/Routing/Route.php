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
		Bag::config()->delete('routes');

		// Check if have no data in pages
		if(empty($configs['pages'])){
			throw new PageNotFoundException();
		}

		// Get root
		$this->uri = $this->setWebroot($configs, Bag::request()->uriArray());
		$this->url = explode('?', $this->uri)[0];

		$this->setAlias($configs['pages']);

		if($this->validAlias == null){
			throw new PageNotFoundException();
		}

		$data = $this->validAlias->get();

		$this->attributes = array_merge($data, $this->attributes);
	}

	/**
	* Get webroot method
	*
	* @param array $pages
	* @param string $prefix
	* @return void
	*/
	private function setAlias($pages, $prefix = ''){
		foreach ($pages as $key => $value) {
			if(is_numeric($key)){
				$regex = $this->convertRegex($value[0]);

				if($regex){
					$regex = $prefix.$regex;
				} else {
					$regex = $prefix;
				}
					
				$value['regex'] = $regex;

				$alias = new RouteAlias($value);

				if(!empty($value['as'])){
					$aliasName = (!empty($prefix) ? $prefix.'.' : '').$value['as'];
					$this->alias[$aliasName] = $alias;
				}

				if($this->validAlias == null 
					&& ($alias->isValid($this->uri)
					|| $alias->isValid($this->url)) ){
					$this->validAlias = $alias;
				}
			} else {
				$this->setAlias($value, (!empty($prefix) ? $prefix.'.' : '').$key.'\/');
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
		$appConfig = Bag::config()->get('app');

		// Get baseFolder
		$base = (int) Bag::config()->get('app.base');
		$publicFolder = '';

		$root = ROOT;
		for ($i = 1; $i <= $base; $i++) {
			$publicFolder = '/'.basename($root).$publicFolder;
			$root = dirname($root);
			array_shift($url);
		}

		$this->attributes['webroot'] = $publicFolder;
		$this->attributes['fileroot'] = $publicFolder;

		// Get root name with config on global
		if('sub-folder' == $appConfig['for']){
			$this->attributes['webroot'] .= !empty($appConfig['route']) ? '/'.$appConfig['route'] : '';
			array_shift($url);
		}

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

		if(!$this->attributes['fileroot']){
			$this->attributes['fileroot'] = '/';
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
		//
		return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
	}

	/**
	* __get method
	*
	* @param string $name
	* @return value
	*/
	public function __set($name, $value){
		//Nothing
		$this->attributes[$name] = $value;
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