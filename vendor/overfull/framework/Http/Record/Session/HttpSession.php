<?php
/*----------------------------------------------------
* Session class object
* ----------------------------------------------------
*/
namespace Overfull\Http\Record\Session;
use Overfull\Foundation\Base\BaseObject;
use Overfull\Utility\ArrayUtil;

class HttpSession extends BaseObject{
	private $uid = null;

	function __construct( $uid = "overfull" ){
		$this->start($uid);
	}
	/**
	 * Session start
	 *
	 * @date 2016/05/31
	 * @param $uid
	 */
	public function start( $uid = "overfull" ){
		if(session_id() === ''){
			$this->uid = $uid;
			//session_start($uid);
                        session_start();
		}
	}

	/**
	 * Session read
	 *
	 * @date 2016/05/31
	 * @param $uid
	 * @return value|array|object|string
	 */
	public function read( $name = false ){
		if ( $name ) {
			return ArrayUtil::access($_SESSION, $name);
		}
		return null;
	}
	/**
	 * check function
	 *
	 * @date 2016/05/31
	 * @param $name
	 * @return boolean
	 */
	public function check( $name = false ){
		if ( $name ) {
			return isset($_SESSION[$name]);
		}
		return false;
	}

	/**
	 * write function
	 *
	 * @date 2016/05/31
	 * @param $name
	 * @param $value
	 */
	public function write( $name = false, $value = false ){
		if ( !$name ) return;

		$_SESSION[$name] = $value;
	}

	/**
	 * delete function
	 *
	 * @date 2016/05/31
	 * @param $name
	 * @param $value
	 */
	public function delete( $name = false ){
		unset($_SESSION[$name]);
	}

	/**
	 * write function
	 *
	 * @date 2016/05/31
	 * @param $name
	 * @param $value
	 */
	public function destroy(){
		session_destroy($this->uid);
	}
}