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
			$root = Bag::route()->fileroot;

			$name = ($root == '/' ? '' : $root).($route == '' ? '' : '/'.$route).'/'.$name;

		} else {
			$name = (Bag::route()->fileroot != '/' ? Bag::route()->fileroot : '').$name;
		}

		return Bag::request()->schema().Bag::request()->host().$name;
	}

	/**
	 * asset method
	 *
	 * @param string $name
	 * @return string
	 */
	public static function to($name){
		if ( substr($name, 0, 1) != '/') {
			// todo
		} else {
			$name = (Bag::route()->fileroot != '/' ? Bag::route()->fileroot : '').$name;
		}

		return Bag::request()->schema().Bag::request()->host().$name;
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