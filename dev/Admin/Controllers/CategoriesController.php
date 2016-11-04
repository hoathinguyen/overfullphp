<?php
/*----------------------------------------------------
* Filename: CategoriesController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle categories
* ----------------------------------------------------
*/
namespace Dev\Admin\Controllers;
use Dev\Admin\Controllers\AdminController;
use Dev\Admin\Business\UserBusiness;
use Dev\Admin\Business\CategoryBusiness;
use Bag;

class CategoriesController extends AdminController{
	private $categoryBusiness;

	function __construct(){
		$this->categoryBusiness = new CategoryBusiness();
	}

	/**
	 * Ajax get categories
	 */
	public function ajaxCategories(){
		$data = $this->categoryBusiness->getCategories();
		return $this->json($data);
	}
}