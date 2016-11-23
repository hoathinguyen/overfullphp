<?php
/*----------------------------------------------------
* Filename: Request.php
* Author: Overfull.net
* Date: 2016/05/20
* Description: The Request object class
* ----------------------------------------------------
*/
namespace Overfull\Http;

use Overfull\Http\Foundation\BaseRequest;
use Overfull\Utility\ArrayUtil;

class Request extends BaseRequest{
	public function full(){
		return $this->protocol(true).$this->host().$this->uri();
	}
	/**
	* Uri method
	* This method will be return uri of request
	* @date 2016/05/21
	*
	* @return string $uri
	*/
	public function uri(){
		return $_SERVER['REQUEST_URI'];
	}

	/**
	 * host method
	 *
	 * @return string
	 */
	public function host(){
		return $_SERVER['HTTP_HOST'];
	}

	/**
	 * port method
	 *
	 * @return string
	 */
	public function port(){
		return $_SERVER['SERVER_PORT'];
	}

	/**
	 * name method
	 *
	 * @return string
	 */
	public function name(){
		return $_SERVER['SERVER_NAME'];
	}

	/**
	 * docRoot method
	 *
	 * @return string
	 */
	public function docRoot(){
		return $_SERVER['DOCUMENT_ROOT'];
	}

	/**
	 * schema method
	 *
	 * @return string
	 */
	public function protocol($asPath = false){
		if($asPath){
			return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		}

		return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
	}
        
        /**
         * Get client ip method
         * @return string
         */
        public function clientIP(){
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
               $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }
        
	/**
	* UriArray method
	* This method will be return uri of request
	* @date 2016/05/21
	*
	* @return string $uri
	*/
	public function uriArray(){
		// Return value
		$uris = explode('/', $this->uri());
		array_shift($uris);
		
		$uris = array_filter($uris, function($value) { return $value ? true : false; });

		return array_filter($uris);
	}

	/**
	 * Is method
	 *
	 * @date 2016/02/27
	 * @return boolean
	 */
	public function is( $rqs = false ){
		if ( $rqs == false ) {
			return false;
		} else if ( is_array($rqs) ) {
			foreach ($rqs as $key => $value) {
				if ( $this->method() == strtoupper($value) || strtoupper($value) == 'ANY') {
					return true;
				}
			}
			return false;
		} else {
			if ( $this->method() == strtoupper($rqs) || strtoupper($rqs) == 'ANY') {
				return true;
			}
			return false;
		}
	}

	/**
	 * Check if request is from ajax
	 *
	 * @param string/array method
	 * @return boolean
	 */
	public function isPost(){
		return $this->is('POST');
	}

	/**
	 * Check if request is from ajax
	 *
	 * @param string/array method
	 * @return boolean
	 */
	public function isGet(){
		return $this->is('GET');
	}

	/**
	 * Check if request is from ajax
	 *
	 * @param string/array method
	 * @return boolean
	 */
	public function isAjax($method = false){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			// If do not need check method, so return true
			if(!$method){
				return true;
			}

			// Call check method
			return $this->is($method);
		}

		return false;
	}

	/**
	 * method
	 *
	 * @author ToiTL
	 * @date 2016/02/27
	 * @return boolean
	 */
	public function method(){
		return  $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * subdomain method
	 *
	 * @author ToiTL
	 * @date 2016/02/27
	 * @return string
	 */
	public function subdomain(){
		$sub = explode(".",$_SERVER['HTTP_HOST']);

		if(count($sub) == 3 && $sub[0] != 'www'){
			// Check exists setting
			return $sub[0];
		}

		return null;
	}

	/**
	 * publicPath method
	 *
	 * @author ToiTL
	 * @date 2016/02/27
	 * @return string
	 */
	public function publicPath(){
		return str_replace(
			'\\',
			'/',
			substr(
				dirname(dirname(dirname(dirname(dirname(__FILE__))))),
				strlen($this->docRoot())
			)
		);
	}

	/**
	 * Get method
	 *
	 * @date 2016/02/27
	 * @param string $name
	 * @return string
	 */
	public function baseUrl(){
		return $this->protocol(true).$this->host();
	}

	/**
	 * Get method
	 *
	 * @date 2016/02/27
	 * @param string $name
	 * @return string
	 */
	public function root(){
		return $this->protocol(true).$this->host().$this->publicPath();
	}

	/**
	 * Get method
	 *
	 * @date 2016/02/27
	 * @param string $name
	 * @return string
	 */
	public function get($name = false){
		if(!$name) return $_GET;
		return ArrayUtil::access($_GET, $name);
	}

	/**
	 * post method
	 *
	 * @date 2016/02/27
	 * @param string $name
	 * @return string
	 */
	public function post($name = false){
		if(!$name) return $_POST;
		return ArrayUtil::access($_POST, $name);
	}
	/**
	 * any method
	 *
	 * @date 2016/02/27
	 * @param string $name
	 * @return string
	 */
	public function any($name = false){
		if($this->is("POST")){
			return $this->post($name);
		}
		
		return $this->get($name);
	}
}