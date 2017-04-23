<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Overfull\Routing;

class DomainConfig
{
    private $domains = [];
    private $validDomain = null;
    
    /**
     * Add domain
     * @param array or string $domains
     * @param mixed $value
     * @return $this
     */
    public function add($domains, $value = null)
    {
        $domain = new \Overfull\Routing\Domain($domains, $value);

        $this->domains[] = $domain;

        return $this;
    }
    
    /**
     * set Default value for domain
     * @param type $data
     * @return $this
     */
    public function setDefault($data)
    {
        $this->add(['{sub}.{domain}.{ext}', '{domain}.{ext}', 'www.{domain}.{ext}'], $data);
        return $this;
    }
    
    /**
     * Get valid domain
     * @return \Overfull\Routing\Domain
     */
    public function getValid()
    {
        if($this->validDomain)
        {
            return $this->validDomain;
        }
        
        // Get current domain
        $currentDomain = strtolower(\Bag::request()->getHost().\Bag::request()->getURI(false));
        
        // Loop with list of domain that defined
        foreach ($this->domains as $key => $value) {
            if($value->isValid($currentDomain))
            {
                // Get and run valid data
                $this->validDomain = $value;
                return $this->validDomain->run();
            }
        }
        
        return null;
    }
}

