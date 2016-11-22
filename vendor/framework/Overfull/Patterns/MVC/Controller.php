<?php
/*___________________________________________________________________________
* The Controller object class
* ___________________________________________________________________________
*/
namespace Overfull\Patterns\MVC;

use Overfull\Patterns\MVC\Foundation\IController;
use Overfull\Patterns\MVC\Exception\MethodNotFoundException;
use Bag;
use Overfull\Http\Response\ResponseFormat;
use Overfull\Patterns\MVC\ActionResult;
use Overfull\Foundation\Base\BaseObject;

abstract class Controller extends BaseObject implements IController{
        protected $actionResult = null;

        public function beforeAction(){}
	public function beforeFilter(){}
	public function beforeRender(){}
        
        /**
         * set helpers
         * @param type $name
         * @param type $data
         */
        protected final function helpers($name, $data = []){
            if(is_string($name)){
                $helpers = $this->actionResult->helpers;
                $helpers[$name] = $data;
                $this->actionResult->helpers = $helpers;
            }
            
            $this->actionResult->helpers = $name;
            return $this;
        }
        
        /**
         * layout
         * @param type $name
         */
        protected final function layout($name){
            $this->actionResult->layout = $name;
            return $this;
        }
        
        /**
         * set helpers
         * @param type $name
         * @param type $data
         */
        protected final function root($name){
            $this->actionResult->root = $name;
            return $this;
        }
        
        /**
         * handler
         * @param type $name
         */
        protected final function handler($name){
            if(is_object($name)){
                $this->actionResult->handler = $name;
                return $this;
            }
        }
        
        /**
         * actionResult
         * @param type $name
         */
        protected final function actionResult($name = false){
            if(!$name){
                return $this->actionResult;
            }
            
            if(is_object($name)){
                $this->actionResult = $name;
                return $this;
            }
        }

	/**
	 * Set type to view is render
	 *
	 * @param string/array $view
	 * @param mixed $data
	 * @return array
	 */
	protected final function render($view = false, $data = []){
            if(is_array($view)){
                $this->actionResult->layout = $view[0];
                $this->actionResult->content = $view[1];
            } else if($view){
                $this->actionResult->content = $view;
            }
                
            $this->actionResult->type = 'render';
            $this->actionResult->set($data);

            return $this->actionResult;
	}

	/**
	 * Set type to view is renderAjax
	 *
	 * @param string/array $view
	 * @param mixed $data
	 * @return array
	 */
	protected final function renderAjax($view = false, $data = []){
            $this->actionResult->layout = false;

            if($view){
                $this->actionResult->content = $view;
            }
            
            $this->actionResult->type = 'render';
            
            $this->actionResult->set($data);
            
            return $this->actionResult;
	}

	/**
	 * Set type to view is redirect
	 *
	 * @param string $url
	 * @return array
	 */
	protected final function redirect($url){
            $this->actionResult->type = 'redirect';
            
            $this->actionResult->set($url);
            
            return $this->actionResult;
	}

	/**
	 * Set type to view is json
	 *
	 * @param mixed $data
	 * @return array
	 */
	protected final function json($data){
            $this->actionResult->type = 'json';
            
            $this->actionResult->set($data);
            
            return $this->actionResult;
	}
	
	/**
	 * Run controller
	 *
	 * @return void
	 */
	public final function run(){
            $method = Bag::route()->action;
            $__method = 'action'.ucfirst($method);
            
            if(!method_exists($this, $__method)){
                    throw new MethodNotFoundException($__method);
            }

            $this->actionResult = new ActionResult();

            // Event before
            $this->beforeFilter();

            // Get filter before

            $this->beforeAction();

            $actionResult = $this->{$__method}(Bag::route()->parameters);

            $this->beforeRender();

            if (is_a($actionResult, ActionResult::class)){
                $actionResult->review();
                return $actionResult;
            } elseif(is_array($actionResult)){
                $this->actionResult->review();
                $this->actionResult->type = 'json';
                $this->actionResult->set($ActionResult);
                return $this->actionResult;
            } elseif(is_object($ActionResult)){
                $this->actionResult->review();
                $ActionResult->run($this->actionResult);
                return $this->actionResult;
            } else{
                $this->actionResult->review();
                $this->actionResult->type = 'html';
                $this->actionResult->set($ActionResult);
                return $this->actionResult;
            }
	}
}