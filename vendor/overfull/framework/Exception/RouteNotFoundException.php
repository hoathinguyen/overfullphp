<?php
/*----------------------------------------------------
* Filename: MyStoreNotFoundException.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Package store
* ----------------------------------------------------
*/
namespace Overfull\Exception;

class RouteNotFoundException extends \Overfull\Exception\OverfullException
{
    /**
     * 
     * @param string $value
     */
    function __construct($value)
    {
        parent::__construct('Route "'.$value.'" is not found', 1);
    }
}