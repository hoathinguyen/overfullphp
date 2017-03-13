<?php
/*___________________________________________________________________________
* ConfigFileNotFoundException object class
* This object handle some error when config file not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class ClassNotFoundException extends OverfullException{
	function __construct($file){
		parent::__construct("Class \"".$file."\" is not found", 503);
	}
}
