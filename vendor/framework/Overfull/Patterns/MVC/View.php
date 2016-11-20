<?php
/*___________________________________________________________________________
* The View object class
* ___________________________________________________________________________
*/
namespace Overfull\Patterns\MVC;

use Overfull\Patterns\MVC\Foundation\IView;
use Overfull\Patterns\MVC\Exception\ViewTypeNotFoundException;
use Overfull\Utility\PathUtil;
use Overfull\Utility\URLUtil;
use Overfull\Patterns\MVC\Exception\FileNotFoundException;
use Overfull\Configure\Config;
use Overfull\Http\Response\ResponseFormat;
use Overfull\Http\Response\Response;
use Bag;
use Overfull\Template\Otp;

class View extends Otp implements IView{
	public $template = null;

	protected $contentPath = null;

	protected $layoutPath = null;

	protected $helpers = [];

	protected $variables = [];

	protected $content = '';

	protected $layout = false;
	
	function __construct(){
		$this->contentPath = 'Views'.DS.'Contents';
		$this->layoutPath = 'Views'.DS.'Layouts';
	}

	/**
	* Run method
	* This handle something to get view result
	*/
	public function run($actionResult){
		// Check if view type is exist
		if(!method_exists($this, $actionResult->get('type'))){
			throw new ViewTypeNotFoundException($actionResult->get('type'));
		}

		return $this->{$actionResult->get('type')}($actionResult->get('gift'));
	}

	/**
	 * Handle view with render view
	 *
	 * @date 2016/05/21
	 * @param mixed $gift
	 * @param array $variables
	 * @return string
	 */
	protected function render($gift, $variables = []){
		if(is_array($gift)){
			if(!empty($gift['otp']['helpers'])){
				$this->helpers = $gift['otp']['helpers'];
			}

			if(!empty($gift['data'])){
				$this->variables = $gift['data'];
			}

			// Set layout
			$this->layout = !empty($gift['otp']['layout']) ? $gift['otp']['layout'] : false;

			$this->content = $this->__readOtp([
				'file' => $this->contentPath.DS.(!empty($gift['otp']['root']) ? $gift['otp']['root'].DS : '' ).$gift['otp']['content'],
				'variables' => $this->variables]);

			if($this->layout){
				return $this->__readOtp([
				'file' => $this->layoutPath.DS.$this->layout,
				'variables' => $this->variables]);
			}

			return $this->content;
		}

		return $this->__readOtp([
			'file' => $this->contentPath.DS.$gift,
			'variables' => $variables]);
	}

	/**
	 * Get content
	 *
	 * @date 2016/05/21
	 * @param mixed $gift
	 * @return string
	 */
	protected final function content(){
		return $this->content;
	}

	/**
	 * Handle view with json
	 *
	 * @date 2016/05/21
	 * @param mixed $gift
	 * @return string
	 */
	protected final function json($gift){
		Bag::$response->format = ResponseFormat::JSON;
		return json_encode($gift['data']);
	}

	/**
	 * Hanlde view and return view as text
	 *
	 * @date 2016/05/21
	 * @param mixed $gift
	 * @return string
	 */
	protected final function html($gift){
		Bag::$response->format = ResponseFormat::HTML;
		return $gift['data'];
	}

	/**
	 * Hanlde view and return value as xml
	 *
	 * @date 2016/05/21
	 * @param mixed $gift
	 * @return string
	 */
	protected final function xml($gift){
		Bag::$response->format = ResponseFormat::XML;
		return 'render';
	}

	/**
	 * __file method
	 *
	 * @date 2016/05/21
	 * @param mixed $gift
	 * @return string
	 */
	protected final function file($gift){
		return 'render';
	}

	/**
	 * Handle view as redirect
	 *
	 * @date 2016/05/21
	 * @param mixed $gift
	 * @return string
	 */
	protected final function redirect($gift){
		Bag::$response->format = ResponseFormat::HTML;
		$html = '<!DOCTYPE html>
				<html><head><title>Redirecting...</title><meta http-equiv="refresh" content="0; url='.URLUtil::to($gift['data']).'" /></head><body></body></html>';

		return $html;
	}

	/**
	 * read file otp
	 *
	 * @date 2016/05/21
	 * @param array $otp
	 * @return string
	 */
	protected final function __readOtp($otp){
		try{
			$____content = '';
			// Create variable
			foreach ($otp['variables'] as $key => $value) {
				$$key = $value;
			}

			$otp['file'] = PathUtil::convert($otp['file']);

			$appRoot = Bag::config()->get('app.root');

			$storageFile = PathUtil::getFull('storage'.DS.'cache'.DS.'otp'.DS.base64_encode($appRoot.DS.$otp['file']).'.otp');

			if ( !file_exists($storageFile) || Bag::config()->get('core.develop')) {
				$ext = Bag::config()->get('core.otp.ext');
				
				$fullFile = PathUtil::getFull($appRoot.DS.$otp['file'].'.'.($ext ? $ext : 'php'));

				// Get content of view
				if ( !file_exists($fullFile) ) {
					throw new FileNotFoundException($fullFile);
				}

				$____content = file_get_contents($fullFile);

				foreach ($this->tags as $key => $value) {
					//dd($key);
					$____content = preg_replace($key, $value, $____content);
				}

				$namespace = "";

				$helpers = Bag::config()->get('core.otp.helpers');
				$helpers = !empty($helpers) ? $helpers : [];

				foreach ( $helpers as $key => $value) {
					$namespace .= "use {$value} as {$key};";
				}

				foreach ( $this->helpers as $key => $value) {
					$namespace .= "use {$value} as {$key}; ";
				}

				file_put_contents($storageFile, "<?php {$namespace} ?>".$____content);
			}

			ob_start();

			require $storageFile;

			$____content = ob_get_clean();

			return $____content;
		} catch (Exception $e) {
			//ob_end_clean();
			throw $e;
		}
	}
}