<?php
namespace Overfull\Console\Command;

abstract class Command
{
    private $query = "command:example";
    
    private $description = "The description";
    
    public function getQuery()
    {
        return $this->query;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
}