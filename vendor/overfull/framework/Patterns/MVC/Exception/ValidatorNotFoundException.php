<?php
/**
* Page not found object class
*
*/
namespace Overfull\Patterns\MVC\Exception;
use Overfull\Exception\OverfullException;

class ValidatorNotFoundException extends OverfullException{
	function __construct($name){
		parent::__construct("Validator \"".$name."\" is not found");
	}
}