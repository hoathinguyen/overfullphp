<?php
/*___________________________________________________________________________
* AppNotFoundException object class
* This object handle some error when app not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception\Handler;
use Overfull\Foundation\Base\BaseObject;
use Bag;
//use overfull\utility\PathUtil;

class ExceptionHandler extends BaseObject{
    
    public static function exceptionHandler($code, $message, $file, $line){
        static::showError($code, $message, $file, $line, 'Data exception', debug_backtrace());
    }

    public static function errorHandler($code, $message, $file, $line){
        static::showError($code, $message, $file, $line, 'Data exception', debug_backtrace());
    }

    public static function shutdown(){
        if ( ($errors = error_get_last()) ) {
            static::showError($errors['type'], $errors['message'], $errors['file'], $errors['line'], 'Syntax exception', debug_backtrace());
        }
    }

    public static function showExceptionObject($e){
        static::showError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), 'Exception', debug_backtrace());
    }

    private static function showError($code, $message, $file, $line, $title, $listStack){
        $handler = Bag::config()->get('errors.handler-settings');
        $isShowDetail = Bag::config()->get('errors.display-errors');
        
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
            Bag::response()->send();
            
            die();
        }else{
            $isShowDetail = Bag::config()->get('errors.display-errors');
            
            ob_clean();
            ob_start();
            
            require ROOT.DS.'vendor'.DS.'framework'.DS.'Overfull'.DS.'Exception'.DS.'Handler'.DS.'view'.DS.'debug.php';
            
            Bag::response()->content = ob_get_clean();
            
            Bag::response()->send();
            die();
        }
    }
}