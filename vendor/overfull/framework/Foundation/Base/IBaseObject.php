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

interface IBaseObject{
    /**
    * Get instance class name of object
    *
    * return name of class (include namespace)
    */
    static function className();

    static function instance($use = false);
}
?>