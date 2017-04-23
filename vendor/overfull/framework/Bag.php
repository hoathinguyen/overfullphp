<?php
/**
 * Bag object class
 * This static class contains all of relative important in resource
 * @author Overfull.net
 * @link http://php.overfull.net/docs/bag Document for bag
 * @date 2015/01/15
 */
class Bag
{
    // The variable for request
    public static $request;

    // The variable for response
    public static $response;

    // Route variable
    public static $route;

    // MVCHandler
    public static $pattern;
    
    // BD
    public static $db;
    
    // Session
    public static $session;
    
    // Package
    public static $module;
    
    // Store
    public static $store;
    
    // Config
    public static $config;
    
    // Error handler
    public static $error;
    
    // System
    public static $system;
    
    // Flash
    public static $flash;

    // Events
    public static $event;

    /**
     * The main application will call this method before use it.
     * This method will create some object in this app
     * @return void
     */
    public static function init()
    {
        static::db();
        // Create request
        static::request();
        // Response
        static::response();

        static::session()->start();

        static::store();

        static::config();

        static::system();
    }

    /**
     * Get error handler method
     * This method will create new error handler object if is not exists
     * @return \Overfull\Exception\Handler\ErrorData
     */
    public static function error()
    {
        if(!static::$error){
            static::$error = new \Overfull\Exception\Handler\ErrorData();
        }

        return static::$error;
    }

    /**
     * Get DB store method
     * This method will create new \Overfull\Database\DbStore if have no created
     * @return \Overfull\Database\DbStore
     */
    public static function db()
    {
        if(!static::$db){
            static::$db = new \Overfull\Database\DbStore();
        }

        return static::$db;
    }

    /**
     * Get request object method
     * This method will create new \Overfull\Http\Request\HttpRequest if have no created
     * @return \Overfull\Http\Request\HttpRequest
     */
    public static function request()
    {
        if(!static::$request){
            static::$request = new \Overfull\Http\Request\HttpRequest();
        }

        return static::$request;
    }

    /**
     * Get Response object method
     * @return \Overfull\Http\Response\HttpResponse
     */
    public static function response()
    {
        if(!static::$response)
        {
            static::$response = new \Overfull\Http\Response\HttpResponse();
        }

        return static::$response;
    }

    /**
     * Get Session object method
     * @return \Overfull\Http\Record\Session\HttpSession
     */
    public static function session()
    {
        if(!static::$session)
        {
            static::$session = new \Overfull\Http\Record\Session\HttpSession();
        }

        return static::$session;
    }

    /**
     * Get Route object method
     * @return \Overfull\Routing\Route
     */
    public static function route()
    {
        if(!static::$route)
        {
            static::$route = new \Overfull\Routing\Route(false);
        }

        return static::$route;
    }

    /**
     * Get module object method
     * @return \Overfull\Modules\Foundation\ModuleStore
     */
    public static function module($name = null)
    {
        if(!static::$module){
            static::$module = new \Overfull\Modules\Foundation\ModuleStore();
        }

        if($name){
            return static::$module->{$name};
        }

        return static::$module;
    }

    /**
     * Get MyStore object method
     * @return \Overfull\Support\Store
     */
    public static function store()
    {
        if(!static::$store)
        {
            static::$store = new \Overfull\Support\Store();
        }

        return static::$store;
    }

    /**
     * Get config object method
     * @return \Overfull\Configure\Config
     */
    public static function config()
    {
        if(!static::$config)
        {
            static::$config = new \Overfull\Configure\Config();
        }

        return static::$config;
    }

    /**
     * Get pattern object method
     * @return Instance of Pattern
     * @throws \Overfull\Exception\PatternNotFoundException
     */
    public static function pattern()
    {
        if(!static::$pattern){
            $pattern = static::config()->get('core.pattern');
            if(!class_exists($pattern)){
                $__pattern = "\Overfull\Patterns\{$pattern}\PatternHandler";
                if(!class_exists($__pattern)){
                        throw new \Overfull\Exception\PatternNotFoundException($pattern);
                }

                $pattern = $__pattern;
            }

            static::$pattern = new $pattern();
        }

        return static::$pattern;
    }

    /**
    * Get system
    * @return Overfull\System\System
    */
    public static function system()
    {
       if(!static::$system){
           static::$system = new Overfull\System\System();
       }

       return static::$system;
    }

    /**
     * Get flash
     * @return \Overfull\Support\Flash
     */
    public static function flash()
    {
        if(!static::$flash){
            static::$flash = new \Overfull\Support\Flash();
        }

        return static::$flash;
    }

    /**
     * Get event
     * @return \Overfull\Support\Flash
     */
    public static function event()
    {
        if(!static::$event){
            static::$event = new \Overfull\Events\Guide();
        }

        return static::$event;
    }
}
