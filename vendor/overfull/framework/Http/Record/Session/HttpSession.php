<?php
/*----------------------------------------------------
* Session class object
* ----------------------------------------------------
*/
namespace Overfull\Http\Record\Session;
use Overfull\Support\Utility\ArrayUtil;

class HttpSession extends \Overfull\Foundation\Base\BaseObject
{
    // Uid
    private $uid = null;
    
    /**
     * __construct
     * @param string $uid
     */
    function __construct( $uid = "overfull" )
    {
        $this->start($uid);
    }
    
    /**
     * Session start
     *
     * @param $uid
     */
    public function start( $uid = "overfull" )
    {
        if(session_id() === ''){
            $this->uid = $uid;
            //session_start($uid);
            session_start();
        }
    }

    /**
     * Session read
     *
     * @param $uid
     * @return value|array|object|string
     */
    public function read( $name = false )
    {
        if ( $name ) {
                return ArrayUtil::access($_SESSION, $name);
        }
        
        return null;
    }
    
    /**
     * check function
     *
     * @param $name
     * @return boolean
     */
    public function check( $name = false )
    {
        if ( $name ) {
                return isset($_SESSION[$name]);
        }
        
        return false;
    }

    /**
     * write function
     *
     * @param $name
     * @param $value
     */
    public function write( $name = false, $value = false )
    {
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
    public function delete( $name = false )
    {
        unset($_SESSION[$name]);
    }

    /**
     * write function
     *
     * @param $name
     * @param $value
     */
    public function destroy()
    {
        session_destroy($this->uid);
    }
}