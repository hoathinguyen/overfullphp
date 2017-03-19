<?php
/*___________________________________________________________________________
* DatabaseConfigException object class
* This object handle error when database config invalid
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class DatabaseConfigException extends OverfullException{
	function __construct($use){
		parent::__construct("Have an error with database config \"".$use."\"");
	}
}