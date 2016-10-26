<?php
/* ----------------------------------------------------
* The Bag object class
* This will be set all of object in this transaction
* ----------------------------------------------------
*/
use Overfull\Http\Request;
use Overfull\Http\Response;
use Overfull\Routing\Route;
use Overfull\Configure\Config;
use Overfull\Exception\PatternNotFoundException;
//use overfull\pattern\mvc\MVCHandler;
use Overfull\Database\DbStore;
use Overfull\Record\Session\BaseSession;
use Overfull\Package\PackageStore;
use Overfull\My\MyStore;

class Bag{
	// The variable for request
	public static $request;

	// The variable for response
	public static $response;

	// Route variable
	public static $route;

	// MVCHandler
	public static $pattern;

	public static $dbstore;

	public static $session;

	public static $package;

	public static $mystore;

	/**
	* The main application will call this method before use it.
	* This method will create some object in this app
	*/
	public static function init(){
		static::$dbstore = new DbStore();
		// Create request
		static::$request = new Request();
		// Response
		static::$response = new Response();

		static::$session = new BaseSession();

		static::$package = new PackageStore();

		static::$mystore = new MyStore();
	}

	/**
	 * Get DbStore
	 * @return DbStore
	 */
	public static function dbstore(){
		if(!static::$dbstore){
			static::$dbstore = new DbStore();
		}

		return static::$dbstore;
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
			static::$session = new BaseSession();
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
	public static function package(){
		if(!static::$package){
			static::$package = new PackageStore();
		}

		return static::$package;
	}

	/**
	 * Get MyStore
	 * @return PackageStore
	 */
	public static function mystore(){
		if(!static::$mystore){
			static::$mystore = new MyStore();
		}

		return static::$mystore;
	}

	/**
	 * Get Route
	 * @return Route
	 */
	public static function pattern(){
		if(!static::$pattern){
			$pattern = Config::get('core.pattern');
			if(!class_exists($pattern)){
				$pattern = "\Overfull\Pattern\{$pattern}\PatternHandler";
				if(!class_exists($pattern)){
					throw new PatternNotFoundException($pattern);
				}
			}

			static::$pattern = new $pattern();
		}

		return static::$pattern;
	}
}