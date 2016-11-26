<?php
/*----------------------------------------------------
* Filename: Form.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Form helper
* ----------------------------------------------------
*/
namespace Overfull\Template\Helpers;
use Bag;
use Overfull\Utility\ArrayUtil;
use Overfull\Template\Foundation\Helper;

class Form extends Helper{
	protected static $data = false;
	protected static $messages = [];
        protected static $key = null;

        const MODEL_KEY = '__key__';
        const CSRF_KEY = '__csrf__';
        const VALUE_KEY = 'value_';
        const MESSAGE_KEY = 'message_';
        
        /**
         * generateModelKey
         * @param type $model
         * @return type
         */
        public static function generateModelKey($model){
            return base64_encode($model.'_overfull.net');
        }
        
	/**
	 * Parse name to name in HTML
	 * @param $name
	 */
	protected static function parseName($name){
		$exs = explode('.', $name);

		$name = $exs[0];
		array_shift($exs);

		foreach ($exs as $value) {
			$name .= "[$value]";
		}

		return $name;
	}

	/**
	 * Open method
	 * @param array config
	 * @return form open
	 */
	public static function open($data = 'default', $properties = [], $messages = []){
            if (is_array($data)){
                $model = isset($data['model']) ? $data['model'] : 'default';
                static::$data = isset($data['data']) ? $data['data'] : false;
            }elseif (is_object($data)){
                $model = 'default';
                static::$data = json_decode(json_encode($data), true);
            }elseif(!$data){
                $model = 'default';
            } else {
                $model = $data;
            }

            // Create open form and get model data
            $model = static::generateModelKey($model);
            
            
            if(static::$data === false){
                static::$data = Bag::store()->{Form::VALUE_KEY.$model};

                if (is_object(static::$data)){
                    static::$data = json_decode(json_encode(static::$data), true);
                }
            }
            
            $__key__  = '';
            if(!(isset($data['modelKey']) && !$data['modelKey'])){
                $__key__ = static::modelKey($model);
            }
            
            $__csrf  = '';
            if(!(isset($data['csrf']) && !$data['csrf'])){
                $__csrf = static::csrf($model);
            }

            // Create message for model
            if(!empty($messages)){
                    static::$messages = $messages;
            } else{
                static::$messages = Bag::store()->{Form::MESSAGE_KEY.$model};
            }

            if (is_object(static::$messages)){
                    static::$messages = json_decode(json_encode(static::$messages), true);
            }

            // Generate html
            $propertiesHTML = '';

            foreach ($properties as $key => $value) {
                    $propertiesHTML .= " $key=\"$value\"";
            }

            return '<form method="'. (isset($properties['method']) ? $properties['method'] : 'POST') .'" '.$propertiesHTML.'>' . $__key__.$__csrf;
            // object-save="'.$model.'"
	}
        
	/**
	 * Close method
	 * @return string html
	 */
	public static function close(){
		static::$data = false;
		static::$messages = [];
		return '</form>';
	}

	/**
	 * input method
	 * @return string html
	 */
	public static function get($name = false){
		if(!$name){
			return static::$data;
		}

		return ArrayUtil::access(static::$data, $name);
	}
        
        /**
         * Get key of csrf
         * return string
         */
        public static function csrf($model = 'default'){
            return static::hidden(Form::CSRF_KEY, ['value' => base64_encode($model)]);
        }
        
        /**
         * modelKey
         * @param type $model
         */
        public static function modelKey($model){
            return static::hidden(Form::MODEL_KEY, ['value' => $model]);
        }
        
	/**
	 * input method
	 * @return string html
	 */
	public static function input($name, $properties = []){
            if(!isset($properties['value'])){
                $properties['value'] = ArrayUtil::access(static::$data, $name);
            }

            $properties['name'] = static::parseName($name);

            $propertiesHTML = '';

            $properties['type'] = 'text';

            foreach ($properties as $key => $value) {
                    $propertiesHTML .= " $key=\"$value\"";
            }

            return "<input $propertiesHTML/>";
	}
        
        /**
	 * input method
	 * @return string html
	 */
	public static function checkbox($name, $properties = []){
		if(!isset($properties['value'])){
			$properties['value'] = ArrayUtil::access(static::$data, $name);
		}

		$properties['name'] = static::parseName($name);

		$propertiesHTML = '';
                
                $properties['type'] = 'checkbox';

		foreach ($properties as $key => $value) {
			$propertiesHTML .= " $key=\"$value\"";
		}

		return "<input $propertiesHTML/>";
	}
        
        /**
	 * input method
	 * @return string html
	 */
	public static function radio($name, $properties = []){
		if(!isset($properties['value'])){
			$properties['value'] = ArrayUtil::access(static::$data, $name);
		}

		$properties['name'] = static::parseName($name);

		$propertiesHTML = '';
                
                $properties['type'] = 'radio';

		foreach ($properties as $key => $value) {
			$propertiesHTML .= " $key=\"$value\"";
		}

		return "<input $propertiesHTML/>";
	}

	/**
	 * textarea method
	 * @return string html
	 */
	public static function textarea($name, $properties = []){
		if(!isset($properties['value'])){
			$value = ArrayUtil::access(static::$data, $name);
		} else {
			$value = $properties['value'];
		}
		
		$properties['name'] = static::parseName($name);

		$propertiesHTML = '';

		foreach ($properties as $key => $val) {
			$propertiesHTML .= " $key=\"$val\"";
		}

		return "<textarea $propertiesHTML>$value</textarea>";
	}

	/**
	 * select method
	 * @return string html
	 */
	public static function select($name, $options = [], $properties = []){
		if(!isset($properties['value'])){
			$properties['value'] = ArrayUtil::access(static::$data, $name);
		}

		$properties['name'] = static::parseName($name);

		$strproperties = '';

		foreach ($properties as $key => $value) {
			$strproperties .= " $key=\"$value\"";
		}

		$optionsHTML = '';
		foreach ($options as $key => $value) {
			$optionsHTML .= '<option value="'.$key.'" '.($properties['value'] == $key ? 'selected' : '').'>'.$value.'</option>';
		}

		return "<select $strproperties>$optionsHTML</select>";
	}

	/**
	 * submit method
	 * @return string html
	 */
	public static function submit($name, $properties = []){
		$value = isset($properties['value']) ? $properties['value'] : $name;
		unset($properties['value']);

		$propertiesHTML = '';
		$properties['type'] = 'submit';

		foreach ($properties as $key => $val) {
			$propertiesHTML .= " $key=\"$val\"";
		}

		return "<button $propertiesHTML>$value</button>";
	}

	/**
	 * hidden method
	 * @return string html
	 */
	public static function hidden($name, $properties = []){
		if(!isset($properties['value'])){
			$properties['value'] = ArrayUtil::access(static::$data, $name);
		}

		$properties['name'] = static::parseName($name);
		$properties['type'] = 'hidden';

		$propertiesHTML = '';

		foreach ($properties as $key => $value) {
			$propertiesHTML .= " $key=\"$value\"";
		}

		return "<input $propertiesHTML/>";
	}

	/**
	 * password method
	 * @return string html
	 */
	public static function password($name, $properties = []){
		if(!isset($properties['value'])){
			$properties['value'] = ArrayUtil::access(static::$data, $name);
		}

		$properties['name'] = static::parseName($name);
		$properties['type'] = 'password';

		$propertiesHTML = '';

		foreach ($properties as $key => $value) {
			$propertiesHTML .= " $key=\"$value\"";
		}

		return "<input $propertiesHTML/>";
	}
	/**
	 * message method
	 * @return string
	 */
	public static function message($name = null, $isArray = false){
		if(!$name){
			return static::$messages;
		}

		if($isArray){
			return ArrayUtil::access(static::$messages[$name]);
		}

		return isset(static::$messages[$name]) ? static::$messages[$name] : null;
	}
}