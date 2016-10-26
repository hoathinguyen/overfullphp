<?php
/**
* ___________________________________________________________________________
*
* ArrayUtil object class
*
* Some method to handle array
* ___________________________________________________________________________
*/
namespace Overfull\Utility;
use Overfull\Utility\Foundation\BaseUtil;

class ArrayUtil extends BaseUtil{
	public final static function access( $arr = null , $name = '' ){
		try {
			if ( empty($name) ) return $arr;
			 
			$exs = explode('.', $name);
			$result = $arr;

			foreach ($exs as $key => $value) {
				$result = isset($result[$value]) ? $result[$value] : null;
			}

			return $result;
		}catch( Exception $e ){
			throw $e;
		}
	}
}