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
use Packages\Authentication\LoggedData;
use Bag;

class Auth extends BasePackage{
	private $idField = 'username';
	private $secretField = 'password';
	private $dbData = null;
	private $scope = null;
	/**
	 * Is logged method
	 * @return boolean
	 */
	public function isLogged(){
		return Bag::session()->check($this->scope.'_'.$this->session);
	}

	/**
	 * Scope
	 */
	public function scope($scope = null){
		$this->scope = $scope;
		return $this;
	}

	/**
	 * Login method
	 * @param array $data
	 */
	public function login($data = null){
		if(!$data){
			$data = Bag::request()->postAsArray();
		}

		$class = $this->entity;
		$model = new $class;
		$ids = $this->id;
		$hasherClass = $this->hasher;
		$hasher = new $hasherClass();
		// Data
		$username = isset($data[$this->idField]) ? $data[$this->idField] : '';
		$password = $hasher->hash(isset($data[$this->secretField]) ? $data[$this->secretField] : '');

		$result = $model->schema()
		->where([$this->secret, '=', $password])
		->andWhere(function($query) use($ids, $username) {
			$count = count($ids);

			$query->where([$ids[0], 'LIKE', $username]);

			for($i = 1; $i < $count; $i++) {
				$query->orWhere([$ids[$i], 'LIKE', $username]);
			}
		})
		->first();

		if($result){
			$logged = new LoggedData();
			$pri = $result->getPrimaryKey();
			$logged->{$pri} = $result->{$pri};

			Bag::session()->write($this->scope.'_'.$this->session, $logged);

                        if(!empty($this->afterLogin)){
                            $afterEvent = $this->afterLogin;
                            if(is_object($afterEvent)){
                                $afterEvent();
                            }
                        }

			return true;
		}
		return false;
	}

	/**
	 * Login method
	 * @param array $data
	 */
	public function logout(){
		Bag::session()->delete($this->scope.'_'.$this->session);
	}

	/**
	 * user method
	 * @param array $data
	 */
	public function get(){
		return Bag::session()->read($this->scope.'_'.$this->session);
	}

	/**
	 * user method
	 * @param array $data
	 */
	public function load(){
		$entityClass = $this->entity;
		$model = new $entityClass;

		if(!$this->dbData){
			$pr = $model->getPrimaryKey();
			$this->dbData = $model->find($this->get()->{$pr});
		}

                unset($this->dbData->{$this->secret});

		return $this->dbData;
	}
}
