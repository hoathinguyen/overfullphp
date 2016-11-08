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
use Overfull\Foundation\Base\IBaseObject;

abstract class BaseObject implements IBaseObject{
	/**
	* Get instance class name of object
	*
	* return name of class (include namespace)
	*/
	public static function className(){
		//return get_class($this);
		return get_called_class();
	}
}
?>