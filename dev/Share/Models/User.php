<?php
namespace Dev\Admin\Models;
use Overfull\Patterns\MVC\Model;
/**
* 
*/
class User extends Model{
	protected $primaryKey = "id";
	protected $tableName = 'users';
}