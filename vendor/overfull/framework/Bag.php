<?php
/* ----------------------------------------------------
* The Bag object class
* This will be set all of object in this transaction
* ----------------------------------------------------
*/
use Overfull\Http\Request\HttpRequest as Request;
use Overfull\Http\Response\HttpResponse as Response;
use Overfull\Routing\Route;
use Overfull\Configure\Config;
use Overfull\Exception\PatternNotFoundException;
//use overfull\pattern\mvc\MVCHandler;
use Overfull\Database\DbStore;
use Overfull\Http\Record\Session\HttpSession;
use Overfull\Packages\Foundation\PackageStore;
use Overfull\Support\Store;

class Bag{
	// The variable for request
	public static $request;

	// The variable for response
	public static $response;

	// Route variable
	public static $route;

	// MVCHandler
	public static $pattern;

	public static $db;

	public static $session;

	public static $package;

	public static $store;

	public static $config;

    public static $error;

    public static $system;

	public static $flash;

	/**
	* The main application will call this method before use it.
	* This method will create some object in this app
	*/
	public static function init(){
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
     * GEt error
     */
    public static function error(){
        if(!static::$error){
            static::$error = new \Overfull\Exception\Handler\ErrorData();
        }

        return static::$error;
    }

	/**
	 * Get DbStore
	 * @return DbStore
	 */
	public static function db(){
		if(!static::$db){
			static::$db = new DbStore();
		}

		return static::$db;
	}

	/**
	 * Get Request
	 * @return Request
	 */
	public static function request(){
		if(!static::$request){
			static::$request = new Request();
		}

		return static::$request;
	}

	/**
	 * Get response
	 * @return Response
	 */
	public static function response(){
		if(!static::$response){
			static::$response = new Response();
		}

		return static::$response;
	}

	/**
	 * Get Session
	 * @return BaseSession
	 */
	public static function session(){
		if(!static::$session){
			static::$session = new HttpSession();
		}

		return static::$session;
	}

	/**
	 * Get Route
	 * @return Route
	 */
	public static function route(){
		if(!static::$route){
			static::$route = new Route(false);
		}

		return static::$route;
	}

	/**
	 * Get package
	 * @return PackageStore
	 */
	public static function package($name = null){
		if(!static::$package){
			static::$package = new PackageStore();
		}

                if($name){
                    return static::$package->{$name};
                }

		return static::$package;
	}

	/**
	 * Get MyStore
	 * @return PackageStore
	 */
	public static function store(){
		if(!static::$store){
			static::$store = new Store();
		}

		return static::$store;
	}

	/**
	 * Get MyStore
	 * @return Config
	 */
	public static function config(){
		if(!static::$config){
			static::$config = new Config();
		}

		return static::$config;
	}

	/**
	 * Get Route
	 * @return Route
	 */
	public static function pattern(){
		if(!static::$pattern){
			$pattern = static::config()->get('core.pattern');
			if(!class_exists($pattern)){
				$__pattern = "\Overfull\Patterns\{$pattern}\PatternHandler";
				if(!class_exists($__pattern)){
					throw new PatternNotFoundException($pattern);
				}

				$pattern = $__pattern;
			}

			static::$pattern = new $pattern();
		}

		return static::$pattern;
	}

    /**
	 * Get MyStore
	 * @return Config
	 */
	public static function system(){
            if(!static::$system){
                static::$system = new Overfull\System\System();
            }

            return static::$system;
	}

	/**
	 * Get MyStore
	 * @return flash object
	 */
	public static function flash(){
		if(!static::$flash){
			static::$flash = new \Overfull\Support\Flash();
		}

		return static::$flash;
	}
}
