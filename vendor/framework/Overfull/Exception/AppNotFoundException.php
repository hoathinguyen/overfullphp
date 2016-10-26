<?php
/*___________________________________________________________________________
* AppNotFoundException object class
* This object handle some error when app not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class AppNotFoundException extends OverfullException{
	function __construct($app){
		parent::__construct('App "'.$app.'" is not found', 1);
	}
}