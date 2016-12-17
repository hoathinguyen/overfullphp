<?php
/*----------------------------------------------------
* Filename: Otp.php
* Author: Overfull.net
* Date: 2016/10/25
* Description: The controller to handle otp
* ----------------------------------------------------
*/
namespace Overfull\Template;

class Otp{
    protected $tags = [
            // Create section
            "/@beginSection\(([a-zA-Z0-9\"\'\-_]+?)\)(.*)/" => '<?php $this->setSection($1, function()$2{ ?>',
            "/@endSection/" => '<?php }); ?>',

            // Use section
            "/@yield\(([a-zA-Z0-9\"\'\-_]+)\)/" => '<?php echo $this->getSection($1); ?>',

            // Foreach
            "/@foreach\((.*?)as(.*?)\)/" => '<?php foreach($1as$2): ?>',
            '/@endforeach/' => '<?php endforeach; ?>',

            // If
            "/@if\((.*)\)/" => '<?php if($1): ?>',
            '/@elseif\((.*)\)/' => '<?php elseif($1): ?>',
            '/@else/' => '<?php else: ?>',
            '/@endif/' => '<?php endif; ?>',

            '/\{\{/' => '<?php echo ',
            '/\}\}/' => '?>',

            '/\{\[/' => '<?php print_r( ',
            '/\]\}/' => '); ?>',

            '/@beginArea\((.*)\)/' => '<?php $this->beginArea($1); ?>',
            '/@endArea/' => '<?php $this->endArea($1); ?>',
            '/@readArea\((.*)\)/' => '<?php echo $this->readArea($1); ?>'
    ];

    protected $sections = [];
    
    protected $currentAreaName = '';
    protected $areas = [];

    /**
     * Set or get section
     *
     * @param string $name
     * @param string $value
     * @return section
     */
    protected function setSection($name = null, $value = null){
            $this->sections[$name] = $value;
    }

    /**
     * Set or get section
     *
     * @param string $name
     * @param string $value
     * @return section
     */
    protected function getSection($name = null){
            if(!isset($this->sections[$name])){
                    return;
            }

            $value = $this->sections[$name];
            return $value();
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
}