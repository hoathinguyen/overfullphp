<?php
/*----------------------------------------------------
* Filename: ProfileController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Dev\Account\Controllers;
use Overfull\Pattern\MVC\Controller;
use Bag;
/**
* 
*/
class ProfileController extends Controller{
	protected $otp = [
		'layout' => 'home'
	];

	/**
	 * Login
	 *
	 */
	public function login(){
		// Check if request is post
		if(Bag::request()->isMethod('post')){

		}

		return $this->render();
	}
}