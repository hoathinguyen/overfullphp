<?php
namespace Overfull\Events;

class Guide
{
    // List of events
    private $events = [];
    
    /**
     * Get event method
     * @param string $name
     * @return EventKeys
     */
    public function get($name)
    {
        return isset($this->events[$name]) ? $this->events[$name] : null;
    }

    /**
     * Register event method
     * @param string $name
     * @param string $element
     * @return $this
     */
    public function sign($name, $element = null)
    {
        if($e = $this->get($name))
        {
            foreach ($e as $key => $value) {
                $value($element);
            }
        }

        return $this;
    }
    
    /**
     * On event method
     * @param string $name
     * @param \Closure $func
     * @return $this
     */
    public function on($name, $func)
    {
        if(!($e = $this->get($name)))
        {
            $e = [];
        }

        $e[] = $func;

        $this->events[$name] = $e;

        return $this;
    }
}