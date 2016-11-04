<?php
/*----------------------------------------------------
* The application object class
* This class is highest in framework. First, this class will be call,
* and run some require and logic of framework
* ----------------------------------------------------
*/
namespace Overfull;
use Overfull\Foundation\Base\BaseObject;
use Overfull\Configure\Config;
use Overfull\Routing\Route;
use Bag;
use Overfull\Exception\AppNotFoundException;
use Overfull\Exception\ConfigFileNotFoundException;
use Overfull\Exception\PageNotFoundException;
use Overfull\Exception\PatternNotFoundException;
use Exception;
use Overfull\Exception\Handler\ExceptionHandler;

class Application extends BaseObject{
	private $root;
	private $namespace;

	/*
	* Construct method
	*
	* @param string appRoot : root of project
	*/
	public function __construct($appRoot = 'dev/App', $appNamespace = 'Dev\App'){
		$this->root = $appRoot;
		$this->namespace = $appNamespace;
		$this->getDirectionConfig();
	}

	/*
	* Run method
	* This method perform all of process on a transaction
	* @return object
	*/
	public function run(){
		try{
			// Get route info
			Bag::init();

			if(!file_exists(ROOT.DS.$this->root)){
				throw new AppNotFoundException($this->root);
			}

			$this->registerException();

			// Get config
			$this->getConfig();

			// Get result in route
			Bag::route()->run();

			if(Bag::route()->response){
				foreach (Bag::route()->response as $key => $value) {
					Bag::$response->{$key} = $value;
				}
			}

			// Run pattern
			Bag::pattern()->run();

			// return result
			Bag::response()->send();
		} catch(AppNotFoundException $e){
			ExceptionHandler::showExceptionObject($e);
		} catch(ConfigFileNotFoundException $e){
			ExceptionHandler::showExceptionObject($e);
		} catch(PageNotFoundException $e){
			ExceptionHandler::showExceptionObject($e);
		} catch(PatternNotFoundException $e){
			ExceptionHandler::showExceptionObject($e);
		} catch(Exception $e){
			ExceptionHandler::showExceptionObject($e);
		}
	}

	/*
	* Get config method
	* This method will be call config object and set value config to this config object.
	*/
	private function getConfig(){
		// Get config for database
		Bag::config()->set('databases', [
			ROOT.DS.'dev'.DS.'Config'.DS.'databases.php',
			ROOT.DS.$this->root.DS.'Config'.DS.'databases.php'
		], true, false);

		//Bag::config()->set('alias', ROOT.DS.$this->root.DS.'config'.DS.'alias.php', true);
		Bag::config()->set('packages', [
			ROOT.DS.'dev'.DS.'Config'.DS.'packages.php',
			ROOT.DS.$this->root.DS.'Config'.DS.'packages.php'
		], true, false);

		Bag::config()->set('core', [
			ROOT.DS.'dev'.DS.'Config'.DS.'core.php',
			ROOT.DS.$this->root.DS.'Config'.DS.'core.php'
		], true, false);

		Bag::config()->set('debug', [
			ROOT.DS.'dev'.DS.'Config'.DS.'debug.php',
			ROOT.DS.$this->root.DS.'Config'.DS.'debug.php'
		], true, false);

		Bag::config()->set('routes', [
			ROOT.DS.'dev'.DS.'Config'.DS.'routes.php',
			ROOT.DS.$this->root.DS.'Config'.DS.'routes.php'
		], true, false);

		Bag::config()->set('system', ROOT.DS.'vendor'.DS.'framework'.DS.'Overfull'.DS.'Configure'.DS.'system.php', true);
	}

	/*
	* Get config method
	* This method will be call config object and set value config to this config object.
	*/
	private function getDirectionConfig(){
		Bag::config()->set('app-config', ROOT.DS.'dev'.DS.'Config'.DS.'app.php', true);

		// Check if have config in app
		if(!empty($app = Bag::config()->get('app-config'))){
			$uri = Bag::request()->uriArray();
			$domain = Bag::request()->host();
			foreach ($app as $key => $value) {
				
				$regex = str_replace('{sub}', '([a-zA-Z0-9\-]+)', $key);
				$regex = str_replace('{domain}', '([a-zA-Z0-9\-]+)', $regex);
				$regex = str_replace('{ext}', '([a-zA-Z0-9]+)', $regex);
				$regex = str_replace('{folder}', '([a-zA-Z0-9\-]+)', $regex);

				$exRegex = explode('/', $regex);
				$base = count($exRegex) - 1;

				// Check if correct domain
				if(preg_match("/^".$exRegex[0]."$/", $domain)){
					array_shift($exRegex);
					if(count($exRegex) > 0){
						$isValid = true;
						$route = '';
						foreach ($exRegex as $index => $folder) {
							if(empty($uri[$index]) || !preg_match("/^".$folder."$/", $uri[$index])){
								$isValid = false;
								break;
							}
							$route = ($route != '') ? $route.'/'.$uri[$index] : $uri[$index];
						}

						if($isValid){
							$route = explode('/', $key);
							$this->root = $value['root'];
							$this->namespace = $value['namespace'];
							Bag::config()->set('app', [
								'root' => $this->root,
								'namespace' => $this->namespace,
								'base' => $base,
								'route' => $route
							]);
							return;
						}
					} else {
						$this->root = $value['root'];
						$this->namespace = $value['namespace'];
						Bag::config()->set('app', [
							'root' => $this->root,
							'namespace' => $this->namespace,
							'base' => $base,
							'route' => ''
						]);
						return;
					}
				}
			}
		}

		Bag::config()->set('app', [
			'root' => $this->root,
			'namespace' => $this->namespace,
			'base' => 0,
			'route' => ''
		]);
	}

	/*
	* Get config method
	* This method will be call config object and set value config to this config object.
	*/
	private function registerException(){
		// error_reporting(E_ALL);
		// ini_set('display_errors', TRUE);
		// ini_set('display_startup_errors', TRUE);

		@set_exception_handler(array('\Overfull\Exception\Handler\ExceptionHandler','exceptionHandler'));

		@set_error_handler(array('\Overfull\Exception\Handler\ExceptionHandler','errorHandler'));

		@register_shutdown_function(array('\Overfull\Exception\Handler\ExceptionHandler','shutdown'));
	}
}

?>