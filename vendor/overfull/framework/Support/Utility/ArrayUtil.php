<?php
/*----------------------------------------------------
* Filename: ArrayUtil.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle categories
* ----------------------------------------------------
*/
namespace Overfull\Support\Utility;
use Overfull\Support\Utility\Foundation\BaseUtil;

class ArrayUtil extends BaseUtil{
	/**
	 * Access array
	 * @param array $arr
	 * @param string $name
	 * @return array with grouped
	 */
	public final static function access( $arr = null , $name = '' ){
		if ( empty($name) || empty($arr) || !is_array($arr)) return $arr;

		$result = $arr;

		if(array_key_exists($name, $arr)){
			return $result[$name];
		}

		$exs = explode('.', $name);


		foreach ($exs as $key => $value) {
			$result = isset($result[$value]) ? $result[$value] : null;
		}

		return $result;
	}
        
        /**
	 * Access array
	 * @param array $arr
	 * @param string $name
	 * @return array with grouped
	 */
	public final static function remove(&$ob , $name = '' )
        {
            // Check if exists this key
            if(array_key_exists($name, $ob)){
                unset($ob[$name]);
                return;
            }
            
            $exs = explode('.', $name);
            $count = count($exs);
            foreach($exs as $key => $value)
            {
                if(array_key_exists($value, $ob))
                {
                    if($key == ($count - 1))
                    {
                        unset($ob[$value]);
                        return;
                    }
                        
                    $ob = &$ob[$value];
                }
                else
                {
                    return;
                }
            }
	}

	/**
	 * Check if is exists this key
	 */
	public final static function isExists( $arr = null , $name = '' ){
		if(!$arr){
			return false;
		}
		
		if ( array_key_exists($name, $arr) ) return true;

		$result = $arr;

		$exs = explode('.', $name);

		foreach ($exs as $key => $value) {
			$result = array_key_exists($value, $result) ? true : false;
		}

		return $result;
	}

	/**
	 * Set value method
	 */
	public static function setValue(&$ob, $name, $value){
		$exs = explode('.', $name);
		$count = count($exs);

		for($index = 0; $index < $count; $index++) {
			if($index == ($count - 1)){
				$ob[$exs[$index]] = $value;
				return;
			}

			if(!array_key_exists($exs[$index], $ob)){
				$ob[$exs[$index]] = [];
			}

			$ob = &$ob[$exs[$index]];
		}
	}

	/**
	 * Group object by a attribute
	 * @param array $arr
	 * @param string $name
	 * @return array with grouped
	 */
	public final static function countKey( $arr = null , $name = false ){

	}

	/**
	 * Group object by a attribute
	 * @param array $objects
	 * @param string $attribute
	 * @return array with grouped
	 */
	public final static function groupObject( $objects = null , $attribute = false ){
		$resultList = [];

		foreach ($objects as $key => $object) {
			if(!isset($resultList[$object->{$attribute}])){
				$resultList[$object->{$attribute}] = [];
			}

			$resultList[$object->{$attribute}][] = $object;
		}

		return $resultList;
	}
}
