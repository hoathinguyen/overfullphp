<?php
/*----------------------------------------------------
* Filename: UsersController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Overfull\Utility;
use Overfull\Utility\Foundation\BaseUtil;
use Bag;

class URLUtil extends BaseUtil{
	/**
	 * asset method
	 *
	 * @param string $name
	 * @return string
	 */
	public static function asset($name){
		if ( substr($name, 0, 1) != '/') {
			$route = Bag::config()->get('app.route');

			$name = ($route == '' ? '' : '/'.$route).'/'.$name;
		}

		return Bag::request()->root().$name;
	}

	/**
	 * asset method
	 *
	 * @param string $name
	 * @return string
	 */
	public static function to($name, $inRoot = true){
		if ( substr($name, 0, 1) != '/') {
			$route = Bag::config()->get('app.route');

			$name = ($route == '' ? '' : '/'.$route).'/'.$name;

		} else if($inRoot){
			$route = Bag::config()->get('app.route');

			$name = ($route == '' ? '' : '/'.$route).$name;
		}

		return Bag::request()->root().$name;
	}

	/**
	 * noneUnicode method
	 *
	 * @author ToiTL
	 * @date 2016/02/26
	 */
	public static function toAlpha( $string ){
		$string = str_replace(' ', '-', $string);
		$string = str_replace('?', '-', $string);
		return $string;
	}
}