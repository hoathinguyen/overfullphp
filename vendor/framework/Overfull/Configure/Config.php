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
	private static $configs = array();

	/**
	 * get value of config
	 *
	 * @date 2016/05/21
	 * @param string $name
	 */
	public static function get( $name = '' ){
		try {
			return ArrayUtil::access(self::$configs, $name);
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
	public static function set( $name = false, $val = array() , $isPath = false){
		try {
			if ( !$name ) {
				return;
			}

			if($isPath){
				if(file_exists($val)){
					self::$configs[$name] = require($val);
				} else {
					throw new ConfigFileNotFoundException($val);
				}
			} else {
				self::$configs[$name] = $val;
			}
			
		}catch( Exception $e ){
			throw new Exception($e->getMessage(), 102);
		}
	}
}