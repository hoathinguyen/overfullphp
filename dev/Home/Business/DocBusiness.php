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
				->query()
				->columns('docs.*')
				->join('versions', 'versions.id = docs.version_id')
				->where(['versions.id', '=', $version.'.x'])
				->all();
	}
}