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

interface IRecord
{
    /**
     * Session read
     *
     * @param $uid
     * @return value|array|object|string
     */
    function read( $name = false );

    /**
     * check function
     *
     * @param $name
     * @return boolean
     */
    function check( $name = false );

    /**
     * write function
     *
     * @param $name
     * @param $value
     */
    function write( $name = false, $value = false );

    /**
     * delete function
     *
     * @param $name
     * @param $value
     */
    function delete( $name = false );

    /**
     * write function
     *
     * @param $name
     * @param $value
     */
    function destroy();
}
?>