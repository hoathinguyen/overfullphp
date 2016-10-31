<?php
/*----------------------------------------------------
* Filename: Auth.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Authentication package
* ----------------------------------------------------
*/
namespace Packages\Authentication;
use Overfull\Package\BasePackage;
use Bag;

class Auth extends BasePackage{
	private $idField = 'username';
	private $secretField = 'password';
	/**
	 * Is logged method
	 * @return boolean
	 */
	public function isLogged(){
		return Bag::session()->check($this->session);
	}

	/**
	 * Login method
	 * @param array $data
	 */
	public function login($data){
		$class = $this->entity;
		$model = new $class;
		$ids = $this->id;
		$hasherClass = $this->hasher;
		$hasher = new $hasherClass();
		// Data
		$username = isset($data[$this->idField]) ? $data[$this->idField] : '';
		$password = $hasher->hash(isset($data[$this->secretField]) ? $data[$this->secretField] : '');

		$result = $model->query()
		->where([$this->secret, '=', $password])
		->andWhere(function($query) use($ids, $username) {
			$count = count($ids);

			$query->where([$ids[0], 'LIKE', $username]);

			for($i = 1; $i < $count; $i++) {
				$query->orWhere([$ids[$i], 'LIKE', $username]);
			}
		})
		->one();

		if($result){
			Bag::session()->write($this->session, $data);
			return true;
		}
		return false;
	}

	/**
	 * Login method
	 * @param array $data
	 */
	public function logout(){
		Bag::session()->delete($this->session);
	}

	/**
	 * user method
	 * @param array $data
	 */
	public function user(){
		return Bag::session()->read($this->session);
	}
}