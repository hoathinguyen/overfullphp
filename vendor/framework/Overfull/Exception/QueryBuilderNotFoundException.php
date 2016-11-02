<?php
/*___________________________________________________________________________
* QueryBuilderNotFoundException object class
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class QueryBuilderNotFoundException extends OverfullException{
	function __construct($queryBuilder){
		parent::__construct("QueryBuilder \"$queryBuilder\" is not found", 1);
	}
}