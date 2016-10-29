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
	public function __construct($appRoot = 'dev\App', $appNamespace = 'Dev\App'){
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
		Bag::config()->set('databases', ROOT.DS.$this->root.DS.'Config'.DS.'databases.php', true);
		//Bag::config()->set('alias', ROOT.DS.$this->root.DS.'config'.DS.'alias.php', true);
		Bag::config()->set('using', ROOT.DS.$this->root.DS.'Config'.DS.'using.php', true);
		Bag::config()->set('core', ROOT.DS.$this->root.DS.'Config'.DS.'core.php', true);
		Bag::config()->set('debug', ROOT.DS.$this->root.DS.'Config'.DS.'debug.php', true);
		Bag::config()->set('routes', ROOT.DS.$this->root.DS.'Config'.DS.'routes.php', true);
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
			// Check if is subdomain
			$sub = explode(".", Bag::request()->host());

			// Check if have config in subdomain
			if(count($sub) == 3 && $sub[0] != 'www'){
				// Check exists setting
				if(isset($app['sub-domain'][$sub[0]])){
					$this->root = $app['sub-domain'][$sub[0]]['root'];
					$this->namespace = $app['sub-domain'][$sub[0]]['namespace'];
					
					Bag::config()->set('app', [
						'root' => $this->root,
						'for' => 'sub-domain',
						'namespace' => $this->namespace,
						'route' => ''
					]);
					return;
				} else if(isset($app['sub-domain']['_default'])){
					$this->root = $app['sub-domain']['_default']['root'];
					$this->namespace = $app['sub-domain']['_default']['namespace'];

					Bag::config()->set('app', [
						'root' => $this->root,
						'for' => 'sub-domain',
						'namespace' => $this->namespace,
						'route' => ''
					]);
				}
			}

			// Check exists setting in subfolder
			if(isset($app['sub-folder'])){
				$folders = Bag::request()->uriArray();

				$folderIndex = !empty($app['base']) && is_integer($app['base']) ? $app['base'] : 0;

				if(isset($app['sub-folder'][isset($folders[$folderIndex]) ? $folders[$folderIndex] : ''])){
					$this->root = $app['sub-folder'][$folders[$folderIndex]]['root'];
					$this->namespace = $app['sub-folder'][$folders[$folderIndex]]['namespace'];

					Bag::config()->set('app', [
						'root' => $this->root,
						'for' => 'sub-folder',
						'route' => $folders[$folderIndex],
						'namespace' => $this->namespace
					]);

					return;
				} else if(!Bag::config()->get('app')){
					if(isset($app['sub-folder']['_default'])){
						$this->root =  $app['sub-folder']['_default']['root'];
						$this->namespace = $app['sub-folder']['_default']['namespace'];

						Bag::config()->set('app', [
							'root' => $this->root,
							'for' => 'sub-folder',
							'namespace' => $this->namespace,
							'route' => ''
						]);

						return;
					}
				} else {
					return;
				}
			}
		}

		Bag::config()->set('app', [
			'root' => $this->root,
			'for' => 'init', 
			'namespace' => $this->namespace
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