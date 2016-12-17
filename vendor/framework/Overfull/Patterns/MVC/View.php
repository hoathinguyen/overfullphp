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
use Overfull\Utility\URLUtil;
use Overfull\Patterns\MVC\Exception\FileNotFoundException;
use Overfull\Configure\Config;
use Overfull\Http\Response\ResponseFormat;
use Overfull\Http\Response\Response;
use Bag;
use Overfull\Template\Otp;

class View extends Otp implements \Overfull\Patterns\MVC\Foundation\IView{
    protected $contentPath = null;
    protected $appendFile = null;
    protected $useTemplate = true;


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
     * Append to
     * @param type $file
     * @return this
     */
    public function appendTo($file){
        $this->appendFile = $file;
        return $this;
    }
    /**
     * Render
     * @param type $file
     * @param type $variables
     */
    protected function render($file, $variables = []){
        // Check if the file is array
        if(is_array($file)){
            $this->variables = $file;
            return $this->recursive($this->file, $this->variables);
        }
        
        $this->variables = $variables;
        return $this->recursive($file, $this->variables);
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
                        <html><head><title>Redirecting...</title><meta http-equiv="refresh" content="0; url='.URLUtil::to($gift).'" /></head><body></body></html>';

        return $html;
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
        return json_encode($gift);
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
        return $gift;
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
     * recursive method
     * This method will be call recursive the file
     * @param type $name Description
     * @return $this;
     */
    protected function recursive($file, $variables = []){
        // read view
        $__content = $this->readFile($this->contentPath.DS.(!empty($this->root) ? $this->root.DS : '' ).$file, $variables);
        
        $__appendFile = $this->appendFile;
        $this->appendFile = null;
        
        if($__appendFile){
            $__content = $this->recursive($__appendFile, $variables);
        }
        
        return $__content;
    }
    /**
     * Render
     * @param type $file
     * @param type $variables
     */
    protected function append($file, $variables = []){
        return $this->readFile($this->contentPath.DS.$file, $variables);
    }
    
    /**
     * Read file method
     * @param type $file
     * @param type $variables
     * @return string $content
     */
    protected function readFile($file, $variables = []){
        try{            
            // Convert file
            $file = PathUtil::convert($file);
            $appRoot = Bag::config()->get('app.root');
            $ext = Bag::config()->get('core.otp.ext');
            
            $fullFile = PathUtil::getFull($appRoot.DS.$file.'.'.($ext ? $ext : 'php'));
            $this->tempBag = $fullFile;
            // Check if file is not exists
            if ( !file_exists($fullFile) ) {
                throw new FileNotFoundException($fullFile);
            }
            
            $storageFile = PathUtil::getFull('storage'.DS.'cache'.DS.'otp'.DS.base64_encode($appRoot.DS.$file).'.otp');

            if($this->useTemplate && (!file_exists($storageFile) || Bag::config()->get('core.develop'))){
                $fileContent = file_get_contents($fullFile);
                foreach ($this->tags as $key => $value) {
                    $fileContent = preg_replace($key, $value, $fileContent);
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

                file_put_contents($storageFile, "<?php {$namespace} ?>".$fileContent);
                
                $this->tempBag = $storageFile;
            }
            
            // Create variable
            foreach ($variables as $key => $value) {
                $$key = $value;
            }
            
            ob_start();

            require $this->tempBag;

            return ob_get_clean();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}