<?php
/*___________________________________________________________________________
* ConfigFileNotFoundException object class
* This object handle some error when config file not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class ClassNotFoundException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $file
     */
    function __construct($file){
        parent::__construct("Class \"".$file."\" is not found", 503);
    }
}
