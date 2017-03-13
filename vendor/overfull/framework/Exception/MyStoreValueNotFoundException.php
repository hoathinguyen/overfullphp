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

class MyStoreNotFoundException extends OverfullException{
	function __construct($value){
		parent::__construct('MyStore value "'.$value.'" is not found', 1);
	}
}