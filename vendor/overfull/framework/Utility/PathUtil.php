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

class PathUtil extends BaseUtil{
	public static function getFull( $string = '' ){
		return ROOT.DS.$string;
	}

	public static function check( $string = '' ){
		return file_exists(self::getFull($string));
	}

	public static function convert( $string = '' ){
		$string = str_replace('.', DS, $string);
		return str_replace('\\', DS, $string);
	}
}