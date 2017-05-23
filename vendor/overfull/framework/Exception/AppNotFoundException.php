<?php
/*___________________________________________________________________________
* AppNotFoundException object class
* This object handle some error when app not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class AppNotFoundException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $app
     */
    function __construct($app){
        parent::__construct('App "'.$app.'" is not found', 1);
    }
}