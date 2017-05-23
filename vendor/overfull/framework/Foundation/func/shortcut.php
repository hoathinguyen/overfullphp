<?php
/**
 * Route function
 * THis func call Url object and get url by route name
 * @param type $name
 * @param type $params
 * @param type $skipNoParameter
 */
if(!function_exists('route')){
    function route($name, $params = [], $skipNoParameter = true){
        return Bag::route()->getUrl($name, $params, $skipNoParameter);
    }
}

/**
 * asset file method
 * @param string $name
 * @return string
 */
if(!function_exists('asset')){
    function asset($name){
        return \Overfull\Support\Utility\UrlUtil::asset($name);
    }
}

/**
 * To method
 * @param type $name
 * @param type $inRoot
 * @return type
 */
if(!function_exists('to')){
    function to($name, $inRoot = true){
        return \Overfull\Support\Utility\UrlUtil::to($name, $inRoot);
    }
}

/**
 * noneUnicode method
 *
 * @author ToiTL
 * @date 2016/02/26
 */
if(!function_exists('toAlpha')){
    function toAlpha( $string ){
        return \Overfull\Support\Utility\UrlUtil::toAlpha($string);
    }
}

/**
 * Check is url method
 * @param string $string
 * @return boolean
 */
if(!function_exists('isUrl')){
    function isUrl($string){
        return \Overfull\Support\Utility\UrlUtil::isUrl($string);
    }
}

/**
 * Bag
 * @param type $name
 */
if(!function_exists('bag')){
    function bag($name){
        return \Bag::$name();
    }
}

/**
 * request
 */
if(!function_exists('request')){
    function request(){
        return \Bag::request();
    }
}

/**
 * request
 */
if(!function_exists('module')){
    function module($name = null){
        if($name){
            return \Bag::module()->{$name};
        }

        return \Bag::module();
    }
}

if(!function_exists('auth')){
    function auth($scope = null){
        if($scope){
            return \Bag::module()->auth->scope($scope);
        }

        return \Bag::module()->auth;
    }
}
/**
 * request
 */
if(!function_exists('flash')){
    function flash(){
        return \Bag::flash();
    }
}
/**
 * Function shortcut for config
 */
if(!function_exists('config')){
    function config($name = false){
        if(!$name){
            return bag('config');
        }

        return bag('config')->get($name);
    }
}
/**
 * Db shortcut method
 */
if(!function_exists('db')){
    function db($name = null){
        if($name){
            return \Bag::db()->{$name};
        }

        return \Bag::db();
    }
}

/**
 * Db shortcut method
 */
if(!function_exists('event')){
    function event(){
        return \Bag::event();
    }
}

/**
 * Configure domain shortcut method
 */
if(!function_exists('domain')){
    function domain(){
        return \Bag::route()->getDomainConfig();
    }
}

/**
 * Configure domain shortcut method
 */
if(!function_exists('uri')){
    function uri(){
        return \Bag::route()->getUriConfig();
    }
}