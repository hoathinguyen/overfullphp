<?php
/**
* Page not found object class
*
*/
namespace Overfull\Patterns\MVC\Exception;
use Overfull\Exception\OverfullException;

class FileNotFoundException extends OverfullException{
	function __construct($file){
		parent::__construct("File \"".$file."\" is not found");
	}
}