<?php
/*----------------------------------------------------
* Filename: ActionResult.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: CtrlResult between controller and view
* ----------------------------------------------------
*/
namespace Overfull\Patterns\MVC;
use Overfull\Utility\ArrayUtil;
use Bag;

class ActionResult{
	protected $data = null;
        protected $attributes = [];
        
        /**
	 * Set type to view is render
	 *
	 * @param string/array $view
	 * @param mixed $data
	 * @return array
	 */
	public final function review($name = false, $value = null){
            if(!$name){
                $this->attributes['layout'] = !empty($this->attributes['layout']) ? $this->attributes['layout'] : false;
                $this->attributes['helpers'] = !empty($this->attributes['helpers']) ? $this->attributes['helpers'] : [];
                $this->attributes['handler'] = !empty($this->attributes['handler']) ? $this->attributes['handler'] : null;
                $this->attributes['root'] = !empty($this->attributes['root']) ? $this->attributes['root'] : str_replace('Controller', '', Bag::$route->controller);
                $this->attributes['content'] = !empty($this->attributes['content']) ? $this->attributes['content'] : Bag::$route->action;
                return $this;
            }

            if(is_array($name)){
                foreach ($name as $key => $value) {
                        $this->attributes[$key] = $value;
                }

                return $this;
            }

            $this->attributes[$name] = $value;
            return $this;
	}
        
        /**
         * __construct
         * @param type $data
         */
	function __construct($data = []){
            $this->data = $data;
	}
        
        /**
         * __get attributes
         * @param type $name
         * @return type
         */
        function __get($name){
            return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
        }
        
        /**
         * __set attributes
         * @param type $name
         * @param type $value
         */
        function __set($name, $value){
            $this->attributes[$name] = $value;
        }
        
        /**
         * __call is not exists method
         * @param type $name
         * @param type $arguments
         * @return type
         */
        function __call($name, $arguments) {
            if(method_exists($this, '__'.$name)){
                return $this->{'__'.$name}($arguments);
            }
            
            return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
        }
        
        /**
         * Attributes
         * @return type
         */
        public function attributes(){
            return $this->attributes;
	}

	/**
	 * Get method
	 * @param string $name
	 * @return this
	 */
	public function get($name = ''){
            return ArrayUtil::access($this->data, $name);
	}
        
        /**
         * Set data method
         * @param type $value
         * @return $this
         */
        public function set($value){
            $this->data = $value;
            return $this;
        }
        
        /**
         * Remove data method
         * @param type $name
         * @return $this
         */
        public function remove($name){
            unset($this->data[$name]);
            return $this;
        }
        
        /**
         * Add data method
         * @param type $name
         * @param type $value
         * @return $this
         */
        public function add($name, $value){
            $this->data[$name] = $value;
            return $this;
        }

	/**
	 * Get method
	 * @param string $name
	 * @return this
	 */
	public function withLastGet(){
            if(!empty($data = Bag::request()->get())){
                if(isset($data['__key__'])){
                    Bag::store()->{"value_for_".$data['__key__']} = $data;
                } else {
                    Bag::store()->value_for_default = $data;
                }
            }

            return $this;
	}

	/**
	 * Get method
	 * @param string $name
	 * @return this
	 */
	public function withLastPost(){
            if(!empty($data = Bag::request()->post())){
                if(isset($data['__key__'])){
                    Bag::store()->{"value_for_".$data['__key__']} = $data;
                } else {
                    Bag::store()->value_for_default = $data;
                }
            }

            return $this;
	}

	/**
	 * Get method
	 * @param string $name
	 * @return this
	 */
	public function withLastData(){
            if(!empty($data = Bag::request()->any())){
                if(isset($data['__key__'])){
                    Bag::store()->{"value_for_".$data['__key__']} = $data;
                } else {
                    Bag::store()->value_for_default = $data;
                }
            }

            return $this;
	}

	/**
	 * Get method
	 * @param array $data
	 * @return this
	 */
	public function form($data = []){
            if(!is_array($data)){
                return $this;
            }

            foreach ($data as $key => $value) {
                if(is_array($value) || is_object($value)){
                    Bag::store()->{"value_for_$key"} = $value;
                }
            }

            return $this;
	}

	/**
	 * with method
	 * @param array $data
	 * @return this
	 */
	public function with($data){
            $this->data = array_merge($this->data, $data);
            return $this;
	}
}