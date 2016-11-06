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
				->schema()
				->columns('docs.*')
				->join('versions', 'versions.id = docs.version_id')
				->join('categories', 'categories.id = docs.category_id')
				->where(['versions.id', '=', $version.'.x'])
				->andWhere(['categories.name', 'LIKE', 'framework'])
				->all();
	}

	/**
	 * Get getFirstDoc by version
	 *
	 * @param integer $version
	 * @return Object list
	 */
	public function getFirstDoc($version){
		return Doc::instance()
				->schema()
				->columns('docs.*')
				->join('versions', 'versions.id = docs.version_id')
				->join('categories', 'categories.id = docs.category_id')
				->where(['versions.id', '=', $version.'.x'])
				->andWhere(['categories.name', 'LIKE', 'framework'])
				->one();
	}

	/**
	 * Get doc list by version
	 *
	 * @param integer $version
	 * @return Object list
	 */
	public function getDoc($version, $id){
		return Doc::instance()
				->schema()
				->columns('docs.*')
				->join('versions', 'versions.id = docs.version_id')
				->where(['versions.id', '=', $version.'.x'])
				->andWhere(['docs.id', '=', $id])
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
				->schema()
				->columns(['files.*', 'versions.name'])
				->join('categories', 'categories.id = files.category_id')
				->join('versions', 'versions.id = files.version_id')
				->where(['categories.name', 'LIKE', $name])
				->all();
	}
}