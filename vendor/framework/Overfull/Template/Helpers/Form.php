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
	public static function open($model = 'default', $properties = [], $messages = []){
		if(!$model){
			$model = 'default';
		}

		// Create open form and get model data
		$__key__ = '';
		if(is_string($model)){
			static::$data = Bag::store()->{"value_for_$model"};

			if (is_object(static::$data)){
				static::$data = json_decode(json_encode(static::$data), true);
			}
			$__key__ = "<input name=\"__key__\" value=\"$model\" type=\"hidden\"/>";
		} elseif (is_object($model)){
			static::$data = json_decode(json_encode($model), true);
		}

		// Create message for model
		if(!empty($messages)){
			static::$messages = $messages;
		} elseif(is_string($model)){
			static::$messages = Bag::store()->{"message_for_$model"};
		}

		if (is_object(static::$messages)){
			static::$messages = json_decode(json_encode(static::$messages), true);
		}

		// Generate html
		$propertiesHTML = '';

		foreach ($properties as $key => $value) {
			$propertiesHTML .= " $key=\"$value\"";
		}

		return '<form method="'. (isset($properties['method']) ? $properties['method'] : 'POST') .'" '.$propertiesHTML.'>' . $__key__;
		// object-save="'.$model.'"
	}

	/**
	 * Open method
	 * @param array config
	 * @return form open
	 */
	// public static function open($model = 'default', $properties = [], $messages = []){
	// 	if(!$model){
	// 		$model = 'default';
	// 	}

	// 	// Create message for model
	// 	if(!empty($messages)){
	// 		static::$messages = $messages;
	// 	} else {
	// 		static::$messages = Bag::store()->{"message_for_$model"};
	// 	}

	// 	if (is_object(static::$messages)){
	// 		static::$messages = json_decode(json_encode(static::$messages), true);
	// 	}

	// 	// Generate html
	// 	$propertiesHTML = '';

	// 	$properties['method'] = isset($properties['method']) ? $properties['method'] : 'POST';

	// 	$__key__ = '';
	// 	if(strtoupper($properties['method']) == 'GET'){
	// 		if(empty($properties['action'])){
	// 			$properties['action'] = '?__key__='.$model;
	// 		} else {
	// 			$action = explode('#', $properties['action']);
	// 			// Create open form and get model data
	// 			if (strpos($action[0], '?') !== false) {
	// 				if ( substr($action[0], 0, 1) != '?') {
	// 					$action[0] .= '&__key__='.$model;
	// 				} else {
	// 					$action[0] .= '__key__='.$model;
	// 				}
	// 			}else{
	// 				$action[0] .= '?'.$model;
	// 			}

	// 			$properties['action'] = implode('#', $action);
	// 		}
	// 	} else {
	// 		if(is_string($model)){
	// 			static::$data = Bag::store()->{"value_for_$model"};

	// 			if (is_object(static::$data)){
	// 				static::$data = json_decode(json_encode(static::$data), true);
	// 			}
	// 			$__key__ = "<input name=\"__key__\" value=\"$model\" type=\"hidden\"/>";
	// 		} elseif (is_object($model)){
	// 			static::$data = json_decode(json_encode($model), true);
	// 		}
	// 	}

	// 	foreach ($properties as $key => $value) {
	// 		$propertiesHTML .= " $key=\"$value\"";
	// 	}

	// 	return '<form '.$propertiesHTML.'>' . $__key__;
	// 	// object-save="'.$model.'"
	// }


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
	 * input method
	 * @return string html
	 */
	public static function input($name, $properties = []){
		if(!isset($properties['value'])){
			$properties['value'] = ArrayUtil::access(static::$data, $name);
		}

		$properties['name'] = static::parseName($name);

		$propertiesHTML = '';

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