<?php
/*___________________________________________________________________________
* The Base object class
* This class is highest in framework. First, this class will be call,
* and run some require and logic of framework
* ___________________________________________________________________________
*/
namespace Overfull\Foundation\Base;
use Overfull\Foundation\Base\IBaseObject;

abstract class BaseObject implements IBaseObject{
	/**
	* Get instance class name of object
	*
	* return name of class (include namespace)
	*/
	public function className(){
		return get_class($this);
	}
}
?>