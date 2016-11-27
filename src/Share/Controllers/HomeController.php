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
use Src\Share\Business\SlideBusiness;
use Overfull\Utility\ArrayUtil;

class HomeController extends ShareController{
    protected $chanelBusiness;
    protected $slideBusiness;
            function __construct(){
        $this->chanelBusiness = new ChanelBusiness();
        $this->slideBusiness = new SlideBusiness();
    }
    
    /**
     * action Index method
     * @return render
     */
    public function actionIndex(){
        $chanels = $this->chanelBusiness->getAllChanels(\Bag::request()->get());
        $chanels = ArrayUtil::groupObjectByAttribute($chanels, 'category_name');
        
        // Get slide
        $slides = $this->slideBusiness->getAllSlides();
        
        return $this->render()->with(compact("chanels", "slides"))->withLastGet();
    }
}