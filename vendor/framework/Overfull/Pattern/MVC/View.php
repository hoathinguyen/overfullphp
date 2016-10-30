<?php
/*___________________________________________________________________________
* The View object class
* ___________________________________________________________________________
*/
namespace Overfull\Pattern\MVC;

use Overfull\Pattern\MVC\Foundation\IView;
use Overfull\Pattern\MVC\Exception\ViewTypeNotFoundException;
use Overfull\Utility\PathUtil;
use Overfull\Pattern\MVC\Exception\FileNotFoundException;
use Overfull\Configure\Config;
use Overfull\Http\Response\ResponseFormat;
use Overfull\Http\Response\Response;
use Bag;

class View implements IView{
	public $template = null;

	protected $contentPath = 'Views'.DS.'Otps'.DS.'Contents';

	protected $layoutPath = 'Views'.DS.'Otps'.DS.'Layouts';

	protected $helpers = [];

	protected $variables = [];

	protected $content = '';

	protected $layout = false;

	/**
	* Run method
	* This handle something to get view result
	*/
	public function run($setting){
		// Check if view type is exist
		if(!method_exists($this, $setting['type'])){
			throw new ViewTypeNotFoundException($setting['type']);
		}

		//$this->template = new Object();

		return $this->{$setting['type']}($setting['gift']);
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
			$this->layout = isset($gift['otp']['layout']) ? $gift['otp']['layout'] : false;

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
				<html><head><title>redirect</title><meta http-equiv="refresh" content="0; url='.$gift['data'].'" /></head><body></body></html>';

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
			$content = '';
			// Create variable
			foreach ($otp['variables'] as $key => $value) {
				$$key = $value;
			}

			$storageFile = PathUtil::getFull('storage'.DS.'cache'.DS.'otp'.DS.base64_encode($otp['file']).'.otp');

			if ( !file_exists($storageFile) || Bag::config()->get('core.alway-build-otp')) {
				$ext = Bag::config()->get('core.otp.ext');
				
				$fullFile = PathUtil::getFull(Bag::config()->get('app.root').DS.PathUtil::convert($otp['file']).'.'.($ext ? $ext : 'php'));

				// Get content of view
				if ( !file_exists($fullFile) ) {
					throw new FileNotFoundException($fullFile);
				}

				$content = file_get_contents($fullFile);

				$namespace = "";

				foreach ( Bag::config()->get('core.otp.helpers') as $key => $value) {
					$namespace .= "use {$value} as {$key};";
				}

				foreach ( $this->helpers as $key => $value) {
					$namespace .= "use {$value} as {$key};";
				}

				file_put_contents($storageFile, "<?php {$namespace} ?>".$content);
			}

			ob_start();

			require $storageFile;

			$content = ob_get_clean();

			return $content;
		} catch (Exception $e) {
			//ob_end_clean();
			throw $e;
		}
	}
}