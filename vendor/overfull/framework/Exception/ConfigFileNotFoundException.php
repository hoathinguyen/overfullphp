<?php
/*___________________________________________________________________________
* ConfigFileNotFoundException object class
* This object handle some error when config file not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class ConfigFileNotFoundException extends OverfullException{
	function __construct($file){
		parent::__construct("Config file \"".$file."\" is not found", 503);
	}
}
