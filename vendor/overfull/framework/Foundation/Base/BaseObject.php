<?php
/*----------------------------------------------------
* Filename: BaseObject.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: This class is highest in framework. First, this class will be call,
* and run some require and logic of framework
* ----------------------------------------------------
*/
namespace Overfull\Foundation\Base;

abstract class BaseObject implements \Overfull\Foundation\Base\IBaseObject
{
    /**
    * Get instance class name of object
    *
    * return name of class (include namespace)
    */
    public static function className(){
        //return get_class($this);
        return get_called_class();
    }

    /**
     * Get instance of this class
     *
     * @param string $use: name of connection,
     * which is config in database.php
     * @return current object
     */
    public static function instance($use = false){
        $class = static::className();
        return new $class();
    }
}
?>