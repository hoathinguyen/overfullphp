<?php
/*----------------------------------------------------
* Filename: Auth.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Authentication package
* ----------------------------------------------------
*/
namespace Overfull\Packages\Authentication;
use Overfull\Packages\Foundation\BasePackage;
use Overfull\Packages\Authentication\LoggedData;
use Bag;

class Auth extends BasePackage{
	protected $attributes = null;

	protected $provider = null;
	protected $hasher = null;

	/**
	 * __set
	 */
	public function __set($name, $value){
		$this->setAttributes($name, $value);
	}

	/**
	 * __get
	 */
	public function __get($name){
		$this->getAttributes($name);
	}

	/**
	 * Defined when call method
	 */
	public function __call($name, $arguments){
        // Note: value of $name is case sensitive.
        return $this->call($name, $arguments);
    }

    /**
	 * Set attributes
	 */
    public final function call($name, $arguments){
    	// Check if user provider
		if($provider = $this->getAttributes('provider')){
			if(!$this->provider){
				if(!class_exists($provider)){
					throw new \Overfull\Exception\ClassNotFoundException($provider);
				}

				$this->provider = new $provider;
			}

			if(method_exists($this->provider, $name)){
				return $this->provider->{$name}($arguments, $this);
			}
		}

		throw new \Overfull\Exception\MethodNotFoundException($name, get_class($this));
    }

	/**
	 * Set attributes
	 */
	public final function setAttributes($name, $value){
		$this->attributes[$name] = $value;
		return $this;
	}

	/**
	 * Get attributes
	 */
	public final function getAttributes($name){
		return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
	}

	/**
	 * Scope
	 */
	public final function scope($scope = null){
		$this->setAttributes('scope', $scope);
		return $this;
	}

	/**
	 * Is logged method
	 * @return boolean
	 */
	public final function isLogged(){
		return Bag::session()->check($this->getAttributes('scope').'_'.$this->session);
	}

	/**
	 * Login method
	 * @param array $data
	 */
	public final function login($data = null){
		// Check if user provider
		if($provider = $this->getAttributes('provider')){
			if(!$this->provider){
				if(!class_exists($provider)){
					throw new \Overfull\Exception\ClassNotFoundException($provider);
				}

				$this->provider = new $provider;
			}

			if(method_exists($this->provider, 'login')){
				$data = $this->provider->login($data, $this);

				return $this->set($data);
			}
		}

		// Get data post as array
		if(!$data){
			$data = Bag::request()->postAsArray();
		}

		// Client id
		$clientID = $this->getAttributes('clientID');
		$secretID = $this->getAttributes('secretID');

		// Check if is have setting
		if(!$secretID){
            throw new \Overfull\Exception\UndefinedAttributeException('secretID', get_class($this));
        }

        if(!$clientID){
            throw new \Overfull\Exception\UndefinedAttributeException('clientID', get_class($this));
        }

        // Check if have request data
		if(empty($data[$clientID]) || empty($data[$secretID])){
            return false;
        }

		// Hasher
		if(!$this->hasher){
			$hasherClass = $this->getAttributes('hasher');
			$this->hasher = new $hasherClass();
		}


		// Model object
		$class = $this->getAttributes('entity');
		$model = new $class;
		$result = $model->schema()
			->where([$secretID, '=', $this->hasher->hash($data[$secretID])])
			->andWhere([$clientID, 'LIKE', $data[$clientID]])
			->first();

		if($result){
			return $this->set($result);
		}

		return false;
	}

	/**
	 * Login method
	 * @param array $data
	 */
	public final function logout(){
		Bag::session()->delete($this->getAttributes('scope').'_'.$this->session);
		return $this;
	}

	/**
	 * user method
	 * @param array $data
	 */
	public final function get(){
		return Bag::session()->read($this->getAttributes('scope').'_'.$this->session);
	}

	/**
	 * user method
	 * @param array $data
	 */
	public final function set($result){
		if(!$result ){
			return false;
		}

		if(!is_object($result)){
			throw new \Overfull\Exception\InstanceOfObjectException($result,  '\Overfull\Database\Eloquent\ActiveRecord');
		}

		if(!is_a($result, \Overfull\Database\Eloquent\ActiveRecord::class)){
			throw new \Overfull\Exception\InstanceOfObjectException(get_class($result),  '\Overfull\Database\Eloquent\ActiveRecord');
		}

		$logged = new LoggedData();

		$attributes = $result->getAttributes();

		foreach ($attributes as $key => $value) {
			$logged->{$key} = $value;
		}

		Bag::session()->write($this->getAttributes('scope').'_'.$this->session, $logged);
		return true;
	}

	/**
	 * user method
	 * @param array $data
	 */
	public final function load(){
		// Check if user provider
		if($provider = $this->getAttributes('provider')){
			if(!$this->provider){
				if(!class_exists($provider)){
					throw new \Overfull\Exception\ClassNotFoundException($provider);
				}

				$this->provider = new $provider;
			}

			if(method_exists($this->provider, 'load')){
				return $this->provider->load($this->get(), $this);
			}
		}

		$entity = $this->getAttributes('entity');
		$model = new $entity;

		if(!$this->loadData){
			$pr = $model->getPrimaryKey();
			$this->loadData = $model->find($this->get()->{$pr});
			$secretID = $this->getAttributes('secretID');
			unset($this->loadData->{$secretID});
		}

		return $this->loadData;
	}
}
