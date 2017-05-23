<?php
/*___________________________________________________________________________
* QueryBuilderNotFoundException object class
* ___________________________________________________________________________
*/
namespace Overfull\Exception;

class SchemaNotFoundException extends \Overfull\Exception\OverfullException
{
    /**
     * __construct
     * @param string $schema
     */
    function __construct($schema)
    {
        parent::__construct("Schema \"$schema\" is not found", 1);
    }
}