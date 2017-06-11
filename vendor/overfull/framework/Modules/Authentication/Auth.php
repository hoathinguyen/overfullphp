<?php
/*----------------------------------------------------
* Filename: Auth.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Authentication package
* ----------------------------------------------------
*/
namespace Overfull\Modules\Authentication;
use Overfull\Modules\Foundation\BaseModule;
use Overfull\Modules\Authentication\LoggedData;
use Bag;

class Auth extends BaseModule{
    // Attributes
    protected $attributes = [
        'session' => 'auth'
    ];
    
    // Provider
    protected $provider = null;
    
    // Hasher
    protected $hasher = null;
    
    // Logged data
    protected $loadedData = null;
    
    // Session data
    protected $loggedData = null;

    /**
     * __set
     */
    public function __set($name, $value)
    {
        $this->setAttributes($name, $value);
    }

    /**
     * __get
     */
    public function __get($name)
    {
        $this->getAttributes($name);
    }

    /**
     * Defined when call method
     */
    public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        return $this->call($name, $arguments);
    }
    
    /**
     * Get session key method
     * @return type
     */
    public final function getKey()
    {
        return $this->getAttributes('scope').'_'.$this->getAttributes('session');
    }
    
    /**
     * get Provider
     * @return type
     * @throws \Overfull\Exception\ClassNotFoundException
     */
    public final function getProvider()
    {
        if(!$this->provider){
            // Check if user provider
            if($provider = $this->getAttributes('provider')){
                if(!$this->provider){
                    if(!class_exists($provider)){
                        throw new \Overfull\Exception\ClassNotFoundException($provider);
                    }

                    $this->provider = new $provider;
                }
            }
        }
        
        return $this->provider;
    }
    
    /**
     * Get hasher
     * @return type
     */
    public final function getHasher()
    {
        // Hasher
        if(!$this->hasher){
            $hasherClass = $this->getAttributes('hasher');
            $this->hasher = new $hasherClass();
        }
        
        return $this->hasher;
    }

    /**
     * Call
     * @param type $name
     * @param type $arguments
     * @return type
     * @throws \Overfull\Exception\MethodNotFoundException
     */
    public final function call($name, $arguments)
    {
    	// Check if user provider
        if($provider = $this->getProvider()){
            if(method_exists($provider, $name)){
                return $provider->{$name}($this, $arguments);
            }
        }
        
        throw new \Overfull\Exception\MethodNotFoundException($name, get_class($this));
    }

    /**
     * Set attribute
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public final function setAttributes($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * Get attribute
     * @param string $name
     * @return $this
     */
    public final function getAttributes($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * Set scope
     * @param string $scope
     * @return $this
     */
    public final function scope($scope = null)
    {
        $this->setAttributes('scope', $scope);
        return $this;
    }

    /**
     * Is logged method
     * @return boolean
     */
    public final function isLogged()
    {
        if($provider = $this->getProvider()){
            if(method_exists($provider, 'isLogged')){
                return $provider->isLogged($this);
            }
        }
        
        return Bag::session()->check($this->getKey());
    }

    /**
     * Login method
     * @param array $data
     */
    public final function login($data = null)
    {
        // Get data post as array
        if(!$data){
            $data = Bag::request()->postAsArray();
        }
        
        // Check if user provider
        if($provider = $this->getProvider()){
            if(method_exists($provider, 'login')){
                return $provider->login($this, $data);
            }
        }
        
        // fields conpare
        $clientId = $this->getAttributes('clientId');
        $secretId = $this->getAttributes('secretId');

        // Check if is have setting
        if(empty($secretId)){
            throw new \Overfull\Exception\UndefinedAttributeException('secretId', get_class($this));
        }

        if(empty($clientId)){
            throw new \Overfull\Exception\UndefinedAttributeException('clientId', get_class($this));
        }

        // Check if have request data
        if(empty($data[$secretId[0]]) || empty($data[$clientId[0]])){
            return false;
        }

        // Model object
        $class = $this->getAttributes('entity');
        $model = new $class;
        $schema = $model->schema();
        $hasherPw = $this->getHasher()->hash($data[$secretId[0]]);

        // Secret
        if(is_array($secretId[1])){
            $schema->where(function($q) use ($secretId, $data, $hasherPw){
                foreach ($secretId[1] as $key => $value){
                    if($key == 0){
                        $q->where([$value, '=', $hasherPw]);
                    }
                    else{
                        $q->orWhere([$value, '=', $hasherPw]);
                    }
                }
            });
        }
        else{
            $schema->where([$secretId[1], '=', $hasherPw]);
        }

        // Client id
        if(is_array($clientId[1])){
            $schema->andWhere(function($q) use ($clientId, $data){
                foreach ($clientId[1] as $key => $value){
                    if($key == 0){
                        $q->where([$value, '=', $data[$clientId[0]]]);
                    }
                    else{
                        $q->orWhere([$value, '=', $data[$clientId[0]]]);
                    }
                }
            });
        }
        else{
            $schema->andWhere([$clientId[1], '=', $data[$clientId[0]]]);
        }

        $result = $schema->first();

        if($result){
            return $this->setLoggedData($result);
        }

        return false;
    }

    /**
     * Login method
     * @param array $data
     */
    public final function logout()
    {
        if($provider = $this->getProvider()){
            if(method_exists($provider, 'logout')){
                return $provider->logout($this);
            }
        }
        
        Bag::session()->delete($this->getKey());
        return $this;
    }

    /**
     * user method
     * @param array $data
     */
    public final function get()
    {
        if($logged = $this->getLoggedData()){
            return $logged;
        }
        
        if($provider = $this->getProvider()){
            if(method_exists($provider, 'get')){
                return $provider->get($this);
            }
        }

        $this->setLoggedData(Bag::session()->read($this->getKey()), FALSE);
                
        return $this->getLoggedData();
    }
    
    /**
     * Get logged data method
     * @return type
     */
    public final function getLoggedData()
    {
        return $this->loggedData;
    }

    /**
     * user method
     * @param array $data
     */
    public final function setLoggedData($result, $saveSession = true)
    {
        if(!$result ){
            return false;
        }

        if(!is_object($result)){
            throw new \Overfull\Exception\InstanceOfObjectException($result,  '\Overfull\Database\Eloquent\ActiveRecord');
        }

        if(is_a($result, \Overfull\Database\Eloquent\ActiveRecord::class)){
            //throw new \Overfull\Exception\InstanceOfObjectException(get_class($result),  '\Overfull\Database\Eloquent\ActiveRecord');
            
            $logged = new LoggedData();

            $attributes = $result->getAttributes();

            foreach ($attributes as $key => $value) {
                $logged->{$key} = $value;
            }

            $this->loggedData = $logged;
        }
        else{
            $this->loggedData = $result;
        }
        
        if($saveSession){
            Bag::session()->write($this->getKey(), $this->loggedData);
        }
        
        return true;
    }

    /**
     * user method
     * @param array $data
     */
    public final function load()
    {
        if($loaded = $this->getLoadedData()){
            return $loaded;
        }
        
        if($provider = $this->getProvider()){
            if(method_exists($provider, 'load')){
                return $provider->load($this);
            }
        }

        $entity = $this->getAttributes('entity');
        $model = new $entity;

        $pr = $model->getPrimaryKey();
        $this->setLoadedData($model->find($this->get()->{$pr}));

        return $this->getLoadedData();
    }
        
    /**
     * Set load data
     */
    public final function setLoadedData($data)
    {
        $this->loadedData = $data;
        return $this;
    }

    /**
     * Set load data
     */
    public final function getLoadedData()
    {
        return $this->loadedData;
    }
}
