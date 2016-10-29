<?php
/*----------------------------------------------------
* The PatternHandler object class
* This object is main of Pattern.
* This object will be handle the way to run application
* ----------------------------------------------------
*/
namespace Overfull\Pattern\MVC;

use Overfull\Foundation\Base\BaseObject;
use Bag;
use Overfull\Pattern\MVC\Exception\ControllerNotFoundException;
use Overfull\Pattern\MVC\Exception\ViewNotFoundException;
use Overfull\Http\Response\ResponseFormat;

class PatternHandler extends BaseObject{

	public $controller = null;

	public $view = null;

	/**
	 * Run Pattern
	 *
	 * @return void
	 */
	public function run(){
		// Get app root
		$appNamespace = Bag::config()->get('app.namespace');

		// Get controller name
		$controller = Bag::$route->controller;
		if(!class_exists($controller)){
			$controller = $appNamespace.DS.'controllers'.DS.$controller;
			if(!class_exists($controller)){
				throw new ControllerNotFoundException($controller);
			}
		}

		$this->controller = new $controller();

		// Call view
		$controllerData = $this->controller->run();
		if(!empty($controllerData['data']['otp']['handler'])){
			$view = $controllerData['data']['otp']['handler'];

			if(!class_exists($view)){
				$view = $appNamespace.DS.'views'.DS.$view;
				if(!class_exists($view)){
					throw new ViewNotFoundException($view);	
				}
			}
			
			$this->view = new $view();
		}elseif(Bag::$route->view){
			$view = Bag::$route->view;

			if(!class_exists($view)){
				$view = $appRoot.DS.'views'.DS.$view;
				if(!class_exists($view)){
					throw new ViewNotFoundException($view);	
				}
			}
			
			$this->view = new $view();
		} else {
			$this->view = new \Overfull\Pattern\MVC\View();
		}

		// switch (Bag::$response->format) {
		// 	case ResponseFormat::HTML:
		// 		$viewResult = 'test';
		// 		break;
		// 	case ResponseFormat::JSON:
		// 	default:
		// 		break;
		// }

		Bag::$response->content = $this->view->run($controllerData);
	}
}