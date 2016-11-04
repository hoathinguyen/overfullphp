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
use Dev\Admin\Business\CategoryBusiness;
use Dev\Admin\Business\VersionBusiness;
use Bag;


class DocsController extends AdminController{
	private $docBusiness;
	//private $categoryBusiness;
	//private $versionBusiness;

	public function __construct(){
		$this->docBusiness = new DocBusiness();
		$this->categoryBusiness = new CategoryBusiness();
		$this->versionBusiness = new VersionBusiness();
	}
	/**
	 * Index method
	 * @return render
	 */
	public function index(){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}

		$keyword = Bag::request()->get('keyword');
		$category = Bag::request()->get('category');
		$version = Bag::request()->get('version');

		$docs = $this->docBusiness->getDocAsList($keyword, $category, $version);
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

	/**
	 * detail method
	 * @return render
	 */
	public function detail($parameter){
		$doc = $this->docBusiness->getDocById($parameter[1]);
		return $this->render(false, ['doc' => $doc]);
	}

	/**
	 * detail method
	 * @return render
	 */
	public function delete($parameter){
		$doc = $this->docBusiness->getDocById($parameter[1]);

		if($doc && $doc->delete()){
			// Set falsh
		}

		return $this->redirect('/docs');
	}
}