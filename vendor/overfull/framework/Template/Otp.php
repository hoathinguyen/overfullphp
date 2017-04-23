<?php
/*----------------------------------------------------
* Filename: Otp.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle otp
* ----------------------------------------------------
*/
namespace Overfull\Template;
use Overfull\Http\Response\ResponseFormat;
use Overfull\Http\Response\Response;
use Overfull\Support\Utility\URLUtil;
use Bag;

abstract class Otp{
    protected $tags = [
        // Foreach
        "/@foreach\((.*?)as(.*?)\)/" => '<?php foreach($1as$2): ?>',
        '/@endforeach/' => '<?php endforeach; ?>',

        '/\<:foreach(\s.*?)exp=(.*)\>/' => '<?php foreach($2): ?>',
        '/\<\/:foreach\>/' => '<?php endforeach; ?>',

        // For
        "/@for\((.*?)\)/" => '<?php for($1): ?>',
        '/@endfor/' => '<?php endfor; ?>',

        '/\<:for(\s.*?)exp=(.*)\>/' => '<?php for($2): ?>',
        '/\<\/:for\>/' => '<?php endfor; ?>',

        // If
        "/@if\((.*)\)/" => '<?php if($1): ?>',
        '/@elseif\((.*)\)/' => '<?php elseif($1): ?>',
        '/@else/' => '<?php else: ?>',
        '/@endif/' => '<?php endif; ?>',

        '/\<:if(\s.*?)exp=(.*)\>/' => '<?php if($2): ?>',
        '/\<:elseif(\s.*?)exp=(.*)\>/' => '<?php elseif($2): ?>',
        '/\<:else\>/' => '<?php else: ?>',
        '/\<\/:if\>/' => '<?php endif; ?>',

        // echo 
        '/\{\{/' => '<?php echo ',
        '/\}\}/' => '?>',

        '/\<\:echo\>/' => '<?php echo ',
        '/\<\/:echo\>/' => '?>',

        // echo array
        '/\{\[/' => '<?php print_r( ',
        '/\]\}/' => '); ?>',

        '/\<\:echoArray\>/' => '<?php print_r( ',
        '/\<\/:echoArray\>/' => '); ?>',

        // area
        '/@beginArea\((.*)\)/' => '<?php $this->beginArea($1); ?>',
        '/@endArea/' => '<?php $this->endArea($1); ?>',
        '/@readArea\((.*)\)/' => '<?php echo $this->readArea($1); ?>',
        
        '/\<\!\-\-BEGIN\[(.*)\]\-\-\>/' => '<?php $this->beginArea("$1"); ?>',
        '/\<\!\-\-END\-\-\>/' => '<?php $this->endArea("$1"); ?>',
        '/\<\!\-\-AREA\[(.*)\]\-\-\>/' => '<?php echo $this->readArea("$1"); ?>',

        '/\<:area(\s.*?)name=(.*)\>/' => '<?php $this->beginArea($2); ?>',
        '/\<\/:area\>/' => '<?php $this->endArea(); ?>',
        '/\<:readArea(\s.*?)name=(.*)\/\>/' => '<?php echo $this->readArea($2); ?>',

        // append
        '/@appendTo\((.*)\)/' => '<?php $this->appendTo($1); ?>',
        '/@append\((.*)\)/' => '<?php echo $this->append($1); ?>',

        '/\<:layout(\s.*?)src=(.*)\/\>/' => '<?php $this->appendTo($2); ?>',
        '/\<:append(\s.*?)src=(.*)\/\>/' => '<?php echo $this->append($2); ?>',

        '/\<:append(\s.*?)src=(.*)\>/' => '<?php echo $this->append($2, [',
        '/\<:param(\s.*?)name=(.*?)\>/' => '$2 => ',
        '/\<\/:param\>/' => ',',
        '/\<\/:append\>/' => ']);?>',

        // PHP
        '/\<\:php\>/' => '<?php ',
        '/\<\/:php\>/' => ' ?>'
    ];

    protected $currentAreaName = '';
    protected $areas = [];
    protected $contentPath = null;
    protected $appendFile = null;
    protected $useTemplate = true;
    protected $useClasses = [];

    public function useClasses($classes){
        $this->useClasses = array_merge($this->useClasses, $classes);
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
    protected function redirect($gift){
        Bag::$response->format = ResponseFormat::HTML;
        $html = '<!DOCTYPE html>
                        <html><head><meta charset="utf-8"><title>'.\Bag::config()->get('core.otp-redirect-title').'</title><meta http-equiv="refresh" content="0; url='.URLUtil::to($gift).'" /></head><body></body></html>';

        return $html;
    }

    /**
     * Handle view with json
     *
     * @date 2016/05/21
     * @param mixed $gift
     * @return string
     */
    protected function json($gift){
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
    protected function html($gift){
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
    protected function xml($gift){
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
    protected function file($gift){
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
    protected function append($file, $variables = []){
        return $this->runFile(($this->contentPath ? $this->contentPath.DS : '').$file, $variables);
    }

    /**
     * Begin area
     * @param type $name
     * @param type $data
     */
    protected function beginArea($name){
        ob_start();
        $this->currentAreaName = $name;
        return $this;
    }

    /**
     * End area
     * @return string
     */
    protected function endArea(){
        $result = ob_get_clean();
        $this->areas[$this->currentAreaName] = $result;
        return $this;
    }

    /**
     * Read area
     * @param type $name
     * @return type
     */
    protected function readArea($name){
        return isset($this->areas[$name]) ? $this->areas[$name] : null;
    }

    /**
     * Replace template method
     * @param type $file
     * @return $fileContent
     */
    protected function replaceTemplate($file, $toFile){
        $fileContent = file_get_contents($file);
        foreach ($this->tags as $key => $value) {
            $fileContent = preg_replace($key, $value, $fileContent);
        }

        $namespace = "";

        foreach ( $this->useClasses as $key => $value) {
            $namespace .= "use {$value} as {$key}; ";
        }

        file_put_contents($toFile, "<?php {$namespace} ?>".$fileContent);

        return $toFile;
    }

    /**
     * runTemplate
     * @param type $file
     * @param type $variables
     * @return string Content after run
     */
    protected function runFile($file, $variables = []){
        // Create variable
        foreach ($variables as $key => $value) {
            $$key = $value;
        }

        ob_start();

        require $file;

        return ob_get_clean();
   }
}
