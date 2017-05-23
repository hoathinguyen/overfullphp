<?php
/**
 * Config object class
 * This object read data for config 
 *
 * @author Overfull.net
 * @link http://php.overfull.net/docs/config Document for Config
 * @date 2017/03/18
 */
namespace Overfull\Configure;

use Overfull\Exception\ConfigFileNotFoundException;
use Overfull\Support\Utility\ArrayUtil;

class Config extends \Overfull\Foundation\Base\BaseObject
{
    private $configData = [];
    
    /**
     * Run file
     * @param string $file
     * @param boolean $isException
     * @throws ConfigFileNotFoundException
     * @return $this
     */
    public function runFile($file, $isException = true)
    {
        // Check if exists file
        if(file_exists($file)){
            require($file);
        }
        // Throw error when this file is not exists
        else if($isException){
            throw new ConfigFileNotFoundException($file);
        }
        
        return $this;
    }
    
    /**
     * loadJson
     * @param string $name
     * @param string $file
     * @param boolean $isException
     * @throws ConfigFileNotFoundException
     * @return $this
     */
    public function loadJson($name, $file, $isException = true)
    {
        // Check if exists file
        if(file_exists($file)){
            $data = json_decode(file_get_contents($file), true);
            
            if(!$name)
            {
                $this->set($data);
            }
            else
            {
                $this->set($name, $data);
            }
        } else if($isException){
            // Throw error
            throw new ConfigFileNotFoundException($file);
        }
        
        return $this;
    }

    /**
     * loadJson
     * @param string $name
     * @param string $file
     * @param boolean $isException
     * @throws ConfigFileNotFoundException
     * @return $this
     */
    public function loadIni($name, $file, $isException = true)
    {
        // Check if exists file
        if(file_exists($file)){
            $data = parse_ini_file($file, true);
            
            if(!$name)
            {
                $this->set($data);
            }
            else
            {
                $this->set($name, $data);
            }
        } else if($isException){
            // Throw error
            throw new ConfigFileNotFoundException($file);
        }
        
        return $this;
    }
    
    /**
     * Load array method
     * @param string $name
     * @param string $arrays
     * @param boolean $isException
     * @throws \Overfull\Exception\DataTypeException
     * @return $this
     */
    public function loadArray($name, $arrays, $isException = true)
    {
        // Check if is array
        if(is_array($arrays)){
            if(!$name)
            {
                $this->set($arrays);
            }
            else
            {
                $this->set($name, $arrays);
            }
        } else  if($isException){
            throw new \Overfull\Exception\DataTypeException(get_class($arrays), 'Config::loadArray(type of array)');
        }
        
        return $this;
    }
    
    /**
     * Load file method
     * @param string $name
     * @param string $file
     * @param boolean $isException
     * @throws ConfigFileNotFoundException
     * @return $this
     */
    public function loadFile($name, $file, $isException = true)
    {
        // Check if exists file
        if(file_exists($file)){
            // Require file
            $data = require($file);
            if(!$name)
            {
                $this->set($data);
            }
            else
            {
                $this->set($name, $data);
            }
        } else if($isException){
            // Throw error
            throw new ConfigFileNotFoundException($file);
        }
        
        return $this;
    }
    
    /**
     * Load file method
     * @param string $name
     * @param \Closure $func
     * @param boolean $isException
     * @throws \Overfull\Exception\InstanceOfObjectException
     * @return $this
     */
    public function loadClosure($name, $func, $isException = true)
    {
        // Check if exists file
        if($func instanceof \Closure){
            // Require file
            if(!$name)
            {
                $this->set($func($this));
            }
            else
            {
                $this->set($name, $func($this));
            }
        }
        else if($isException)
        {
            // Throw error
            throw new \Overfull\Exception\InstanceOfObjectException(get_class($func), 'Closure');
        }
        
        return $this;
    }
    
    /**
     * Load xml method
     * @param string $name
     * @param string $file
     * @param boolean $isException
     * @throws ConfigFileNotFoundException
     * @return $this
     */
    public function loadXML($name, $file, $isException = true)
    {
        // Check if exists file
        if(file_exists($file)){
            // Require file
            $data = (array) simplexml_load_file($file);

            if(!$name)
            {
                $this->set($data);
            }
            else
            {
                $this->set($name, $data);
            }
        } else if($isException){
            // Throw error
            throw new ConfigFileNotFoundException($file);
        }
        
        return $this;
    }
    
    /**
     * Remove config method
     * @param type $name
     * @return $this
     */
    public function remove($name)
    {
        ArrayUtil::remove($this->configData, $name);
        return $this;
    }
    
    /**
     * Set value for config
     *
     * @param string $name
     * @param value $val
     * @return $this
     */
    public function set($name, $val = [])
    {
        try {
            if(is_array($name))
            {
                foreach ($name as $key => $value)
                {
                    if(is_array($value))
                    {
                        $data = (array)ArrayUtil::access($this->configData, $key);
                        if(is_array($data))
                        {
                            $value = array_merge($data, $value);
                        }
                    }
                    
                    ArrayUtil::setValue($this->configData, $key, $value);
                }
            }
            else
            {
                if(is_array($val))
                {
                    $data = (array)ArrayUtil::access($this->configData, $name);
                    if(is_array($data))
                    {
                        $val = array_merge($data, $val);
                    }
                }
                
                ArrayUtil::setValue($this->configData, $name, $val);
            }
        }catch( \Exception $e ){
            throw new \Exception($e->getMessage(), 102);
        }
        
        return $this;
    }
    
    /**
     * Get config method
     * @param type $name
     * @return type
     * @throws \Exception
     * @return mixed
     */
    public function get($name = '')
    {
        try {
            return ArrayUtil::access($this->configData, $name);
        }catch( \Exception $e ){
            throw new \Exception($e->getMessage(), 102);
        }
    }
    
    /**
     * Group method
     * @param type $groupName
     * @param type $data
     */
    public function forApp($app, $data, $isException = true)
    {
        // Check if exists file
        if($data instanceof \Closure){
            $this->set('ForApp.'.$app, $data);
        } else if($isException){
            // Throw error
            throw new \Overfull\Exception\InstanceOfObjectException(get_class($data), 'Closure');
        }
        
        return $this;
    }
    
    /**
     * Group method
     * @param type $groupName
     * @param type $data
     */
    public function loadApp($app, $isException = true)
    {
        $func = $this->get('ForApp.'.$app);
        
        if($func)
        {
            $this->loadClosure(false, $func, $isException);
        }
        else if($isException)
        {
            // Throw error
            throw new ConfigFileNotFoundException('ForApp.'.$app);
        }
        
        return $this;
    }
}