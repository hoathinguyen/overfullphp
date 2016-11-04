<?php
/*----------------------------------------------------
* Filename: DocBusiness.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The business about doc
* ----------------------------------------------------
*/
namespace Dev\Admin\Business;
use Dev\Admin\Models\Doc;
use Dev\Admin\Models\File;

class DocBusiness{
	/**
	 * Get all data
	 *
	 * @return array of doc
	 */
	public function getDocAsList($keyword = false, $category = false, $version = false){
		// Check and set default data
		if(!$keyword){
			$keyword = '%';
		}

		if(!$category){
			$category = '%';
		}

		if(!$version){
			$version = '%';
		}

		return Doc::instance()
			->schema()
			->columns(['docs.id', 'docs.title', 'versions.name AS version', 'categories.name AS category'])
			->join('categories', 'categories.id = docs.category_id')
			->join('versions', 'versions.id = docs.version_id')
			->where(['docs.title', 'LIKE', $keyword])
			->andWhere(['categories.id', 'LIKE', $category])
			->andWhere(['versions.id', 'LIKE', $version])
			->all();
	}

	/**
	 * getDocById
	 *
	 * @param integer $id
	 * @return doc
	 */
	public function getDocById($id){
		return Doc::instance()->find($id);
	}
}