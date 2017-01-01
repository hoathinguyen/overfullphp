<?php
/*----------------------------------------------------
* The PatternHandler object class
* This object is main of Pattern.
* This object will be handle the way to run application
* ----------------------------------------------------
*/
namespace Overfull\Patterns\MVC;

use Overfull\Foundation\Base\BaseObject;
use Bag;
use Overfull\Patterns\MVC\Exception\ControllerNotFoundException;
use Overfull\Patterns\MVC\Exception\ViewNotFoundException;
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
        $controller = Bag::route()->controller;
        if(!class_exists($controller)){
            $controller = "{$appNamespace}\\Controllers\\{$controller}";
            if(!class_exists($controller)){
                    throw new ControllerNotFoundException($controller);
            }
        }

        $this->controller = new $controller();
        // Filter
        // Call method beforeFilter
        $this->controller->beforeFilter();
        $filter = Bag::route()->filter;

        if($filter){
            // Check filter
            if(!class_exists($filter)){
                $filter = "{$appNamespace}\\Filters\\{$filter}";
                if(!class_exists($filter)){
                    throw new \Overfull\Patterns\MVC\Exception\FilterNotFoundException($filter);
                }
            }
        }

        // Call view
        $dataTransfer = $this->controller->run();
        if(!empty($view = $dataTransfer->handler)){
            if(!class_exists($view)){
                $view = "{$appNamespace}\\Views\\{$view}";
                if(!class_exists($view)){
                    throw new ViewNotFoundException($view);
                }
            }

            $this->view = new $view();
        }elseif($view = Bag::route()->view){
            if(!class_exists($view)){
                $view = "{$appNamespace}\\Views\\{$view}";
                if(!class_exists($view)){
                        throw new ViewNotFoundException($view);
                }
            }

            $this->view = new $view();
        } else {
            $this->view = new \Overfull\Patterns\MVC\View();
        }

        // switch (Bag::$response->format) {
        // 	case ResponseFormat::HTML:
        // 		$viewResult = 'test';
        // 		break;
        // 	case ResponseFormat::JSON:
        // 	default:
        // 		break;
        // }

        Bag::$response->content = $this->view->run($dataTransfer);
    }
}
