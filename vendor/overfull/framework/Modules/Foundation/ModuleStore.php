<?php
/*----------------------------------------------------
* Filename: ModuleStore.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Module store
* ----------------------------------------------------
*/
namespace Overfull\Modules\Foundation;
use Overfull\Support\Store;
use Overfull\Exception\ModuleNotFoundException;
use Bag;

class ModuleStore extends Store{

	/**
	* __get method
	*
	* @param string $name
	* @return value
	*/
	public function __get($name){
		if(isset($this->attributes[$name])){
			return $this->attributes[$name];
		}
		// Get config Modules
		$modules = Bag::config()->get('modules.'.$name);

		if(!empty($modules)){
			if(!class_exists($modules['class'])){
				throw new ModuleNotFoundException($modules['class']);
			}
			$this->attributes[$name] = new $modules['class']();
			unset($modules['class']);
			foreach ($modules as $key => $setting) {
				$this->attributes[$name]->{$key} = $setting;
			}
			return $this->attributes[$name];
		}
		
		throw new ModuleNotFoundException($name);
	}

	/**
	 * Isset method
	 * @param string $name
	 * @return
	 */
	public function __isset($name){
		return isset($this->attributes[$name]);
	}
}