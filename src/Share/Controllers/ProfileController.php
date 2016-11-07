<?php
/*----------------------------------------------------
* Filename: ProfileController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Src\Admin\Controllers;
use Src\Admin\Controllers\AdminController;
use Src\Admin\Business\UserBusiness;
use Src\Admin\Models\User;
use Bag;
/**
* 
*/
class ProfileController extends AdminController{
	private $userBusiness = null;//new UserBusiness();

	// public function __construct(UserBusiness $userBusiness){
	// 	$this->userBusiness = $userBusiness;
	// }

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