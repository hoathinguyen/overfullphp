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
        if(static::isUrl($name)){
            return $name;
        }

        if ( substr($name, 0, 1) != '/') {
            $route = Bag::request()->publicPath();

            $name = ($route == '' ? '' : '/'.$route).'/'.$name;
        }

        return Bag::request()->root().$name;
    }

    /**
     * Get url by alias route
     * @param string $name
     * @return string
     */
    public static function route($name, $params = [], $skipNoParameter = false){
        $alias = Bag::route()->alias($name, false);

        if(!$alias){
            throw new \Overfull\Exception\RouteAliasNotFoundException($name);
        }
        $route = Bag::config()->get('app.route');
        return Bag::request()->root().'/'.($route ? $route . '/' : ''). $alias->getRoute($params, $skipNoParameter);
    }

    /**
     * asset method
     *
     * @param string $name
     * @return string
     */
    public static function to($name, $inRoot = true){
        if(static::isUrl($name)){
                return $name;
        }

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

    /**
     * Check is url method
     * @param string $string
     * @return boolean
     */
    public static function isUrl($string){
        if (filter_var($string, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }

        return true;
    }
}
