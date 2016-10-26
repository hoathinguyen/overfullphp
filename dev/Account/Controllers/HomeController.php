<?php
/*----------------------------------------------------
* Filename: UsersController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Dev\Account\Controllers;
use Overfull\Pattern\MVC\Controller;

/**
* 
*/
class HomeController extends Controller{
	protected $otp = [
		'layout' => 'home'
	];
	
	public function index(){
		return $this->render();
	}
}