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
	protected static $messages = false;
    protected static $key = null;

    const FORM_NAME = '__fn';
    const CSRF_KEY = '__csrf';
    const VALUE_KEY = 'value_';
    const MESSAGE_KEY = 'message_';
    const DEFAULT_NAME = 'default';

    public static function convertFormName($name){
    	return base64_encode($name);
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
	public static function open($data = 'default', $properties = []){
        if (is_object($data)){
            $data = json_decode(json_encode($data), true);
        }

        if (is_array($data)){
            $model = !empty($data['name']) ? $data['name'] : static::DEFAULT_NAME;
            static::$data = isset($data['data']) ? $data['data'] : false;
            static::$messages = isset($data['messages']) ? $data['messages'] : false;
        } elseif(!$data){
            $model = static::DEFAULT_NAME;
        } else {
            $model = $data;
        }

        $model = static::convertFormName($model);

        if(static::$data === false){
            static::$data = Bag::store()->get($model, Form::VALUE_KEY);
        }
        if (is_object(static::$data)){
            static::$data = json_decode(json_encode(static::$data), true);
        }

        // Create message for model
        if(static::$messages === false){
            static::$messages = Bag::store()->get($model, Form::MESSAGE_KEY);
        }

        if (is_object(static::$messages)){
            static::$messages = json_decode(json_encode(static::$messages), true);
        }

        $__key__  = '';
        if(!(isset($data['name']) && !$data['name'])){
            $__key__ = static::name($model);
        }

        $__csrf  = '';
        if(!(isset($data['csrf']) && !$data['csrf'])){
            $__csrf = static::csrf($model);
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
     * name
     * @param type $model
     */
    public static function name($model){
        return static::hidden(Form::FORM_NAME, ['value' => $model]);
    }

	/**
	 * input method
	 * @return string html
	 */
	public static function input($name, $properties = []){
        if(!array_key_exists('value', $properties)){
            $properties['value'] = static::get($name);
        }

        $properties['name'] = static::parseName($name);

        $propertiesHTML = '';

        $properties['type'] = isset($properties['type']) ? $properties['type'] : 'text';

        foreach ($properties as $key => $value) {
                $propertiesHTML .= " $key=\"$value\"";
        }

        return "<input $propertiesHTML/>";
	}

	/**
	 * input method
	 * @return string html
	 */
	public static function text($name, $properties = []){
		$properties['type'] = 'text';
        return static::input($name, $properties);
	}

	/**
	 * input method
	 * @return string html
	 */
	public static function file($name, $properties = []){
		$properties['type'] = 'file';
        return static::input($name, $properties);
	}

    /**
	 * input method
	 * @return string html
	 */
	public static function checkbox($name, $properties = []){
		if(ArrayUtil::isExists(static::$data, $name)){
			if(ArrayUtil::access(static::$data, $name)){
				$properties['checked'] = 'true';
			} else {
				unset($properties['checked']);
			}
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
		if(!array_key_exists('value', $properties)){
			$properties['value'] = ArrayUtil::access(static::$data, $name);
		}elseif(ArrayUtil::access(static::$data, $name) == $properties['value']){
			$properties['checked'] = 'true';
		}else{
			unset($properties['checked']);
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
		if(!array_key_exists('value', $properties)){
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
		if(!array_key_exists('value', $properties)){
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
		if(!array_key_exists('value', $properties)){
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
		if(!array_key_exists('value', $properties)){
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

	/**
	 * Has error method
	 * @param string $name
	 * @param boolean $isArray
	 * @return boolean
	 */
	public static function hasError($name, $isArray = false){
		if(!$name){
			return !empty(static::$messages);
		}

		if($isArray){
			return ArrayUtil::access(static::$messages[$name]) != null ? true : false;
		}

		return isset(static::$messages[$name]);
	}
}
