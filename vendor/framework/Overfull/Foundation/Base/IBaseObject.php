<?php
/*___________________________________________________________________________
* The Base interface
* This class is highest in framework. First, this class will be call,
* and run some require and logic of framework
* ___________________________________________________________________________
*/
namespace Overfull\Foundation\Base;

interface IBaseObject{
	/**
	* Get instance class name of object
	*
	* return name of class (include namespace)
	*/
	function className();
}
?>