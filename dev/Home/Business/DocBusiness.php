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
				->columns(['docs.title', 'docs.id', 'docs.icon'])
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
}