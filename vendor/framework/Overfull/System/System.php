<?php
namespace Overfull\System;

class System{
    public $php = null;
    
    function __construct() {
        $this->php = new PHP();
    }
}