<?php
/*----------------------------------------------------
* Filename: DocsController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle docs
* ----------------------------------------------------
*/
namespace Dev\Admin\Controllers;
use Dev\Admin\Controllers\AdminController;
use Dev\Admin\Business\DocBusiness;
use Bag;


class DocsController extends AdminController{
	private $docBusiness;

	public function __construct(){
		$this->docBusiness = new DocBusiness();
	}
	/**
	 * Index method
	 * @return render
	 */
	public function index(){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}
		$docs = $this->docBusiness->getDocAsList();
		return $this->render(false, ['docs' => $docs]);
	}

	/**
	 * create method
	 * @return render
	 */
	public function create(){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}
		return $this->render();
	}

	/**
	 * create method
	 * @return render
	 */
	public function edit(){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}
		return $this->render();
	}
}