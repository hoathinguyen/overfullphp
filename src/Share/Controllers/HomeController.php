<?php
/*----------------------------------------------------
* Filename: HomeController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Src\Share\Controllers;
use Src\Share\Controllers\ShareController;

class HomeController extends ShareController{
	public function index(){
		return $this->render();
	}
}