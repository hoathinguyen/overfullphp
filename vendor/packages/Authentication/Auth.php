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

class Auth extends BasePackage{
	public function test(){
		return 100;
	}

	public function isLogged(){
		return false;
	}
}