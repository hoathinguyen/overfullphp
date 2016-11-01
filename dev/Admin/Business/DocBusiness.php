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
	public function getDocAsList(){
		return Doc::instance()
			->query()
			->columns(['docs.id', 'docs.title', 'versions.name AS version', 'categories.name AS category'])
			->join('categories', 'categories.id = docs.category_id')
			->join('versions', 'versions.id = docs.version_id')
			->all();
	}
}