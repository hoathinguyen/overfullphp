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
	 * get value of config
	 *
	 * @date 2016/05/21
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
	public function set( $name = false, $val = array() , $isPath = false){
		try {
			if ( !$name ) {
				return;
			}

			if($isPath){
				if(file_exists($val)){
					$this->configs[$name] = require($val);
				} else {
					throw new ConfigFileNotFoundException($val);
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