<?php
/*----------------------------------------------------
* Filename: Doc.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Dev\Home\Models;
use Overfull\Patterns\MVC\Model;
/**
* 
*/
class Doc extends Model{
	protected $primaryKey = "id";
	protected $tableName = 'docs';
}