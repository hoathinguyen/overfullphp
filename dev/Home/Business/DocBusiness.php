<?php
/*----------------------------------------------------
* Filename: DocBusiness.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The business about doc
* ----------------------------------------------------
*/
namespace Dev\Home\Business;
use Dev\Home\Models\Doc;
use Dev\Home\Models\File;

class DocBusiness{

	/**
	 * Get doc list by version
	 *
	 * @param integer $version
	 * @return Object list
	 */
	public function getDocListByVersion($version){
		return Doc::instance()
				->query()
				->columns('docs.*')
				->join('versions', 'versions.id = docs.version_id')
				->where(['versions.id', '=', $version.'.x'])
				->all();
	}

	/**
	 * Get doc list by version
	 *
	 * @param integer $version
	 * @return Object list
	 */
	public function getDoc($version, $name){
		return Doc::instance()
				->query()
				->columns('docs.*')
				->join('versions', 'versions.id = docs.version_id')
				->where(['versions.id', '=', $version.'.x'])
				->andWhere(['docs.title', 'LIKE', $name])
				->one();
	}

	/**
	 * Get files by category
	 *
	 * @param string name
	 * @return object list
	 */
	public function getFilesByCategory($name){
		return File::instance()
				->query()
				->columns(['files.*', 'versions.name'])
				->join('categories', 'categories.id = files.category_id')
				->join('versions', 'versions.id = files.version_id')
				->where(['categories.name', '=', $name])
				->all();
	}
}