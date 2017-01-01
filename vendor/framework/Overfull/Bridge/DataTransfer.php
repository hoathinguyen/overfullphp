<?php
/*----------------------------------------------------
* Filename: DataTransfer.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: CtrlResult between controller and view
* ----------------------------------------------------
*/
namespace Overfull\Bridge;
use Overfull\Utility\ArrayUtil;
use Bag;
use Overfull\Template\Helpers\Form;

class DataTransfer{
	protected $data = null;
        protected $attributes = [];

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
         * Determine if an attribute exists on the model.
         *
         * @param  string  $key
         * @return bool
         */
        public function __isset($key){
            return isset($this->attributes[$key]);
        }

        /**
         * Unset an attribute on the model.
         *
         * @param  string  $key
         * @return void
         */
        public function __unset($key){
            unset($this->attributes[$key]);
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

            if(count($arguments) == 0){
                return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
            }

            if(count($arguments) == 1){
                $this->attributes[$name] = $arguments[0];
            } else {
                $this->attributes[$name] = $arguments;
            }

            return $this;
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
                if(isset($data[Form::MODEL_KEY])){
                    Bag::store()->{Form::VALUE_KEY.$data[Form::MODEL_KEY]} = $data;
                } else {
                    Bag::store()->{Form::VALUE_KEY.Form::generateModelKey('default')} = $data;
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
                if(isset($data[Form::MODEL_KEY])){
                    Bag::store()->{Form::VALUE_KEY.$data[Form::MODEL_KEY]} = $data;
                } else {
                    Bag::store()->{Form::VALUE_KEY.Form::generateModelKey('default')} = $data;
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
                if(isset($data[Form::MODEL_KEY])){
                    Bag::store()->{Form::VALUE_KEY.$data[Form::MODEL_KEY]} = $data;
                } else {
                    Bag::store()->{Form::VALUE_KEY.Form::generateModelKey('default')} = $data;
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
                    Bag::store()->{Form::VALUE_KEY.Form::generateModelKey($key)} = $value;
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
