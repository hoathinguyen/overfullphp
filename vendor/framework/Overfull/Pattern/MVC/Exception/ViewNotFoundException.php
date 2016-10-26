<?php
/**
* Page not found object class
*
*/
namespace Overfull\Pattern\MVC\Exception;
use Overfull\Exception\OverfullException;

class ViewNotFoundException extends OverfullException{
	function __construct($name){
		parent::__construct("View \"".$name."\" is not found");
	}
}