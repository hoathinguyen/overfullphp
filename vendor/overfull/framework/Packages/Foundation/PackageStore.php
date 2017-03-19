<?php
/*----------------------------------------------------
* Filename: PackageStore.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Package store
* ----------------------------------------------------
*/
namespace Overfull\Packages\Foundation;
use Overfull\Support\Store;
use Overfull\Exception\PackageNotFoundException;
use Bag;

class PackageStore extends Store{

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
		// Get config packages
		$packages = Bag::config()->get('packages.'.$name);

		if(!empty($packages)){
			if(!class_exists($packages['class'])){
				throw new PackageNotFoundException($packages['class']);
			}
			$this->attributes[$name] = new $packages['class']();
			unset($packages['class']);
			foreach ($packages as $key => $setting) {
				$this->attributes[$name]->{$key} = $setting;
			}
			return $this->attributes[$name];
		}
		
		throw new PackageNotFoundException($name);
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