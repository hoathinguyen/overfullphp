<?php
namespace Overfull\Events;

class Guide
{
	private $events = [];

	public function get($name)
	{
		return isset($this->events[$name]) ? $this->events[$name] : null;
	}

	/**
	 * Run
	 * @return this
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