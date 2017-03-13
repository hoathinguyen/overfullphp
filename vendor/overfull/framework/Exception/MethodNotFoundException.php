<?php
/*___________________________________________________________________________
* ConfigFileNotFoundException object class
* This object handle some error when config file not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class MethodNotFoundException extends OverfullException{
	function __construct($method, $class){
		parent::__construct("Method '$method' is undefined in '$class'", 503);
	}
}
