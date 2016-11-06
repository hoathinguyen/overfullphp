<?php
/*----------------------------------------------------
* Filename: ActionResult.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: CtrlResult between controller and view
* ----------------------------------------------------
*/
namespace Overfull\Patterns\MVC;
use Overfull\Utility\ArrayUtil;
use Bag;

class ActionResult{
	protected $data = null;

	function __construct($data){
		$this->data = $data;
	}

	/**
	 * Get method
	 * @param string $name
	 * @return this
	 */
	public function get($name = ''){
		return ArrayUtil::access($this->data, $name);
	}

	/**
	 * Get method
	 * @param string $name
	 * @return this
	 */
	public function withLastGet(){
		if(!empty($data = Bag::request()->get())){
			if(isset($data['__key__'])){
				Bag::myStore()->{"value_for_".$data['__key__']} = $data;
			} else {
				Bag::myStore()->value_for_default = $data;
			}
		}

		return $this;
	}

	/**
	 * Get method
	 * @param string $name
	 * @return this
	 */
	public function withLastPost(){
		if(!empty($data = Bag::request()->post())){
			if(isset($data['__key__'])){
				Bag::myStore()->{"value_for_".$data['__key__']} = $data;
			} else {
				Bag::myStore()->value_for_default = $data;
			}
		}

		return $this;
	}

	/**
	 * Get method
	 * @param string $name
	 * @return this
	 */
	public function withLastData(){
		if(!empty($data = Bag::request()->any())){
			if(isset($data['__key__'])){
				Bag::myStore()->{"value_for_".$data['__key__']} = $data;
			} else {
				Bag::myStore()->value_for_default = $data;
			}
		}

		return $this;
	}

	/**
	 * Get method
	 * @param array $data
	 * @return this
	 */
	public function form($data = []){
		if(!is_array($data)){
			return $this;
		}

		foreach ($data as $key => $value) {
			if(is_array($value) || is_object($value)){
				Bag::myStore()->{"value_for_$key"} = $value;
			}
		}
		
		return $this;
	}

	/**
	 * with method
	 * @param array $data
	 * @return this
	 */
	public function with($data){
		$this->data['gift']['data'] = array_merge($this->data['gift']['data'], $data);
		return $this;
	}
}