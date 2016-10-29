<?php
/*----------------------------------------------------
* Filename: UsersController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Dev\Home\Controllers;
use Overfull\Pattern\MVC\Controller;
use Bag;
/**
* 
*/
class DocsController extends Controller{
	protected $otp = [
		'layout' => 'home'
	];
	
	public function index(){
		return $this->render();
		//echo \Overfull\Utility\URLUtil::asset('/css/test.css');
	}

	public function detail($parameters){
		//dd($parameters);
	}
}