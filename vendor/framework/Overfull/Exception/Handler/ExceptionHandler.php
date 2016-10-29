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
		static::showError($code, $message, $file, $line, 'Data exception', error_get_last());
	}

	public static function errorHandler($code, $message, $file, $line){
		static::showError($code, $message, $file, $line, 'Data exception', error_get_last());
	}

	public static function shutdown(){
		if ( ($errors = error_get_last()) ) {
			static::showError($errors['type'], $errors['message'], $errors['file'], $errors['line'], 'Syntax exception', $errors);
		}
	}

	public static function showExceptionObject($e){
		static::showError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), 'Exception', error_get_last());
	}

	private static function showError($code, $message, $file, $line, $title, $lastErrors){
		//ob_clean();
		$isShowDetail = Bag::config()->get('debug.display-errors');
		
		ob_clean();
		ob_start();
			require ROOT.DS.'vendor'.DS.'framework'.DS.'Overfull'.DS.'Exception'.DS.'Handler'.DS.'view'.DS.'debug.php';
		Bag::$response->content = ob_get_clean();
		Bag::$response->send();
		exit();
	}
}