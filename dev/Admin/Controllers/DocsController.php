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
use Overfull\Template\Helpers\Flash;

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

		if(Bag::request()->isMethod('POST')){
			if(!$this->docBusiness->validate(Bag::request()->post())){
				return $this->render(false, ['type' => 'Create'])->withLastPost();
			}

			if($this->docBusiness->addOrEditDoc(Bag::request()->post())){
				Flash::write('success', "Created new document");
				return $this->redirect('/docs');
			}

			Flash::write('success', "Have error when creating");
			return $this->render(false, ['type' => 'Create'])->withLastPost();
		}

		return $this->render(false, ['type' => 'Create']);
	}

	/**
	 * create method
	 * @return render
	 */
	public function edit($parameter){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}

		if(Bag::request()->isMethod('POST')){
			$this->docBusiness->addOrEditDoc(Bag::request()->post());
			Flash::write('success', "Edited #$parameter[1]");
			return $this->redirect('/docs');
		}

		$doc = $this->docBusiness->getDocById($parameter[1]);

		return $this->render('create', ['type' => 'Edit'])->form(['doc' => $doc]);
	}

	/**
	 * detail method
	 * @return render
	 */
	public function detail($parameter){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}

		$doc = $this->docBusiness->getDocById($parameter[1]);
		return $this->render(false, ['doc' => $doc]);
	}

	/**
	 * detail method
	 * @return render
	 */
	public function delete($parameter){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}

		$doc = $this->docBusiness->getDocById($parameter[1]);

		if($doc && $doc->delete()){
			// Set falsh
			Flash::write('success', "Deleted #$parameter[1]");
		}

		return $this->redirect('/docs');
	}
}