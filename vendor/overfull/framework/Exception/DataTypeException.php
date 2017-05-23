<?php
/*___________________________________________________________________________
* ConnectionException object class
* This object handle error when connect to database is fail
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class DataTypeException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $name
     * @param string $in
     */
    function __construct($name, $in)
    {
        parent::__construct("The data type {$name} is not supported in {$in}");
    }
}