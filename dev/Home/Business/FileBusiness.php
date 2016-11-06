<?php
/*----------------------------------------------------
* Filename: DocBusiness.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The business about doc
* ----------------------------------------------------
*/
namespace Dev\Home\Business;
use Dev\Home\Models\File;

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
}