<?php
/*___________________________________________________________________________
* PatternNotFoundException object class
* This object handle error when pattern to run application is not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class PatternNotFoundException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $pattern
     */
    function __construct($pattern)
    {
        parent::__construct("Pattern \"$pattern\" is not found", 1);
    }
}