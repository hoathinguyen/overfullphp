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
		// Check if request is post
		if(Bag::request()->isMethod('post')){
			
		}
		// Return render if have no logged
		return $this->render();
	}
}