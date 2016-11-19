<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Overfull\Database\Eloquent\Relations;

abstract class Relation extends \Overfull\Foundation\Base\BaseObject{
    public function data(){
        return [];
    }
    
    public function execute(){
        return $this;
    }
    
    public function schema(){
        return $this;
    }
}