<?php
/*----------------------------------------------------
* Filename: DocBusiness.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The business about doc
* ----------------------------------------------------
*/
namespace Dev\Admin\Business;
use Dev\Admin\Models\File;

class FileBusiness{
	/**
	 * Get files by category
	 *
	 * @param string name
	 * @return object list
	 */
	public function getFilesByCategory($name){
		return File::instance()
				->schema()
				->columns(['files.id','files.title', 'versions.name'])
				->join('categories', 'categories.id = files.category_id')
				->join('versions', 'versions.id = files.version_id')
				->where(['categories.name', 'LIKE', $name])
				->all();
	}
	/**
	 * Get file by id
	 *
	 * @param string name
	 * @return File object
	 */
	public function getFileById($id){
		return File::instance()->find($id);
	}

	/**
	 * Get all data
	 *
	 * @return array of doc
	 */
	public function getFileAsList($keyword = false, $category = false, $version = false){
		// Check and set default data
		if(!$category){
			$category = '';
		}

		if(!$version){
			$version = '';
		}

		return File::instance()
			->schema()
			->columns(['files.id', 'files.title', 'versions.name AS version', 'categories.name AS category'])
			->join('categories', 'categories.id = files.category_id')
			->join('versions', 'versions.id = files.version_id')
			->where(['files.title', 'LIKE', "%$keyword%"])
			->andWhere(['categories.id', 'LIKE', "%$category%"])
			->andWhere(['versions.id', 'LIKE', "%$version%"])
			->all();
	}

	/**
	 * addDoc
	 *
	 * @param data
	 * @return boolean
	 */
	public function addOrEditFile($data){
		if(empty($data['id'])){
			$file = new File();
		} else {
			$file = $this->getFileById($data['id']);
		}
		
		$file->title = !empty($data['title']) ? $data['title'] : '';
		$file->content = !empty($data['content']) ? $data['content'] : '';
		$file->url = !empty($data['url']) ? $data['url'] : '';
		$file->category_id = !empty($data['category_id']) ? $data['category_id'] : '';
		$file->version_id = !empty($data['version_id']) ? $data['version_id'] : '';
		return $file->save();
	}

	/**
	 * addDoc
	 *
	 * @param data
	 * @return boolean
	 */
	public function validate($data){
		return File::instance()->isCreateValid($data);
	}
}