<?php
/*----------------------------------------------------
* Filename: BaseQueryBuilder.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The BaseQueryBuilder will return syntax to execute
* ----------------------------------------------------
*/
namespace Overfull\Database\Schema\Foundation;
use Overfull\Database\Schema\Foundation\IBaseQueryBuilder;

abstract class BaseQueryBuilder implements IBaseQueryBuilder{
	protected $attributes = [];

	protected $operators = [];

	protected $joins = [];

	/**
	 * OperatorSyntax
	 *
	 */
	protected function operatorSyntax($key){
		return isset($this->operators[$key]) ? $this->operators[$key] : $key;
	}

	/**
	 * JoinSyntax
	 *
	 */
	protected function joinSyntax($key){
		return isset($this->joins[$key]) ? $this->joins[$key] : $key;
	}

	/**
     * Auto call when set value for object attributes
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
	public function __set($name, $value){
		$this->attributes[$name] = $value;
	}

    /**
     * Auto call when get value for object attributes
     *
     * @param string $name
     * @return mixed
     */
	public function __get($name){
		if(!isset($this->attributes[$name])){
			return null;
		}

		return $this->attributes[$name];
	}

	/**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key){
    	return isset($this->attributes[$key]);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key){
        unset($this->attributes[$key]);
    }

	/**
     * attributes
     *
     * @param string $name
     * @return mixed
     */
	public function getAttributes($attributes = null){
		if(!$attributes){
			return $this->attributes;
		}

		$this->attributes = $attributes;
		
		return $this;
	}

	/**
	 * Clear sql
	 *
	 * @return void
	 */
	public function clear(){
		$this->attributes['values'] = [];
		$this->attributes['where'] = [];
		$this->attributes['columns'] = ['*'];
		$this->attributes['joins'] = [];
		$this->attributes['offset'] = false;
		$this->attributes['limit'] = false;
                $this->attributes['orders'] = [];
		return $this;
	}
}