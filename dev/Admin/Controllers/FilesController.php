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
use Dev\Admin\Business\FileBusiness;
use Bag;
use Overfull\Template\Helpers\Flash;

class FilesController extends AdminController{
	private $fileBusiness;
	//private $categoryBusiness;
	//private $versionBusiness;

	public function __construct(){
		$this->fileBusiness = new FileBusiness();
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

		$files = $this->fileBusiness->getFileAsList($keyword, $category, $version);
		return $this->render(false, ['files' => $files]);
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
			if(!$this->fileBusiness->validate(Bag::request()->post())){
				return $this->render(false, ['type' => 'Create'])->withLastPost();
			}

			if($this->fileBusiness->addOrEditFile(Bag::request()->post())){
				Flash::write('success', "Created new document");
				return $this->redirect('/files');
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
			$this->fileBusiness->addOrEditFile(Bag::request()->post());
			Flash::write('success', "Edited #$parameter[1]");
			return $this->redirect('/files');
		}

		$file = $this->fileBusiness->getFileById($parameter[1]);

		return $this->render('create', ['type' => 'Edit'])->form(['file' => $file]);
	}

	/**
	 * detail method
	 * @return render
	 */
	public function detail($parameter){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}

		$file = $this->fileBusiness->getFileById($parameter[1]);
		return $this->render(false, ['file' => $file]);
	}

	/**
	 * detail method
	 * @return render
	 */
	public function delete($parameter){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}

		$file = $this->fileBusiness->getFileById($parameter[1]);

		if($file && $file->delete()){
			// Set falsh
			Flash::write('success', "Deleted #$parameter[1]");
		}

		return $this->redirect('/files');
	}
}