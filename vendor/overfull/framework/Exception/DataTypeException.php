<?php
/*___________________________________________________________________________
* ConnectionException object class
* This object handle error when connect to database is fail
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class DataTypeException extends OverfullException{
	function __construct($name, $in){
            parent::__construct("The data type {$name} is not supported in {$in}");
	}
}