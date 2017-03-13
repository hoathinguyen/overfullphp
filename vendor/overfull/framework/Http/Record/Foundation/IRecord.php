<?php
/*----------------------------------------------------
* Filename: IRecord.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: This class is highest in framework. First, this class will be call,
* and run some require and logic of framework
* ----------------------------------------------------
*/
namespace Overfull\Http\Record\Foundation;

interface IRecord{
	/**
	 * Session read
	 *
	 * @date 2016/05/31
	 * @param $uid
	 * @return value|array|object|string
	 */
	function read( $name = false );

	/**
	 * check function
	 *
	 * @date 2016/05/31
	 * @param $name
	 * @return boolean
	 */
	function check( $name = false );

	/**
	 * write function
	 *
	 * @date 2016/05/31
	 * @param $name
	 * @param $value
	 */
	function write( $name = false, $value = false );

	/**
	 * delete function
	 *
	 * @date 2016/05/31
	 * @param $name
	 * @param $value
	 */
	function delete( $name = false );

	/**
	 * write function
	 *
	 * @date 2016/05/31
	 * @param $name
	 * @param $value
	 */
	function destroy();
}
?>