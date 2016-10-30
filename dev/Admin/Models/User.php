<?php
namespace Dev\TestApp\Models;
use Overfull\Pattern\MVC\Model;
/**
* 
*/
class User extends Model{
	protected $primaryKey = "id";
	protected $table = 'users';
}