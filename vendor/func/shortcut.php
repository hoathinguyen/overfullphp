<?php
/**
 * Route function
 * THis func call URL object and get url by route name
 * @param type $name
 * @param type $params
 * @param type $skipNoParameter
 */
function route($name, $params = [], $skipNoParameter = false){
    return Overfull\Utility\URLUtil::route($name, $params, $skipNoParameter);
}

/**
 * asset file method
 * @param string $name
 * @return string
 */
function asset($name){
    return \Overfull\Utility\URLUtil::asset($name);
}

/**
 * To method
 * @param type $name
 * @param type $inRoot
 * @return type
 */
function to($name, $inRoot = true){
    return \Overfull\Utility\URLUtil::to($name, $inRoot);
}

/**
 * noneUnicode method
 *
 * @author ToiTL
 * @date 2016/02/26
 */
function toAlpha( $string ){
    return \Overfull\Utility\URLUtil::toAlpha($string);
}

/**
 * Check is url method
 * @param string $string
 * @return boolean
 */
function isUrl($string){
    return \Overfull\Utility\URLUtil::isUrl($string);
}

/**
 * Bag
 * @param type $name
 */
function bag($name){
    return \Bag::$name();
}

/**
 * request
 */
function request(){
    return \Bag::request();
}