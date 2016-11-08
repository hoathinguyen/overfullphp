<?php
/*----------------------------------------------------
* Config object class
* This class is parent for all of config object.
* This has some method will be use as static.
* ----------------------------------------------------
*/
namespace Overfull\Configure;
use Overfull\Foundation\Base\BaseObject;
use Overfull\Utility\ArrayUtil;
use Overfull\Exception\ConfigFileNotFoundException;

class Config extends BaseObject{
	private $configs = array();

	/**
	 * Get value of config
	 *
	 * @param string $name
	 */
	public function get( $name = '' ){
		try {
			return ArrayUtil::access($this->configs, $name);
		}catch( Exception $e ){
			throw new Exception($e->getMessage(), 102);
		}
	}

	/**
	 * set value for config
	 *
	 * @date 2016/05/21
	 * @param string $name
	 * @param value $val
	 * @param boolean $isPath
	 */
	public function set( $name = false, $val = array() , $isPath = false, $isException = true){
		try {
			if ( !$name ) {
				return;
			}

			if($isPath){
				if(is_array($val)){
					if(empty($this->configs[$name])){
						$this->configs[$name] = [];
					}
					foreach ($val as $key => $value) {
						if(file_exists($value)){
							$configs = require($value);
							$this->configs[$name] = array_merge($this->configs[$name], $configs);
						} else if($isException){
							throw new ConfigFileNotFoundException($val);
						}
					}
				} else {
					if(file_exists($val)){
						$this->configs[$name] = require($val);
					} else if($isException){
						throw new ConfigFileNotFoundException($val);
					}
				}
				
			} else {
				$this->configs[$name] = $val;
			}
			
		}catch( Exception $e ){
			throw new Exception($e->getMessage(), 102);
		}
	}

	/**
	 * Delete config
	 *
	 * @param string $name
	 * @return void
	 */
	public function delete($name){
		unset($this->configs[$name]);
	}
}