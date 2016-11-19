<?php
/*----------------------------------------------------
* Filename: HomeController.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle users
* ----------------------------------------------------
*/
namespace Src\Share\Controllers;
use Src\Share\Controllers\ShareController;
use Src\Share\Business\ChanelBusiness;
use Overfull\Utility\ArrayUtil;

class HomeController extends ShareController{
	protected $chanelBusiness;
	function __construct(){
		$this->chanelBusiness = new ChanelBusiness();
	}

	public function index(){
            $chanels = $this->chanelBusiness->getAllChanels();
            $chanels = ArrayUtil::groupObjectByAttribute($chanels, 'category_name');
            return $this->render()->with(compact("chanels"));
	}
}