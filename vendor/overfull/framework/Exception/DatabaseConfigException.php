<?php
/*___________________________________________________________________________
* DatabaseConfigException object class
* This object handle error when database config invalid
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class DatabaseConfigException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $use
     */
    function __construct($use){
        parent::__construct("Have an error with database config \"".$use."\"");
    }
}