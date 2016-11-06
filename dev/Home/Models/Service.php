<?php
/*----------------------------------------------------
* Filename: File.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The file object class
* ----------------------------------------------------
*/
namespace Dev\Home\Models;
use Overfull\Patterns\MVC\Model;
/**
* 
*/
class Service extends Model{
	protected $primaryKey = "id";
	protected $tableName = 'services';
}