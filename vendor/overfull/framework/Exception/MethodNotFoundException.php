<?php
/*___________________________________________________________________________
* ConfigFileNotFoundException object class
* This object handle some error when config file not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class MethodNotFoundException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $method
     * @param string $class
     */
    function __construct($method, $class){
        parent::__construct("Method '$method' is undefined in '$class'", 503);
    }
}
