<?php
/*----------------------------------------------------
* Filename: UsersController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Src\Share\Controllers;
use Src\Share\Controllers\ShareController;
use Bag;
/**
* 
*/
class HomeController extends ShareController{
	public function index(){
		if(!Bag::package()->auth->isLogged()){
			return $this->redirect('/login.html');
		}

		return $this->render();
	}
}