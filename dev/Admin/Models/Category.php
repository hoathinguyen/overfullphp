<?php
/*----------------------------------------------------
* Filename: Category.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle Category
* ----------------------------------------------------
*/
namespace Dev\Admin\Models;
use Overfull\Pattern\MVC\Model;
/**
* 
*/
class Category extends Model{
	protected $primaryKey = "id";
	protected $tableName = 'categories';
}