<?php
/*___________________________________________________________________________
* The Request object class
* This object handle some business about routing. You can rewrite url mapping
* with your controller or filter ...
* ___________________________________________________________________________
*/
namespace Overfull\Http;

use Overfull\Http\Foundation\BaseResponse;
use Overfull\Http\Response\ResponseFormat;

class Response extends BaseResponse{
	protected $__attributes = [
		'format' => ResponseFormat::HTML,
		'content' => ''
	];

	/**
	* Set method
	* This method will handle when set data for this response object
	* @date 2016/05/21
	*/
	public function __set($name, $value){
		$this->__attributes[$name] = $value;
	}

	/**
	* Get method. Return exist value of attributes
	* @date 2016/05/21
	*/
	public function __get($name){
		return isset($this->__attributes[$name]) ? $this->__attributes[$name] : null;
	}

	/**
	* Get method
	* @date 2016/05/21
	*/
	public function send(){
		$this->header('Content-Type', $this->__attributes['format']);
		echo $this->__attributes['content'];
	}

	/**
	* Set value for header
	* @date 2016/05/21
	*/
	public function header($name, $value){
		header("$name: $value");
	}
}