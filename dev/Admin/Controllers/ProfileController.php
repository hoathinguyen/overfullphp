<?php
/*----------------------------------------------------
* Filename: ProfileController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Dev\Admin\Controllers;
use Dev\Admin\Controllers\AdminController;
use Bag;
/**
* 
*/
class ProfileController extends AdminController{
	/**
	 * Login method
	 *
	 * @return render
	 */
	public function login(){
		if (Bag::package()->auth->isLogged()){
			return $this->redirect('/');
		}

		// Check if request is post
		if(Bag::request()->isMethod('post')){
			//$data = Bag::request()->post();

			if(Bag::package()->auth->login()){
				return $this->redirect('/');
			} else {
				return $this->render(false, ['msg' => 'Username or password is incorrect!']);
			}
		}
		
		// Return render if have no logged
		return $this->render();
	}

	/**
	 * logout method
	 *
	 * @return render
	 */
	public function logout(){
		Bag::package()->auth->logout();
		return $this->redirect('/login.html');
	}
}