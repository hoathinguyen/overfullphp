<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Overfull\Database\Eloquent\Relations;

class BelongsTo extends \Overfull\Database\Eloquent\Relations\Relation{
    public function run(){
        $this->data($this->getSchema()->first());
        return $this;
    }
}
