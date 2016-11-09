<?php
/*----------------------------------------------------
* Filename: ProfileController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Src\Share\Controllers;
use Src\Share\Controllers\ShareController;
use Src\Share\Business\UserBusiness;
use Bag;
/**
* 
*/
class ProfileController extends ShareController{
	private $userBusiness = null;

	public function __construct(){
		$this->userBusiness = new UserBusiness();
	}

	public function beforeAction(){
		if (Bag::package()->auth->isLogged()){
			return $this->redirect('/');
		}
	}

	/**
	 * Login method
	 *
	 * @return render
	 */
	public function login(){
		// Check if request is post
		if(Bag::request()->isMethod('post')){
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
	 * @return redirect
	 */
	public function logout(){
		Bag::package()->auth->logout();
		return $this->redirect('/login.html');
	}

	/**
	 * Profile method
	 * This method will be handle profile of username
	 * @return render
	 */
	public function profile(){
		return $this->render(false, ['user' => Bag::package()->auth->load()]);
	}
}