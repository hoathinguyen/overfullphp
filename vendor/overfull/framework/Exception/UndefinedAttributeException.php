<?php
/*___________________________________________________________________________
* AppNotFoundException object class
* This object handle some error when app not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class UndefinedAttributeException extends OverfullException{
    function __construct($name, $class){
        parent::__construct('Attribute "'.$name.'" is undefined in "'.$class.'"', 1);
    }
}