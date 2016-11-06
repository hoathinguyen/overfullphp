<?php
namespace Dev\Admin\Models;
use Overfull\Patterns\MVC\Model;
/**
* 
*/
class Service extends Model{
	protected $primaryKey = "id";
	protected $tableName = 'services';
	protected $rules = [
		'title' => [
			//'numeric' => ":field must be a numeric",
			//'minlength:3' => ":field length must be more or equal than :minlength",
			'maxlength:30' => ":field length must be less or equal than :maxlength",
			'require' => ':field is required'
		],
		'content' => [
			//'numeric' => ":field must be a numeric",
			//'minlength:3' => ":field length must be more or equal than :minlength",
			//'maxlength:30' => ":field length must be less or equal than :maxlength",
			'require' => ':field is required'
		]
	];

	public function isCreateValid($data){
		return $this->validate($data, $this->rules)->isValid();
	}
}