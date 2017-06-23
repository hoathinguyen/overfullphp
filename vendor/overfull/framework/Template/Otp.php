<?php
/*----------------------------------------------------
* Filename: Otp.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle otp
* ----------------------------------------------------
*/
namespace Overfull\Template;
use Overfull\Http\Response\Constant;
use Overfull\Support\Utility\UrlUtil;
use Overfull\Support\Utility\PathUtil;
use Overfull\Patterns\MVC\Exception\FileNotFoundException;
use Bag;

abstract class Otp
{
    // Area name
    protected $currentAreaName = '';
    
    // Areas
    protected $areas = [];
    
    // Content path
    protected $contentPath = null;
    
    // Append file
    protected $appendFile = null;
    
    // Use template
    protected $useTemplate = true;
    
    // Parser
    protected $parser = null;
    
    /**
     * __construct
     */
    public function __construct()
    {
        $this->parser = new \Overfull\Template\Parsing\Parser();
    }

    /**
     * Append to
     * @param type $file
     * @return this
     */
    public function appendTo($file)
    {
        $this->appendFile = $file;
        return $this;
    }
    /**
     * Render
     * @param type $file
     * @param type $variables
     */
    protected function render($file, $variables = [])
    {        
        if(!Bag::response()->getHeader('Content-Type')){
            Bag::response()->setHeader('Content-Type', Constant::CONTENT_TYPE_HTML);
        }

        if(Bag::response()->isFormat('')){
            Bag::response()->setFormat(Constant::FORMAT_TEXT);
        }
        
        // Check if the file is array
        if(is_array($file)){
            $this->variables = $file;
            Bag::response()->setContent($this->recursive($this->file, $this->variables));
        }
        else{
            $this->variables = $variables;
            Bag::response()->setContent($this->recursive($file, $this->variables));
        }
        
        return $this;
    }

    /**
     * Handle view as redirect
     *
     * @date 2016/05/21
     * @param mixed $gift
     * @return string
     */
    protected function redirect($gift)
    {   
        if(!Bag::response()->getHeader('Content-Type')){
            Bag::response()->setHeader('Content-Type', Constant::CONTENT_TYPE_HTML);
        }
        
        if(Bag::response()->isFormat('')){
            Bag::response()->setFormat(Constant::FORMAT_TEXT);
        }
        
        $html = '<!DOCTYPE html>
                        <html><head><meta charset="utf-8"><title>'.\Bag::config()->get('core.otp-redirect-title').'</title><meta http-equiv="refresh" content="0; url='.UrlUtil::to($gift).'" /></head><body></body></html>';

        Bag::response()->setContent($html);
        return $this;
    }

    /**
     * Handle view with json
     *
     * @date 2016/05/21
     * @param mixed $gift
     * @return string
     */
    protected function json($gift)
    {
        if(!Bag::response()->getHeader('Content-Type')){
            Bag::response()->setHeader('Content-Type', Constant::CONTENT_TYPE_JSON);
        }
        
        if(Bag::response()->isFormat('')){
            Bag::response()->setFormat(Constant::FORMAT_TEXT);
        }
        
        Bag::response()->setContent(json_encode($gift));
        return $this;
    }

    /**
     * Hanlde view and return view as text
     *
     * @date 2016/05/21
     * @param mixed $gift
     * @return string
     */
    protected function html($gift)
    {
        if(!Bag::response()->getHeader('Content-Type')){
            Bag::response()->setHeader('Content-Type', Constant::CONTENT_TYPE_HTML);
        }
        
        if(Bag::response()->isFormat('')){
            Bag::response()->setFormat(Constant::FORMAT_TEXT);
        }
        
        Bag::response()->setContent($gift);
        return $this;
    }

    /**
     * Hanlde view and return value as xml
     *
     * @date 2016/05/21
     * @param mixed $gift
     * @return string
     */
    protected function xml($gift)
    {
        if(!Bag::response()->getHeader('Content-Type')){
            Bag::response()->setHeader('Content-Type', Constant::CONTENT_TYPE_XML);
        }
        
        if(Bag::response()->isFormat('')){
            Bag::response()->setFormat(Constant::FORMAT_TEXT);
        }
        
        Bag::response()->setContent($gift);
        return $this;
    }

    /**
     * __file method
     *
     * @date 2016/05/21
     * @param mixed $gift
     * @return string
     */
    protected function file($data)
    {
        Bag::response()->fileName = $data['info']['Name'];
        unset($data['info']['Name']);
        
        foreach($data['info'] as $key => $value)
        {
            Bag::response()->setHeader($key, $value);
        }

        if(Bag::response()->isFormat('')){
            Bag::response()->setFormat(Constant::FORMAT_FILE);
        }

        Bag::response()->setContent($data['content']);
        
        return $this;
    }

    /**
     * recursive method
     * This method will be call recursive the file
     * @param type $name Description
     * @return $this;
     */
    protected function recursive($file, $variables = [])
    {
        // read view
        $__content = $this->runFile(($this->contentPath ? $this->contentPath.DS : '').(!empty($this->root) ? $this->root.DS : '' ).$file, $variables);

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
    protected function append($file, $variables = [])
    {
        return $this->runFile(($this->contentPath ? $this->contentPath.DS : '').$file, $variables);
    }

    /**
     * Begin area
     * @param type $name
     * @param type $data
     */
    protected function beginArea($name)
    {
        ob_start();
        $this->currentAreaName = $name;
        return $this;
    }

    /**
     * End area
     * @return string
     */
    protected function endArea()
    {
        $result = ob_get_clean();
        $this->areas[$this->currentAreaName] = $result;
        return $this;
    }

    /**
     * Read area
     * @param type $name
     * @return type
     */
    protected function readArea($name)
    {
        return isset($this->areas[$name]) ? $this->areas[$name] : null;
    }
    
    /**
     * runTemplate
     * @param type $file
     * @param type $variables
     * @return string Content after run
     */
    protected function runFile($file, $variables = [])
    {
        try{
            // Convert file
            $file = PathUtil::convert($file);
            $appRoot = Bag::config()->get('app.root');
            $ext = Bag::config()->get('core.otp-extension');

            $fullFile = PathUtil::getFull($appRoot.DS.$file.'.'.($ext ? $ext : 'php'));

            // Check if file is not exists
            if ( !file_exists($fullFile) ) {
                throw new FileNotFoundException($fullFile);
            }

            $storageFile = PathUtil::getFull('storage'.DS.'cache'.DS.'otp'.DS.base64_encode($appRoot.DS.$file).'.otp');
            if($this->useTemplate){
                $this->tempBag = $storageFile;
            } else {
                $this->tempBag = $fullFile;
            }


            if($this->useTemplate && (!file_exists($storageFile) || Bag::config()->get('core.develop'))){

                $helpers = Bag::config()->get('alias.helpers');
                $helpers = !empty($helpers) ? $helpers : [];

                $this->parser->replaceTemplate($fullFile, $storageFile, [
                    'useClasses' => array_merge($helpers, $this->helpers)
                ]);
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
