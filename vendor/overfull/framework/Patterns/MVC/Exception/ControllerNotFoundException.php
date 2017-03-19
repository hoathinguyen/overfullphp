<?php
/**
* Page not found object class
*
*/
namespace Overfull\Patterns\MVC\Exception;
use Overfull\Exception\OverfullException;

class ControllerNotFoundException extends OverfullException{
	function __construct($file){
		parent::__construct("Controller \"".$file."\" is not found");
	}
}