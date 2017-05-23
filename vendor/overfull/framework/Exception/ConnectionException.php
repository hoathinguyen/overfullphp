<?php
/*___________________________________________________________________________
* ConnectionException object class
* This object handle error when connect to database is fail
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class ConnectionException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $name
     */
    function __construct($name)
    {
        parent::__construct("Could not connect to \"".$name."\" in config");
    }
}