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

class Controller implements IController{
	protected $otp = [
		'layout' => false,
		'helpers' => [],
		'root' => '',
		'handler' => null
	];

	public function beforeAction(){}
	public function beforeFilter(){}
	public function beforeRender(){}

	protected final function __getOtp(){
		$otp = [
			'layout' => !empty($this->otp['layout']) ? $this->otp['layout'] : false,
			'helpers' => !empty($this->otp['helpers']) ? $this->otp['helpers'] : [],
			'handler' => !empty($this->otp['handler']) ? $this->otp['handler'] : null,
			'root' => !empty($this->otp['root']) ? $this->otp['root'] : str_replace('Controller', '', Bag::$route->controller),
			'content' => !empty($this->otp['content']) ? $this->otp['content'] : Bag::$route->method
		];

		return $otp;
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
			$this->otp['layout'] = $view[0];
			$this->otp['content'] = $view[1];
		} else if($view){
			$this->otp['content'] = $view;
		}

		return new ActionResult([
			'type' => 'render',
			'gift' => [
				'otp' => $this->__getOtp(),
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
		$this->otp['layout'] = false;

		if($view){
			$this->otp['content'] = $view;
		}

		return new ActionResult([
			'type' => 'render',
			'gift' => [
				'otp' => $this->__getOtp(),
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
				'otp' => $this->__getOtp(),
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
				'otp' => $this->__getOtp(),
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
						'otp' => $this->__getOtp(),
						'data' => $ActionResult,
					]
				]);
		} elseif(is_object($ActionResult)){
			return new ActionResult($ActionResult->run());
		} else{
			return new ActionResult([
				'type' => 'html',
				'gift' => [
					'otp' => $this->__getOtp(),
					'data' => $ActionResult,
				]
			]);
		}
	}
}