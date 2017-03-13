<?php
/*___________________________________________________________________________
* QueryBuilderNotFoundException object class
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class SchemaNotFoundException extends OverfullException{
	function __construct($schema){
		parent::__construct("Schema \"$schema\" is not found", 1);
	}
}