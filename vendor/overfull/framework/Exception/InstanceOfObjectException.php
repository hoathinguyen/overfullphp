<?php
/*___________________________________________________________________________
* PageNotFoundException object class
* This object handle error when url is not found in routes
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class InstanceOfObjectException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $class
     * @param string $instance
     */
    function __construct($class, $instance){
        parent::__construct("Object $class is not instance of $instance", 500);
    }
}
