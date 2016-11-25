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
    
    /**
     * action Index method
     * @return render
     */
    public function actionIndex(){
        $chanels = $this->chanelBusiness->getAllChanels(\Bag::request()->get());
        $chanels = ArrayUtil::groupObjectByAttribute($chanels, 'category_name');
        return $this->render()->with(compact("chanels"));
    }
}