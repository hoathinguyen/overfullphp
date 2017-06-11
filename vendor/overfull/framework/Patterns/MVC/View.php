<?php
/**
 * View.php
 * View object class
 * This object handle the view of site
 *
 * @author overfull.net
 * @date 2016/01/01
 */
namespace Overfull\Patterns\MVC;

use Overfull\Patterns\MVC\Exception\ViewTypeNotFoundException;
use Overfull\Template\Otp;

class View extends Otp implements \Overfull\Patterns\MVC\Foundation\IView
{
    protected $tempBag = null;
    
    /***
     * Construct
     * This method set some default for view
     */
    function __construct()
    {
        parent::__construct();
        $this->contentPath = 'Views'.DS.'Render';
    }

    /**
     * Run method
     * This method will be call from Handle pattern
     * @param DataTransfer $dataTransfer
     * @return this
     */
    public function run($dataTransfer){
        // Check if view type is exist
        if(!method_exists($this, $dataTransfer->type)){
            throw new ViewTypeNotFoundException($dataTransfer->type);
        }

        $this->dataTransfer = $dataTransfer;

        foreach ($this->dataTransfer->getAttributes() as $key => $value){
            $this->$key = $value;
        }

        $this->{$dataTransfer->type}($dataTransfer->get());
        return $this;
    }
}
