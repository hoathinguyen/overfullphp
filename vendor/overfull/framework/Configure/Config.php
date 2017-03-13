<?php
/*----------------------------------------------------
* Config object class
* This class is parent for all of config object.
* This has some method will be use as static.
* ----------------------------------------------------
*/
namespace Overfull\Configure;
use Overfull\Foundation\Base\BaseObject;
use Overfull\Utility\ArrayUtil;
use Overfull\Exception\ConfigFileNotFoundException;

class Config extends BaseObject{
    private $configs = array();

    public function addFiles($name, $files){
        $this->set("main.$name", $files);
    }

    /**
     * Get value of config
     *
     * @param string $name
     */
    public function get( $name = '' ){
            try {
                    return ArrayUtil::access($this->configs, $name);
            }catch( \Exception $e ){
                    throw new \Exception($e->getMessage(), 102);
            }
    }

    /**
     * set value for config
     *
     * @date 2016/05/21
     * @param string $name
     * @param value $val
     * @param boolean $isPath
     */
    public function set($name, $val = null){
            try {
                    ArrayUtil::setValue($this->configs, $name, $this->convert($val));
                    return $val;
            }catch( \Exception $e ){
                    throw new \Exception($e->getMessage(), 102);
            }
    }

    /**
     * setByFile
     */
    public function setByFile($name, $val = array(), $isException = true, $isGetReturn = true){
            try {
                    if(!$isGetReturn){
                            if(is_array($val)){
                                    foreach ($val as $key => $value) {
                                            if(file_exists($value)){
                                                    require($value);
                                            } else if($isException){
                                                    throw new ConfigFileNotFoundException($value);
                                            }
                                    }
                            } else {
                                    if(file_exists($val)){
                                            require($val);
                                    } else if($isException){
                                            throw new ConfigFileNotFoundException($val);
                                    }
                            }
                            return;
                    }

                    $result = $this->get($name);

                    if(empty($result)){
                            $result = [];
                    }

                    if(is_array($val)){
                            foreach ($val as $key => $value) {
                                    if(file_exists($value)){
                                            $configs = require($value);
                                            $result = array_merge($result, $this->convert($configs));
                                    } else if($isException){
                                            throw new ConfigFileNotFoundException($value);
                                    }
                            }
                    } else {
                            if(file_exists($val)){
                                    $configs = require($val);
                                    $result = array_merge($result, $this->convert($configs));
                            } else if($isException){
                                    throw new ConfigFileNotFoundException($val);
                            }
                    }

                    ArrayUtil::setValue($this->configs, $name, $result);
                    return $result;
            }catch( \Exception $e ){
                    throw new \Exception($e->getMessage(), 102);
            }
    }

    /**
     * Delete config
     *
     * @param string $name
     * @return void
     */
    public function delete($name){
        unset($this->configs[$name]);
    }

    /**
     * Convert config
     *
     * @param string $name
     * @return void
     */
    private function convert($configs){
        if(is_object($configs)){
            return $configs();
        }

        return $configs;
    }
}
