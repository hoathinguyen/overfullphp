<?php
/*----------------------------------------------------
* Filename: Auth.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Authentication package
* ----------------------------------------------------
*/
namespace Packages\Authentication;
use Overfull\Package\BasePackage;
use Bag;

class Auth extends BasePackage{
	public function test(){
		return 100;
	}

	/**
	 * Is logged method
	 * @return boolean
	 */
	public function isLogged(){
		return Bag::session()->check($this->session);
	}

	/**
	 * Login method
	 * @param array $data
	 */
	public function login($data){
		Bag::session()->write($this->session, $data);
		return true;
	}

	/**
	 * Login method
	 * @param array $data
	 */
	public function logout(){
		Bag::session()->delete($this->session);
	}
}