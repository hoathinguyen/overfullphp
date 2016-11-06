<?php
/*----------------------------------------------------
* Filename: UsersController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Dev\Home\Controllers;
use Overfull\Patterns\MVC\Controller;
use Dev\Home\Business\FileBusiness;
use Bag;

class FilesController extends Controller{
	protected $otp = [
		'layout' => 'home'
	];
	/**
	 * Download package
	 */
	public function download(){
		$id = Bag::route()->id;
		$fileBusiness = new FileBusiness();
		$file = $fileBusiness->getFileById($id);
		return $this->render('download', ['file' => $file]);
	}
}