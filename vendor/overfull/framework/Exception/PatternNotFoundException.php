<?php
/*___________________________________________________________________________
* PatternNotFoundException object class
* This object handle error when pattern to run application is not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class PatternNotFoundException extends OverfullException{
	function __construct($pattern){
		parent::__construct("Pattern \"$pattern\" is not found", 1);
	}
}