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

		if ( !Bag::request()->isMethod($this->data[1]) )
			return false;

		if(preg_match('/^'.$this->data['regex'].'$/', $uri, $this->matches)){
			return true;
		}

		return false;
	}

	/**
	 * getMatches
	 * @return array matches
	 */
	public function getMatches(){
		return $this->matches;
	}

	/**
	* Run method
	*
	* @return void
	*/
	public function get(){
		if ( is_object($this->data[2]) ) {
			// Call merge by object
			$result = $this->mergeByObject($this->data[2], $this->data[0], $this->matches);
		}else if( is_array($this->data[2]) ){
			// Call merge by array
			$result = $this->mergeByArray($this->data[2], $this->matches);
		}else{
			// Call merge by array
			$result = $this->mergeByString($this->data[2], $this->matches);
		}

		return $this->setVariables($result);
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
		if (!isset($attributes['parameters'])){
			$attributes['parameters'] = $matches;
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
		if (!isset($attributes['parameters'])){
			$attributes['parameters'] = $matches;
		}

		return $attributes;
	}

	/**
	 * Set variables method
	 *
	 * @param array $attributes
	 * @return array $attributes
	 */
	private function setVariables($attributes){
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
			}

			$__attributes[$key] = $_v;
		}

		return $__attributes ? $__attributes : $attributes;
	}
}