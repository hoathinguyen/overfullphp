<?php
/*----------------------------------------------------
* Filename: PackageNotFoundException.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Package store
* ----------------------------------------------------
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class PackageNotFoundException extends OverfullException{
	function __construct($package){
		parent::__construct('Package "'.$package.'" is not found',1);
	}
}