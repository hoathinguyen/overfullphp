<?php
/*___________________________________________________________________________
* AppNotFoundException object class
* This object handle some error when app not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class UndefinedAttributeException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $name
     * @param string $class
     */
    function __construct($name, $class)
    {
        parent::__construct('Attribute "'.$name.'" is undefined in "'.$class.'"', 1);
    }
}