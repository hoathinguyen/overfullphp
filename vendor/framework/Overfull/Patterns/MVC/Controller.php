<?php
/*___________________________________________________________________________
* The Controller object class
* ___________________________________________________________________________
*/
namespace Overfull\Patterns\MVC;

use Overfull\Patterns\MVC\Foundation\IController;
use Overfull\Patterns\MVC\Exception\MethodNotFoundException;
use Bag;
use Overfull\Http\Response\ResponseFormat;
use Overfull\Patterns\MVC\ActionResult;
use Overfull\Foundation\Base\BaseObject;

abstract class Controller extends BaseObject implements IController{
	protected $layout = false;
	protected $helpers = [];
	protected $root = '';
	protected $handler = null;

	public function beforeAction(){}
	public function beforeFilter(){}
	public function beforeRender(){}

	/**
	 * Set type to view is render
	 *
	 * @param string/array $view
	 * @param mixed $data
	 * @return array
	 */
	public final function otp($name = false, $value = null){
		if(!$name){
			$otp = [
				'layout' => !empty($this->layout) ? $this->layout : false,
				'helpers' => !empty($this->helpers) ? $this->helpers : [],
				'handler' => !empty($this->hanlder) ? $this->hanlder : null,
				'root' => !empty($this->root) ? $this->root : str_replace('Controller', '', Bag::$route->controller),
				'content' => !empty($this->content) ? $this->content : Bag::$route->method
			];

			return $otp;
		}

		if(is_array($name)){
			foreach ($name as $key => $value) {
				$this->$key = $value;
			}

			return $this;
		}

		$this->$name = $value;
		return $this;
	}

	/**
	 * Set type to view is render
	 *
	 * @param string/array $view
	 * @param mixed $data
	 * @return array
	 */
	protected final function render($view = false, $data = []){
		if(is_array($view)){
			$this->layout = $view[0];
			$this->content = $view[1];
		} else if($view){
			$this->content = $view;
		}

		return new ActionResult([
			'type' => 'render',
			'gift' => [
				'otp' => $this->otp(),
				'data' => $data
			]
		]);
	}

	/**
	 * Set type to view is renderAjax
	 *
	 * @param string/array $view
	 * @param mixed $data
	 * @return array
	 */
	protected final function renderAjax($view = false, $data = []){
		$this->layout = false;

		if($view){
			$this->content = $view;
		}

		return new ActionResult([
			'type' => 'render',
			'gift' => [
				'otp' => $this->otp(),
				'data' => $data
			]
		]);
	}

	/**
	 * Set type to view is redirect
	 *
	 * @param string $url
	 * @return array
	 */
	protected final function redirect($url){
		return new ActionResult([
			'type' => 'redirect',
			'gift' => [
				'data' => $url,
				'otp' => $this->otp(),
			]
		]);
	}

	/**
	 * Set type to view is json
	 *
	 * @param mixed $data
	 * @return array
	 */
	protected final function json($data){
		return new ActionResult([
			'type' => 'json',
			'gift' => [
				'otp' => $this->otp(),
				'data' => $data,
			]
		]);
	}
	
	/**
	 * Run controller
	 *
	 * @return void
	 */
	public final function run(){
		$method = Bag::$route->method;

		if(!method_exists($this, $method)){
			throw new MethodNotFoundException($method);
		}

		// Event before
		$this->beforeFilter();

		// Get filter before

		$this->beforeAction();

		$ActionResult = $this->{$method}(Bag::route()->parameters);

		$this->beforeRender();

		if (is_a($ActionResult, ActionResult::class)){
			return $ActionResult;
		} elseif(is_array($ActionResult)){
			return new ActionResult([
					'type' => 'json',
					'gift' => [
						'otp' => $this->otp(),
						'data' => $ActionResult,
					]
				]);
		} elseif(is_object($ActionResult)){
			return new ActionResult($ActionResult->run());
		} else{
			return new ActionResult([
				'type' => 'html',
				'gift' => [
					'otp' => $this->otp(),
					'data' => $ActionResult,
				]
			]);
		}
	}
}