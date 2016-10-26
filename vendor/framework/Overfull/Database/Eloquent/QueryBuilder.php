<?php
namespace Overfull\Database\Eloquent;
use Overfull\Foundation\Base\BaseObject;

class QueryBuilder extends BaseObject{
	private $sql = "";

	/**
	 * append method
	 *
	 * @author ToiTL
	 * @date 2016/02/25
	 */
	public final function append( $str = false ){
		if ($str !== false) {
			$this->sql = $this->sql.' '.$str;
		}
	}
	/**
	 * setParameters method
	 *
	 * @author ToiTL
	 * @date 2016/02/25
	 */
	public final function setParameters( $parameters = array() ){
		if ( !is_array($parameters) ) {
			return;
		}
		
		foreach ($parameters as $key => $value) {
			if ( is_array($value) ) {
				$val = "";
				$length = count($value);
				$i = 0;

				foreach ($value as $k => $v) {
					$v = addslashes($v);
					//$v = addcslashes($v, '-');
					if ( $i < $length - 1 ) {
						$val .= $v.', ';
					} else {
						$val .= $v;
					}
					$i++;
				}

				$this->sql = str_replace( '@['.$key."]" , $val, $this->sql);

			} else {
				$val = addslashes($value);
				//$val = addcslashes($val, '-');
				$this->sql = str_replace( '@'.$key , $val, $this->sql);
			}
		}
	}

	/**
	 * get method
	 *
	 * @author ToiTL
	 * @date 2016/02/25
	 */
	public function get(){
		return $this->sql;
	}

	/**
	 * destroy method
	 *
	 * @author ToiTL
	 * @date 2016/02/19
	 */
	public function destroy(){
		$this->sql = "";
	}
}