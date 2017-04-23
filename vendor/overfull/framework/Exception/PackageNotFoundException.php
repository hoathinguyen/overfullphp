<?php
/*----------------------------------------------------
* Filename: ModuleNotFoundException.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Package store
* ----------------------------------------------------
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class ModuleNotFoundException extends OverfullException{
	function __construct($module){
		parent::__construct('Module "'.$module.'" is not found',1);
	}
}