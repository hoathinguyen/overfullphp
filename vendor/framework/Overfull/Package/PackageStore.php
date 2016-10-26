<?php
/*----------------------------------------------------
* Filename: PackageStore.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The Package store
* ----------------------------------------------------
*/
namespace Overfull\Package;
use Overfull\Foundation\Store;
use Overfull\Configure\Config;
use Overfull\Exception\PackageNotFoundException;
use Bag;

class PackageStore extends Store{
	function __construct(){
		$packages = Config::get('using.packages');
		if(!empty($packages)){
			foreach ($packages as $key => $value) {
				if(!class_exists($value['class'])){
					throw new PackageNotFoundException($value['class']);
				}
				Bag::package()->{$key} = new $value['class']();
				unset($value['class']);
				foreach ($value as $name => $setting) {
					Bag::package()->{$key}->{$name} = $setting;
				}
			}
		}
	}
}