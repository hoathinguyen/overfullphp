<?php
/*----------------------------------------------------
* Servicename: DocBusiness.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The business about doc
* ----------------------------------------------------
*/
namespace Dev\Admin\Business;
use Dev\Admin\Models\Service;

class ServiceBusiness{
	/**
	 * Get service by id
	 *
	 * @param string name
	 * @return Service object
	 */
	public function getServiceById($id){
		return Service::instance()->find($id);
	}

	/**
	 * Get all data
	 *
	 * @return array of doc
	 */
	public function getServiceAsList($keyword = false){
		// Check and set default data

		return Service::instance()
			->schema()
			->columns(['services.id', 'services.title', 'services.url'])
			->where(['services.title', 'LIKE', "%$keyword%"])
			->all();
	}

	/**
	 * addDoc
	 *
	 * @param data
	 * @return boolean
	 */
	public function addOrEditService($data){
		if(empty($data['id'])){
			$service = new Service();
		} else {
			$service = $this->getServiceById($data['id']);
		}
		
		$service->title = !empty($data['title']) ? $data['title'] : '';
		$service->image = !empty($data['image']) ? $data['image'] : '';
		$service->url = !empty($data['url']) ? $data['url'] : '';
		$service->description = !empty($data['description']) ? $data['description'] : '';
		return $service->save();
	}

	/**
	 * addDoc
	 *
	 * @param data
	 * @return boolean
	 */
	public function validate($data){
		return Service::instance()->isCreateValid($data);
	}
}