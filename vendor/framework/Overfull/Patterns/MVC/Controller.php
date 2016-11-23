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
use Overfull\Patterns\MVC\DataTransfer;
use Overfull\Foundation\Base\BaseObject;

abstract class Controller extends BaseObject implements IController{
        protected $dataTransfer = null;

        public function beforeAction(){}
	public function beforeFilter(){}
	public function beforeRender(){}
        
        /**
	 * Set type to view is render
	 *
	 * @param string/array $view
	 * @param mixed $data
	 * @return array
	 */
	public final function defaultDataTransfer($name = false, $value = null){
            if(!$name){
                $this->dataTransfer->layout = !empty($this->dataTransfer->layout) ? $this->dataTransfer->layout : false;
                $this->dataTransfer->helpers = !empty($this->dataTransfer->helpers) ? $this->dataTransfer->helpers : [];
                $this->dataTransfer->handler = !empty($this->dataTransfer->handler) ? $this->dataTransfer->handler : null;
                $this->dataTransfer->root = !empty($this->dataTransfer->root) ? $this->dataTransfer->root : str_replace('Controller', '', Bag::$route->controller);
                $this->dataTransfer->content = !empty($this->dataTransfer->content) ? $this->dataTransfer->content : Bag::$route->action;
                return $this;
            }

            if(is_array($name)){
                foreach ($name as $key => $value) {
                    $this->dataTransfer->$key = $value;
                }

                return $this;
            }

            $this->dataTransfer->$name = $value;
            return $this;
	}
        
        /**
         * set helpers
         * @param type $name
         * @param type $data
         */
        protected final function helpers($name, $data = []){
            if(is_string($name)){
                $helpers = $this->dataTransfer->helpers;
                $helpers[$name] = $data;
                $this->dataTransfer->helpers = $helpers;
            }
            
            $this->dataTransfer->helpers = $name;
            return $this;
        }
        
        /**
         * layout
         * @param type $name
         */
        protected final function layout($name){
            $this->dataTransfer->layout = $name;
            return $this;
        }
        
        /**
         * set helpers
         * @param type $name
         * @param type $data
         */
        protected final function root($name){
            $this->dataTransfer->root = $name;
            return $this;
        }
        
        /**
         * handler
         * @param type $name
         */
        protected final function handler($name){
            if(is_object($name)){
                $this->dataTransfer->handler = $name;
                return $this;
            }
        }
        
        /**
         * dataTransfer
         * @param type $name
         */
        protected final function dataTransfer($name = false){
            if(!$name){
                return $this->dataTransfer;
            }
            
            if(is_object($name)){
                $this->dataTransfer = $name;
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
            $this->defaultDataTransfer();
            if(is_array($view)){
                $this->dataTransfer->layout = $view[0];
                $this->dataTransfer->content = $view[1];
            } else if($view){
                $this->dataTransfer->content = $view;
            }
                
            $this->dataTransfer->type = 'render';
            $this->dataTransfer->set($data);

            return $this->dataTransfer;
	}

	/**
	 * Set type to view is renderAjax
	 *
	 * @param string/array $view
	 * @param mixed $data
	 * @return array
	 */
	protected final function renderAjax($view = false, $data = []){
            $this->defaultDataTransfer();
            $this->dataTransfer->layout = false;

            if($view){
                $this->dataTransfer->content = $view;
            }
            
            $this->dataTransfer->type = 'render';
            
            $this->dataTransfer->set($data);
            
            return $this->dataTransfer;
	}

	/**
	 * Set type to view is redirect
	 *
	 * @param string $url
	 * @return array
	 */
	protected final function redirect($url){
            $this->defaultDataTransfer();
            $this->dataTransfer->type = 'redirect';
            
            $this->dataTransfer->set($url);
            
            return $this->dataTransfer;
	}

	/**
	 * Set type to view is json
	 *
	 * @param mixed $data
	 * @return array
	 */
	protected final function json($data){
            $this->defaultDataTransfer();
            $this->dataTransfer->type = 'json';
            
            $this->dataTransfer->set($data);
            
            return $this->dataTransfer;
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

            $this->dataTransfer = new DataTransfer();

            // Event before
            $this->beforeFilter();

            // Get filter before

            $this->beforeAction();

            $dataTransfer = $this->{$__method}(Bag::route()->parameters);

            $this->beforeRender();

            if (is_a($dataTransfer, DataTransfer::class)){
                //$dataTransfer->review();
                return $dataTransfer;
            } elseif(is_array($dataTransfer)){
                //$this->dataTransfer->review();
                $this->defaultDataTransfer();
                $this->dataTransfer->type = 'json';
                $this->dataTransfer->set($dataTransfer);
                return $this->dataTransfer;
            } elseif(is_object($dataTransfer)){
                //$this->dataTransfer->review();
                $this->defaultDataTransfer();
                $dataTransfer->run($this->dataTransfer);
                return $this->dataTransfer;
            } else{
                //$this->dataTransfer->review();
                $this->defaultDataTransfer();
                $this->dataTransfer->type = 'html';
                $this->dataTransfer->set($dataTransfer);
                return $this->dataTransfer;
            }
	}
}