<?php
/**
* Page not found object class
*
*/
namespace Overfull\Pattern\MVC\Exception;
use Overfull\Exception\OverfullException;

class ViewTypeNotFoundException extends OverfullException{
	function __construct($name){
		parent::__construct("View type \"".$name."\" is not found");
	}
}