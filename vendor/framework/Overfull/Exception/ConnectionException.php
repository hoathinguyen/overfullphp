<?php
/*___________________________________________________________________________
* ConnectionException object class
* This object handle error when connect to database is fail
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class ConnectionException extends OverfullException{
	function __construct($name){
		parent::__construct("Could not connect to \"".$name."\" in config");
	}
}