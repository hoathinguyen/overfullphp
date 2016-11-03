<?php
namespace Dev\TestApp\Controllers;
use Overfull\Pattern\MVC\Controller;
use Dev\TestApp\Models\Test;
/**
* 
*/
class TestController extends Controller{
	protected $otp = [
		'layout' => 'sample',
		'helpers' => [
			'TEST' => \Dev\TestApp\Views\Helpers\TestHelper::class
		],
		'handler' => ''
	];
	
	public function setting(){
		// $data = Test::instance()
		// 		->schema()
		// 		->columns(['user_uid', 'username'])
		// 		->where(['id', '=', 169])
		// 		//->values('user_uid', 'update_success')
		// 		//->join('users', 'users.id = user_uid')
		// 		//->andWhere(['user_uid', '=', 'user_41'])
		// 		// ->orWhere(function($q){
		// 		// 	$q->where('a = b');
		// 		// })
		// 		->values(['user_uid' => 1, 'username' => 'toi'])
		// 		->values(['user_uid' => 1, 'username' => 'toi'])
		// 		->insert();
		$model = Test::instance()->find(194);
		$model->user_uid = '77777777777';
		$model->username = 'Tran lam toi';
		//return $model->save();
		//dd($data);

		//$test = Test::instance()->findOrDefault(1);
		//print_r($data);
		//var_dump($data[0]);
		return $this->render('test', ['users' => []]);
		//return $this->redirect('link');
		//return $this->json($data);
	}
}