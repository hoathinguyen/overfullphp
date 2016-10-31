<?php
namespace Dev\Admin\Models;
use Overfull\Pattern\MVC\Model;
/**
* 
*/
class User extends Model{
	protected $primaryKey = "id";
	protected $table = 'users';
}