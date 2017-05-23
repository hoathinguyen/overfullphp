<?php
/*___________________________________________________________________________
* AppNotFoundException object class
* This object handle some error when app not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception\Handler;
use Bag;

class ExceptionHandler extends \Overfull\Foundation\Base\BaseObject
{
    /**
     * exceptionHandler
     * @param string $code
     * @param string $message
     * @param string $file
     * @param string $line
     */
    public static function exceptionHandler($code = null, $message = null, $file = null, $line = null)
    {
        if(is_object($code))
            static::showExceptionObject ($code);
        else
            static::showError($code, $message, $file, $line, 'Data exception', debug_backtrace());
    }
    
    /**
     * errorHandler
     * @param string $code
     * @param string $message
     * @param string $file
     * @param string $line
     */
    public static function errorHandler($code = null, $message = null, $file = null, $line = null)
    {
        if(is_object($code))
            static::showExceptionObject ($code);
        else
            static::showError($code, $message, $file, $line, 'Data exception', debug_backtrace());
    }
    
    /**
     * shutdown
     */
    public static function shutdown()
    {
        if ( ($errors = error_get_last()) ) {
            static::showError($errors['type'], $errors['message'], $errors['file'], $errors['line'], 'Syntax exception', debug_backtrace());
        }
    }
    
    /**
     * showExceptionObject
     * @param \Exception $e
     */
    public static function showExceptionObject($e)
    {
        static::showError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), 'Exception', debug_backtrace());
    }
    
    /**
     * showError
     * @param string $code
     * @param string $message
     * @param string $file
     * @param string $line
     * @param string $title
     * @param array $listStack
     */
    private static function showError($code, $message, $file, $line, $title, $listStack)
    {
        $handler = Bag::config()->get('core.error-handler');
        $isShowDetail = Bag::config()->get('core.error-display');
        
        if($handler && !Bag::error()->isHasLastError()){
            ob_clean();
            
            Bag::error()->set(compact('code','message','file','line','title','listStack'));
            
            Bag::route()->clearAttributes();
                    
            foreach($handler as $key => $value){
                Bag::route()->{$key} = $value;
            }
            
            if(!Bag::route()->method){
                Bag::route()->method = 'error'.$code;
            }
            
            // Run pattern
            Bag::pattern()->run();

            // return result
            Bag::response()->setStatusCode($code)->send();
            exit();
        }else{
            $isShowDetail = Bag::config()->get('core.error-display');
            
            ob_clean();
            ob_start();
            
            require ROOT.DS.'vendor'.DS.'overfull'.DS.'framework'.DS.'Exception'.DS.'Handler'.DS.'view'.DS.'debug.php';
            
            Bag::response()->content = ob_get_clean();
            Bag::response()->setStatusCode($code)->send();
            exit();
        }
    }
}