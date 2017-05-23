<?php
/*----------------------------------------------------
* Filename: MyStoreNotFoundException.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Package store
* ----------------------------------------------------
*/
namespace Overfull\Exception;

class MyStoreNotFoundException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $value
     */
    function __construct($value)
    {
        parent::__construct('MyStore value "'.$value.'" is not found', 1);
    }
}