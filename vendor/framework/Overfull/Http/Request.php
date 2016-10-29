<?php
/*___________________________________________________________________________
* The Request object class
* This object handle some business about routing. You can rewrite url mapping
* with your controller or filter ...
* ___________________________________________________________________________
*/
namespace Overfull\Http;

use Overfull\Http\Foundation\BaseRequest;

/**
* 
*/
class Request extends BaseRequest{
	/**
	* Uri method
	* This method will be return uri of request
	* @date 2016/05/21
	*
	* @return string $uri
	*/
	public function uri(){
		// Return value
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
	 * schema method
	 *
	 * @return string
	 */
	public function schema(){
		return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
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
	public function isMethod( $rqs = false ){
		if ( $rqs == false ) {
			return false;
		} else if ( is_array($rqs) ) {
			foreach ($rqs as $key => $value) {
				if ( $_SERVER['REQUEST_METHOD'] == strtoupper($value) || strtoupper($value) == 'ANY') {
					return true;
				}
			}
			return false;
		} else {
			if ( $_SERVER['REQUEST_METHOD'] == strtoupper($rqs) || strtoupper($rqs) == 'ANY') {
				return true;
			}
			return false;
		}
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
}