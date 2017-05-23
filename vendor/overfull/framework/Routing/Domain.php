<?php
/*----------------------------------------------------
* Filename: RouteAlias.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The detail of route object
* ----------------------------------------------------
*/
namespace Overfull\Routing;

use Bag;

class Domain extends \Overfull\Foundation\Base\BaseObject
{
    private $attributes = [];

    private $temp = [
        'domain' => [],
        'data' => null
    ];

    function __construct($domain, $temp = null)
    {
        if($domain)
        {
            if(is_string($domain))
            {
                $this->temp['domain'] = [$domain];
            }
            else
            {
                $this->temp['domain'] = $domain;
            }
        }

        $this->temp['data'] = $temp;
    }

    public function setNamespace($value)
    {
        $this->set('namespace',$value);
        return $this;
    }

    public function setDomain($value)
    {
        $this->set('domain', $value);
        return $this;
    }

    public function addDomain($value)
    {
        $this->add('domain', $value);
        return $this;
    }

    public function setPrefix($value)
    {
        $this->set('prefix', $value);
        return $this;
    }

    public function setRoot($value)
    {
        $this->set('root', $value);
        return $this;
    }

    public function setAlias($value)
    {
        $this->set('alias', $value);
        return $this;
    }

    public function setBase($value)
    {
        $this->set('base', $value);
        return $this;
    }

    public function set($name, $value = null)
    {
        if(is_array($name) && !$value)
        {
            $this->attributes = $name;
        }
        else
        {
            $this->attributes[$name] = $value;
        }

        return $this;
    }

    public function add($name, $value)
    {
        $this->attributes[$name][] = $value;

        return $this;
    }

    public function getNamespace()
    {
        return $this->get('namespace');
    }

    public function getDomain()
    {
        return $this->get('domain');
    }

    public function getPrefix()
    {
        return $this->get('prefix');
    }

    public function getRoot()
    {
        return $this->get('root');
    }

    public function getAlias()
    {
        return $this->get('alias');
    }

    public function getBase()
    {
        return $this->get('base');
    }

    public function get($name = false)
    {
        if(!$name)
        {
            return $this->attributes;
        }

        return $this->attributes[$name];
    }

    /**
     * Run
     */
    public function run()
    {
        if($this->temp['data'])
        {
            // Check if is array
            if(is_array($this->temp['data']))
            {
                foreach ($this->temp['data'] as $key => $value) {
                    $this->set($key, $value);
                }
            }
            // Check if is object
            elseif (is_object($this->temp['data']))
            {
                $func = $this->temp['data'];
                $func($this);
            }
        }

        return $this;
    }

    /*
    * Get config method
    * This method will be call config object and set value config to this config object.
    */
    public function isValid($currentDomain)
    {
        // Check if have config in app
        $domains = $this->temp['domain'];

        foreach ($domains as $key => $domain) {
            $regex = str_replace('/', "\/", $domain);

            $regex = str_replace('{sub}', '([a-zA-Z0-9\-]+)', $regex);
            $regex = str_replace('{domain}', '([a-zA-Z0-9\-]+)', $regex);
            $regex = str_replace('{ext}', '([a-zA-Z0-9]+)', $regex);
            $regex = str_replace('{folder}', '([a-zA-Z0-9\-]+)', $regex);
            
            $currentDomain = rtrim($currentDomain, '/');
            
            // Check if correct domain
            if(preg_match("/^".$regex."(|\/(.*))$/", $currentDomain)){
                $uris = explode('/', $domain);
                array_shift($uris);

                $this->setBase(count($uris));
                $this->setPrefix(implode('/', $uris));
                $this->setDomain($domain);

                return true;
            }
        }

        return false;
    }
}