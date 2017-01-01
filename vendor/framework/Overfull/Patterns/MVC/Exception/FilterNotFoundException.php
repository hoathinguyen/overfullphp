<?php
/**
* Page not found object class
*
*/
namespace Overfull\Patterns\MVC\Exception;
use Overfull\Exception\OverfullException;

class FilterNotFoundException extends OverfullException{
	function __construct($file){
		parent::__construct("Filter \"".$file."\" is not found");
	}
}
