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
	
	/**
	 * Index method
	 *
	 * @return render
	 */
	public function index(){
		$version = Bag::route()->version;
		$docBal = new DocBusiness();
		$docList = $docBal->getDocListByVersion($version);
		// Get data
		$content = $docBal->getDoc($version, 'Get started');
		return $this->render('posts',
			['menu' => $docList, 'version' => $version, 'doc' => $content]);
	}

	/**
	 * Posts method
	 *
	 * @param array $parameter
	 * @return render
	 */
	public function posts($parameters){
		$version = Bag::route()->version;
		$docBal = new DocBusiness();
		$docList = $docBal->getDocListByVersion($version);
		// Get data
		$content = $docBal->getDoc($version, $parameters[2]);
		return $this->render(false,
			['menu' => $docList, 'version' => $version, 'doc' => $content]);
	}

	/**
	 * Install method
	 *
	 * @return render
	 */
	public function install(){
		$version = Bag::route()->version;
		$docBal = new DocBusiness();
		$files = $docBal->getFilesByCategory('framework');
		return $this->render(false, ['files' => $files]);
	}
}