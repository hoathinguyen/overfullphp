<?php
/*___________________________________________________________________________
* AppNotFoundException object class
* This object handle some error when app not found
* ___________________________________________________________________________
*/
namespace Overfull\Exception\Handler;
use Overfull\Foundation\Base\BaseObject;
use Overfull\Configure\Config;
use Bag;
//use overfull\utility\PathUtil;

class ExceptionHandler extends BaseObject{
	public static function exceptionHandler($code, $message, $file, $line){
		static::showError($code, $message, $file, $line, 'Data exception');
	}

	public static function errorHandler($code, $message, $file, $line){
		static::showError($code, $message, $file, $line, 'Data exception');
	}

	public static function shutdown(){
		if ( ($errors = error_get_last()) ) {
			static::showError($errors['type'], $errors['message'], $errors['file'], $errors['line'], 'Syntax exception');
		}
	}

	public static function showExceptionObject($e){
		static::showError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), 'Exception');
	}

	private static function showError($code, $message, $file, $line, $title){
		//ob_clean();
		$isShowDetail = Config::get('debug.display-errors');
		
		ob_clean();
		ob_start();
			require ROOT.DS.'vendor'.DS.'framework'.DS.'Overfull'.DS.'Exception'.DS.'Handler'.DS.'view'.DS.'debug.php';
		Bag::$response->content = ob_get_clean();
		Bag::$response->send();
		exit();
	}
}