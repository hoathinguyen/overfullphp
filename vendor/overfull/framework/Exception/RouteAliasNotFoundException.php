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

class RouteAliasNotFoundException extends OverfullException{
	function __construct($value){
		parent::__construct('Route alias "'.$value.'" is not found', 1);
	}
}