<?php
/**
* Page not found object class
*
*/
namespace Overfull\Pattern\MVC\Exception;
use Overfull\Exception\OverfullException;

class MethodNotFoundException extends OverfullException{
	function __construct($file){
		parent::__construct("Action method \"".$file."\" is not found");
	}
}