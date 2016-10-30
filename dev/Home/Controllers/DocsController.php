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
use Dev\Home\Business\DocBusiness;
/**
* 
*/
class DocsController extends Controller{
	protected $otp = [
		'layout' => 'home'
	];
	
	public function index(){
		$version = Bag::route()->version;
		$docBal = new DocBusiness();

		$docList = $docBal->getDocListByVersion($version);
		dd($docList);

		return $this->render();
	}

	public function install(){
		//dd($parameters);
		return $this->render();
	}
}