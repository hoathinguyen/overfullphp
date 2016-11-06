<?php
/*----------------------------------------------------
* Servicename: DocsController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle docs
* ----------------------------------------------------
*/
namespace Dev\Admin\Controllers;
use Dev\Admin\Controllers\AdminController;
use Dev\Admin\Business\ServiceBusiness;
use Bag;
use Overfull\Template\Helpers\Flash;

class ServicesController extends AdminController{
	private $serviceBusiness;
	//private $categoryBusiness;
	//private $versionBusiness;

	public function __construct(){
		$this->serviceBusiness = new ServiceBusiness();
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

		$services = $this->serviceBusiness->getServiceAsList($keyword, $category, $version);
		return $this->render(false, ['services' => $services]);
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
			if(!$this->serviceBusiness->validate(Bag::request()->post())){
				return $this->render(false, ['type' => 'Create'])->withLastPost();
			}

			if($this->serviceBusiness->addOrEditService(Bag::request()->post())){
				Flash::write('success', "Created new document");
				return $this->redirect('/services');
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
			$this->serviceBusiness->addOrEditService(Bag::request()->post());
			Flash::write('success', "Edited #$parameter[1]");
			return $this->redirect('/services');
		}

		$service = $this->serviceBusiness->getServiceById($parameter[1]);

		return $this->render('create', ['type' => 'Edit'])->form(['service' => $service]);
	}

	/**
	 * detail method
	 * @return render
	 */
	public function detail($parameter){
		if (!Bag::package()->auth->isLogged()){
			return $this->redirect('/login');
		}

		$file = $this->serviceBusiness->getServiceById($parameter[1]);
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

		$file = $this->serviceBusiness->getServiceById($parameter[1]);

		if($file && $file->delete()){
			// Set falsh
			Flash::write('success', "Deleted #$parameter[1]");
		}

		return $this->redirect('/services');
	}
}