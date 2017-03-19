<?php
/*___________________________________________________________________________
* PageNotFoundException object class
* This object handle error when url is not found in routes
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class InstanceOfObjectException extends OverfullException{
	function __construct($class, $instance){
		parent::__construct("Object $class is not instance of $instance", 500);
	}
}
