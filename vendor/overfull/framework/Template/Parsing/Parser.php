<?php
/**
 * Parser object
 * This class parse View syntax to php syntax
 */
namespace Overfull\Template\Parsing;

class Parser
{
    // Tags to parser
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
    
    /**
     * Replace template method
     * @param type $file
     * @return $fileContent
     */
    public function replaceTemplate($file, $toFile, $moreContents = [])
    {
        $fileContent = file_get_contents($file);
        foreach ($this->tags as $key => $value) {
            $fileContent = preg_replace($key, $value, $fileContent);
        }
        
        $namespace = "";
        
        if(isset($moreContents['useClasses'])){
            foreach ($moreContents['useClasses'] as $key => $value) {
                $namespace .= "use {$value} as {$key}; ";
            }
        }

        file_put_contents($toFile, "<?php {$namespace} ?>".$fileContent);

        return $toFile;
    }
}
