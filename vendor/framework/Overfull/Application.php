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
	private $appRoot;
	private $appNamespace;

	/*
	* Construct method
	*
	* @param string appRoot : root of project
	*/
	public function __construct($appRoot = 'dev\App', $appNamespace = 'Dev\App'){
		$this->appRoot = $appRoot;
		$this->appNamespace = $appNamespace;
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

			if(!file_exists(ROOT.DS.$this->appRoot)){
				throw new AppNotFoundException($this->appRoot);
			}

			$this->registerException();

			// Get config
			$this->getConfig();

			// Get result in route
			Bag::route()->merge();

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
		Config::set('databases', ROOT.DS.$this->appRoot.DS.'Config'.DS.'databases.php', true);
		//Config::set('alias', ROOT.DS.$this->appRoot.DS.'config'.DS.'alias.php', true);
		Config::set('using', ROOT.DS.$this->appRoot.DS.'Config'.DS.'using.php', true);
		Config::set('core', ROOT.DS.$this->appRoot.DS.'Config'.DS.'core.php', true);
		Config::set('debug', ROOT.DS.$this->appRoot.DS.'Config'.DS.'debug.php', true);
		Config::set('routes', ROOT.DS.$this->appRoot.DS.'Config'.DS.'routes.php', true);
		Config::set('system', ROOT.DS.'vendor'.DS.'framework'.DS.'Overfull'.DS.'Configure'.DS.'system.php', true);
	}

	/*
	* Get config method
	* This method will be call config object and set value config to this config object.
	*/
	private function getDirectionConfig(){
		Config::set('app', ROOT.DS.'dev'.DS.'Config'.DS.'app.php', true);

		// Check if have config in app
		if(!empty($app = Config::get('app'))){
			// Check if is subdomain
			$sub = explode(".",$_SERVER['HTTP_HOST']);

			// Check if have config in subdomain
			if(count($sub) == 3 && $sub[0] != 'www'){
				// Check exists setting
				if(isset($app['sub-domain'][$sub[0]])){
					$this->appRoot = $app['sub-domain'][$sub[0]]['root'];
					$this->appNamespace = $app['sub-domain'][$sub[0]]['namespace'];
					Config::set('app-config', ['app-root' => $this->appRoot,'for' => 'sub-domain', 'app-namespace' => $this->appNamespace]);
					return;
				} else if(isset($app['sub-domain']['_default'])){
					$this->appRoot = $app['sub-domain']['_default']['root'];
					$this->appNamespace = $app['sub-domain']['_default']['namespace'];
					Config::set('app-config', ['app-root' => $this->appRoot,'for' => 'sub-domain', 'app-namespace' => $this->appNamespace]);
				}
			}

			// Check exists setting in subfolder
			if(isset($app['sub-folder'])){
				$folders = explode('/', $_SERVER['REQUEST_URI']);

				if(isset($app['sub-folder'][$folders[1]])){
					$this->appRoot = $app['sub-folder'][$folders[1]]['root'];
					$this->appNamespace = $app['sub-folder'][$folders[1]]['namespace'];
					Config::set('app-config', ['app-root' => $this->appRoot,'for' => 'sub-folder', 'route-root' => $folders[1], 'app-namespace' => $this->appNamespace]);
					return;
				} else if(!Config::get('app-config')){
					if(isset($app['sub-folder']['_default'])){
						$this->appRoot =  $app['sub-folder']['_default']['root'];
						$this->appNamespace = $app['sub-folder']['_default']['namespace'];
						Config::set('app-config', ['app-root' => $this->appRoot,'for' => 'sub-folder', 'app-namespace' => $this->appNamespace]);
						return;
					}
				} else {
					return;
				}
			}
		}

		Config::set('app-config', ['app-root' => $this->appRoot,'for' => 'init', 'app-namespace' => $this->appNamespace]);
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