<?php
/*----------------------------------------------------
* Filename: UsersController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Src\Admin\Controllers;
use Src\Admin\Controllers\AdminController;
use Bag;
/**
* 
*/
class HomeController extends AdminController{
	public function index(){
		if(!Bag::package()->auth->isLogged()){
			return $this->redirect('/login.html');
		}

		return $this->render();
	}
}