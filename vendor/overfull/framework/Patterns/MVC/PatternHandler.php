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
        $this->controller->init();
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

            $filter = new $filter();
            $dataTransfer = $filter->run($this->controller);
        }
        else
        {
            $dataTransfer = $this->controller->run();
        }
        
        if(!is_object($dataTransfer)){
            if(is_array($dataTransfer))
            {
                $dataTransfer = json_encode($dataTransfer);
            }
            
            Bag::$response->content = (string)$dataTransfer;
            return;
        }
        elseif(!empty($view = $dataTransfer->handler)){
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

        $this->view->run($dataTransfer);
    }
}
