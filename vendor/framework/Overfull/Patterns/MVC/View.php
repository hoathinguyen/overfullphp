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
use Overfull\Utility\PathUtil;
use Overfull\Patterns\MVC\Exception\FileNotFoundException;
use Bag;
use Overfull\Template\Otp;

class View extends Otp implements \Overfull\Patterns\MVC\Foundation\IView{

    protected $tempBag = null;
    /***
     * Construct
     * This method set some default for view
     */
    function __construct(){
        $this->contentPath = 'Views'.DS.'Contents';
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

        foreach ($this->dataTransfer->attributes() as $key => $value){
            $this->$key = $value;
        }

        return $this->{$dataTransfer->type}($dataTransfer->get());
    }

    /**
     * Read file method
     * @param type $file
     * @param type $variables
     * @return string $content
     */
    protected function runFile($file, $variables = []){
        try{
            // Convert file
            $file = PathUtil::convert($file);
            $appRoot = Bag::config()->get('app.root');
            $ext = Bag::config()->get('core.otp-extension');

            $fullFile = PathUtil::getFull($appRoot.DS.$file.'.'.($ext ? $ext : 'php'));
            $this->tempBag = $fullFile;
            // Check if file is not exists
            if ( !file_exists($fullFile) ) {
                throw new FileNotFoundException($fullFile);
            }

            $storageFile = PathUtil::getFull('storage'.DS.'cache'.DS.'otp'.DS.base64_encode($appRoot.DS.$file).'.otp');

            if($this->useTemplate && (!file_exists($storageFile) || Bag::config()->get('core.develop'))){
                $helpers = Bag::config()->get('alias.helpers');
                $helpers = !empty($helpers) ? $helpers : [];

                $this->useClasses($helpers);
                $this->useClasses($this->helpers);

                $this->replaceTemplate($fullFile, $storageFile);

                $this->tempBag = $storageFile;
            }

            return parent::runFile($this->tempBag, $variables);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
