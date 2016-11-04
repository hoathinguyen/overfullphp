<?php
/*----------------------------------------------------
* Filename: CategoryBusiness.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The business about category
* ----------------------------------------------------
*/
namespace Dev\Admin\Business;
use Dev\Admin\Models\Category;

class CategoryBusiness{
	/**
	 * Get all categories
	 *
	 * @return array of Category
	 */
	public function getCategories(){
		return Category::instance()->schema()->all();
	}
}