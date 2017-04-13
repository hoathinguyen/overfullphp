<?php
/*----------------------------------------------------
* Filename: UsersController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Overfull\Support\Utility;
use Overfull\Support\Utility\Foundation\BaseUtil;
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
            return Bag::request()->root().'/'.$name;
        }

        return Bag::request()->baseUrl().$name;
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
                $prefix = Bag::config()->get('app.prefix');

                $name = ($prefix == '' ? '' : '/'.$prefix).'/'.$name;

        } else if($inRoot){
                $prefix = Bag::config()->get('app.prefix');

                $name = ($prefix == '' ? '' : '/'.$prefix).$name;
        }

        return Bag::request()->baseUrl().$name;
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
