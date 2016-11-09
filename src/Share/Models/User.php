<?php
namespace Src\Share\Models;
use Overfull\Patterns\MVC\Model;

class User extends Model{
	protected $primaryKey = "id";
	protected $tableName = 'users';
	protected function beforeSave(){
		if(!empty($this->attributes['password'])){
			$hasher = new \Overfull\Security\Hasher\SimpleHasher();
			$this->attributes['password'] = $hasher->hash($this->attributes['password']);
		} else {
			unset($this->attributes['password']);
		}
	}
	protected $rules = [
		'username' => [
			//'numeric' => ":field must be a numeric",
			//'minlength:3' => ":field length must be more or equal than :minlength",
			'maxlength:30' => ":field length must be less or equal than :maxlength",
			'require' => ':field is required'
		]
	];

	public function isEditValid($data){
		return $this->validate($data, $this->rules)->isValid();
	}
}