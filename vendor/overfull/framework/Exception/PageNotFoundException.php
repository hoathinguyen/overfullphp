<?php
/*___________________________________________________________________________
* PageNotFoundException object class
* This object handle error when url is not found in routes
* ___________________________________________________________________________
*/
namespace Overfull\Exception;
use Overfull\Exception\OverfullException;

class PageNotFoundException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     */
    function __construct()
    {
        parent::__construct('Page is not found', 404);
    }
}
