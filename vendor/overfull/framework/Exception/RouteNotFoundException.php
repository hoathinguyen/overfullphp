<?php
/*----------------------------------------------------
* Filename: MyStoreNotFoundException.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Package store
* ----------------------------------------------------
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class RouteNotFoundException extends OverfullException{
	function __construct($value){
		parent::__construct('Route "'.$value.'" is not found', 1);
	}
}