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

		// Route
		static::$route = new Route(false);

		$pattern = Config::get('core.pattern');

		if(!class_exists($pattern)){
			$pattern = "\Overfull\Pattern\{$pattern}\PatternHandler";
			if(!class_exists($pattern)){
				throw new PatternNotFoundException($pattern);
			}
		}

		static::$pattern = new $pattern();
	}
}