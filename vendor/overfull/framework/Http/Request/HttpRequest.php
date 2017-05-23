<?php
/*----------------------------------------------------
* Filename: Request.php
* Author: Overfull.net
* Date: 2016/05/20
* Description: The Request object class
* ----------------------------------------------------
*/
namespace Overfull\Http\Request;

use Overfull\Http\Foundation\BaseRequest;
use Overfull\Support\Utility\ArrayUtil;

class HttpRequest extends BaseRequest
{
    /**
     * Get full url method
     * @return string
     */
    public function getFullUrl()
    {
        return $this->getUrl(true);
    }

    /**
    * Uri method
    * This method will be return uri of request
    * @date 2016/05/21
    *
    * @return string $uri
    */
    public function getUri($withParameter = true)
    {
        if(!$withParameter)
            return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        else
            return $_SERVER['REQUEST_URI'];
    }

    /**
    * Uri method
    * This method will be return uri of request
    * @date 2016/05/21
    *
    * @return string $uri
    */
    public function getUrl($withParameter = true)
    {
        return $this->getProtocol(true).$this->getHost().$this->getUri($withParameter);
    }

    /**
     * host method
     *
     * @return string
     */
    public function getHost()
    {
            return $_SERVER['HTTP_HOST'];
    }

    /**
     * port method
     *
     * @return string
     */
    public function getPort()
    {
            return $_SERVER['SERVER_PORT'];
    }

    /**
     * name method
     *
     * @return string
     */
    public function getServerName()
    {
            return $_SERVER['SERVER_NAME'];
    }

    /**
     * Get browser method
     * @param string $name
     * @param boolean $returnArray
     * @return mixed
     */
    public function getBrowser($name = null, $returnArray = true)
    {
            return get_browser($name, $returnArray);
    }

    /**
     * docRoot method
     *
     * @return string
     */
    public function getDocRoot()
    {
            return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * schema method
     *
     * @return string
     */
    public function getProtocol($asPath = false)
    {
        if($asPath){
            return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        }

        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
    }

    /**
     * Get client ip method
     * @return string
     */
    public function getClientIP()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    /**
    * UriArray method
    * This method will be return uri of request
    * @date 2016/05/21
    *
    * @return string $uri
    */
    public function getUriArray($withParameter = true)
    {
        // Return value
        $uris = explode('/', $this->getUri($withParameter));
        array_shift($uris);

        $uris = array_filter($uris, function($value) { return $value ? true : false; });

        return array_filter($uris);
    }

    /**
     * Is method
     *
     * @date 2016/02/27
     * @return boolean
     */
    public function is( $rqs = false )
    {
        if ( $rqs == false ) {
            return false;
        } else if ( is_array($rqs) ) {
            foreach ($rqs as $key => $value) {
                if ( $this->getMethod() == strtoupper($value) || strtoupper($value) == 'ANY') {
                    return true;
                }
            }
            
            return false;
        } else {
            if ( $this->getMethod() == strtoupper($rqs) || strtoupper($rqs) == 'ANY') {
                return true;
            }

            return false;
        }
    }

    /**
     * Check if request is from ajax
     *
     * @param string/array method
     * @return boolean
     */
    public function isPost()
    {
        return $this->is('POST');
    }

    /**
     * Check if request is from ajax
     *
     * @param string/array method
     * @return boolean
     */
    public function isGet()
    {
            return $this->is('GET');
    }

    /**
     * Check if request is from ajax
     *
     * @param string/array method
     * @return boolean
     */
    public function isAjax($method = false)
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // If do not need check method, so return true
            if(!$method){
                return true;
            }

            // Call check method
            return $this->is($method);
        }

        return false;
    }

    /**
     * method
     *
     * @return boolean
     */
    public function getMethod()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * subdomain method
     *
     * @return string
     */
    public function getSubdomain()
    {
        $sub = explode(".",$_SERVER['HTTP_HOST']);

        if(count($sub) == 3 && $sub[0] != 'www'){
                // Check exists setting
                return $sub[0];
        }

        return null;
    }

    /**
     * publicPath method
     *
     * @return string
     */
    public function getPublicPath()
    {
        return str_replace(
                '\\',
                '/',
                substr(
                        dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))),
                        strlen($this->getDocRoot())
                )
        );
    }

    /**
     * Get method
     *
     * @param string $name
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getProtocol(true).$this->getHost();
    }

    /**
     * Get method
     *
     * @param string $name
     * @return string
     */
    public function getRoot()
    {
        return $this->getProtocol(true).$this->getHost().$this->getPublicPath();
    }

    /**
     * Get method
     *
     * @param string $name
     * @return string
     */
    public function get($name = false, $asArray = false)
    {
        if(!$name) {
            if($asArray){
                    return $_GET;
            }
            return new \Overfull\Http\Request\RequestData($_GET);
        }

        return ArrayUtil::access($_GET, $name);
    }

    /**
     * getAsArray
     *
     * @param string $name
     * @return string
     */
    public function getAsArray()
    {
        return $this->get(false, true);
    }
    
    /**
     * isGetExists
     * @param string $name
     * @return boolean
     */
    public function isGetExists($name)
    {
        return array_key_exists($name, $_GET);
    }

    /**
     * post method
     *
     * @param string $name
     * @return string
     */
    public function post($name = false, $asArray = false)
    {
        if(!$name) {
            if($asArray){
                return $_POST;
            }
            
            return new \Overfull\Http\Request\RequestData($_POST);
        }
        
        return ArrayUtil::access($_POST, $name);
    }
    
    /**
     * isPostExists
     * @param string $name
     * @return boolean
     */
    public function isPostExists($name)
    {
        return array_key_exists($name, $_POST);
    }

    /**
     * postAsArray
     *
     * @param string $name
     * @return string
     */
    public function postAsArray()
    {
        return $this->post(false, true);
    }

    /**
     * 
     * @param string $name
     * @param boolean $asArray
     * @return \Overfull\Http\Request\RequestData
     */
    public function any($name = false, $asArray = false)
    {
        if(!$name) {
            if($asArray){
                return $_REQUEST;
            }

            return new \Overfull\Http\Request\RequestData($_REQUEST);
        }

        return ArrayUtil::access($_REQUEST, $name);
    }

    /**
     * Check if is exists key with any method
     * @param string $name
     */
    public function isAnyExists($name)
    {
        return array_key_exists($name, $_REQUEST);
    }

    /**
     * anyAsArray method
     *
     * @param string $name
     * @return string
     */
    public function anyAsArray()
    {
        return $this->any(false, true);
    }

    /**
     * post method
     *
     * @param string $name
     * @return string
     */
    public function file($name)
    {
        $files = $this->findAndConvertFiles();
        return ArrayUtil::access($files, $name);
    }
    
    /**
     * isFileExists
     * @param string $name
     * @return boolean
     */
    public function isFileExists($name)
    {
        return array_key_exists($name, $_FILES);
    }

    /**
     * Files
     * @param type $asArray
     * @return type
     */
    public function files($asArray = false)
    {
        $files = $this->findAndConvertFiles();

        if($asArray){
            return (object)$files;
        }

        return $files;
    }

    /**
     * findAndConvertFiles
     */
    private function findAndConvertFiles()
    {
        if(!isset($this->__temp_files)){
            $this->__temp_files = [];
            if(!empty($_FILES)){
                foreach($_FILES as $key => $file){
                    $this->__temp_files[$key] = new \Overfull\Http\Request\RequestFile($file);
                }
            }
        }

        return $this->__temp_files;
    }
}
