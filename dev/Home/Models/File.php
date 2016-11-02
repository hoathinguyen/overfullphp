<?php
/*----------------------------------------------------
* Filename: File.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The file object class
* ----------------------------------------------------
*/
namespace Dev\Home\Models;
use Overfull\Pattern\MVC\Model;
/**
* 
*/
class File extends Model{
	protected $primaryKey = "id";
	protected $tableName = 'files';
}