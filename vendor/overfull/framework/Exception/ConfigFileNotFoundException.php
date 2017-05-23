<?php
/*___________________________________________________________________________
* ConfigFileNotFoundException object class
* This object handle some error when config file not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class ConfigFileNotFoundException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $file
     */
    function __construct($file){
        parent::__construct("Config file \"".$file."\" is not found", 503);
    }
}
